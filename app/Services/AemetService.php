<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

//Creamos una clase dedicada para hacer peticiones a la api de AEMT
class AemetService
{
    //Esta api se caracteriza por hacer 2 llamadas: para pedir la URL y para pedir los datos
    //Creamos una clase que contenga 2 atributos
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        // A dichos atribtios le asignamos:
        $this->apiKey = config('services.aemet.key'); //la clave desde el archivo config/services.php
        $this->baseUrl = 'https://opendata.aemet.es/opendata/api'; //la url donde hacer la petición
    }

    /**
     * ESta función por defecto obtiene la información del muncipio Málaga (Málaga)
     */
    public function getPrediccion(string $codigoMunicipio = '29067')
    {
        //Definimos una clave única para la caché
        $claveCache = 'aemet_prediccion_' . $codigoMunicipio;

        //Si los datos ya están en la caché se devuelven directamente (Early Return)
        if ($datosEnCache = Cache::get($claveCache)) {
            return $datosEnCache;
        }

        //Creamos una variable que la devolvermos con el resultado final 
        $respuesta = null;

        // En caso negativo hacemos peticiones a AEMET
        // Construimos la URL con los datos de la key y el codigo postal del municipio
        $urlMetadatos = "{$this->baseUrl}/prediccion/especifica/municipio/diaria/{$codigoMunicipio}?api_key={$this->apiKey}";

        //Pedimos la url a la AEMET (get porque los datos van en la dirección del navegador)
        //usamos la clase guzzle de laravel para hacer peticiones a otras webs
        $respuestaMetadatos = Http::get($urlMetadatos);

        // En el caso de que no tengamos éxito en la petición
        if ($respuestaMetadatos->failed() || !isset($respuestaMetadatos['datos'])) {
            Log::error('AEMET: Error al obtener los metadatos. Código HTTP: ' . $respuestaMetadatos->status());
            $respuesta = null;
            //En el caso de tener éxito en la peticion
        } else {
            //Guardamos los datos reales
            $urlDatosReales = $respuestaMetadatos['datos'];

            //Una vez tengamos los datos reales los darcargamos
            $respuestaDatos = Http::get($urlDatosReales);

            //Y comprobamos si hemos tenido éxito o no
            if ($respuestaDatos->failed()) {
                Log::error('AEMET: Error al descargar los datos reales. Código HTTP: ' . $respuestaDatos->status());
                $respuesta = null;
            } else {
                // Quitamos los espacios en blanco y saltos de línea sobrantes del principio y del final del texto.
                $contenidoCrudo = trim($respuestaDatos->body());
                //eliminamos las marcas de orden de bytes que AEMET pone en su archivo json 
                $contenidoCrudo = preg_replace('/^\xEF\xBB\xBF/', '', $contenidoCrudo);
                // Forzamos a que todo el texto se interprete en UTF-8.an leer
                $contenidoCrudo = mb_convert_encoding($contenidoCrudo, 'UTF-8', 'UTF-8');
                //Si encuentra cualquier otro carácter lo que hace es ignorarlo
                $contenidoCrudo = iconv('UTF-8', 'UTF-8//IGNORE', $contenidoCrudo); 
                //Una vez hayamos limpitado todo lo convertimos en un array asociativo de PHP.
                $datos = json_decode($contenidoCrudo, true);

                // Si aun asi no se ha podido descodificar el json guardamos un log
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('AEMET: Error al decodificar el JSON: ' . json_last_error_msg());
                    $respuesta = null;
                } else {
                    // La predicción del municipio solicitado está en la posición 0
                    if (isset($datos[0]['prediccion']['dia'][0])) {
                        //De tos los dias de la semana nos quedamos con el de fecha actual
                        //Aemet devuelve un array de 7 dias, nosotros solo queremos el primer dia
                        $diaHoy = $datos[0]['prediccion']['dia'][0];
                        //buscamos los datos que queremos
                        $respuesta = [
                            'temp_max' => $diaHoy['temperatura']['maxima'] ?? '--',
                            'temp_min' => $diaHoy['temperatura']['minima'] ?? '--',
                            // Buscamos el primer elemento de la descripción que no esté vacio
                            'estado'   => data_get(collect($diaHoy['estadoCielo'] ?? [])->firstWhere('descripcion', '!=', ''), 'descripcion', 'Desconocido'),
                            // Buscamos la velocidad del viento. la primera que sea mayor a 0   
                            //Usamos el helper data_get() que permite acceder a las claves de un array 
                            // de forma segura; permite devolver 1 valor por defecto si el array es nulo
                            'viento'   => data_get(collect($diaHoy['viento'] ?? [])->firstWhere('velocidad', '>', 0), 'velocidad', 0),
                            
                            //datos de viento, lluvia, humedad y sensación térmica
                            'direccion_viento' => data_get(collect($diaHoy['viento'] ?? [])->firstWhere('velocidad', '>', 0), 'direccion', 'N/A'),
                            'racha_max' => data_get(collect($diaHoy['rachaMax'] ?? [])->firstWhere('value', '>', 0), 'value', 0),
                            'prob_lluvia' => data_get(collect($diaHoy['probPrecipitacion'] ?? [])->firstWhere('value', '>', 0), 'value', 0),
                            'humedad_max' => $diaHoy['humedadRelativa']['maxima'] ?? '--',
                            'sens_termica' => $diaHoy['sensTermica']['maxima'] ?? '--',
                            
                            // Formateamos la fecha para que no salga la hora 
                            'fecha'    => isset($diaHoy['fecha']) ? \Carbon\Carbon::parse($diaHoy['fecha'])->format('Y-m-d') : now()->format('Y-m-d')
                        ];
                    } else {
                        Log::error('AEMET: La estructura de los datos devueltos no es la esperada.');
                        $respuesta = null;
                    }
                }
            }
        }

        // Solo guardamos en caché si la respuesta no es nula (si hubo éxito)
        if ($respuesta !== null) {
            Cache::put($claveCache, $respuesta, 1800);
        }

        //Sea cual sea la respuesta la devolvemos
        return $respuesta;
    }
}