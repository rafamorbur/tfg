<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Embarcacion;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 

class EmbarcacionController extends Controller
{
    //****************************************************
    //funcion para guardar una nueva embarcación
    //****************************************************
    public function store(Request $request)
    {
        // Creamos el validor; a partir de el verificamso que se cumplen las reglas
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'matricula' => 'required|string|max:50|unique:embarcacion,matricula',
            'eslora' => 'required|numeric|min:0',
            'manga' => 'required|numeric|min:0',
            'calado' => 'required|numeric|min:0',
            'tipo' => 'nullable|string|max:50',
        ], [
            //en caso de no cumplirse lanzamos errores personalizados
            'matricula.unique' => 'Esta matrícula ya está registrada en el sistema.',
            'nombre.required' => 'El nombre del barco es obligatorio.',
            'eslora.required' => 'La eslora es obligatoria.',
            'manga.required' => 'La manga es obligatoria.',
            'calado.required' => 'El calado es obligatorio.',
        ]);

        //si hay algun error lo mostramos y volvemos al formulario inmediatamente
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Creamos el barco si todo va bien 
        $barco = Embarcacion::create([
            'nombre' => $request->nombre,
            'matricula' => strtoupper($request->matricula),
            'eslora' => $request->eslora,
            'manga' => $request->manga,
            'calado' => $request->calado,
            'tipo' => $request->tipo,
        ]);

        //asociamos el barco al usuario
        Auth::user()->embarcaciones()->attach($barco->id_embarcacion, [
            'rol' => 'propietario'
        ]);

        //redirigimos
        return redirect()->route('cliente.dashboard')
            ->with('success', '¡Embarcación añadida con éxito!');
    }

    //****************************************************
    //funcion para editar una embarcación existente
    //****************************************************
    //laravel recibe los datos para editar a través de la clase Request además del identificar del barco
    public function update(Request $request, $id)
    {
        // Verificamos que exista el barco. 
        $barco = Embarcacion::findOrFail($id);

        // además comprobamos que el barco pertenece al usuario
        if (!Auth::user()->embarcaciones->contains($barco->id_embarcacion)) {
            return back()->withErrors(['error' => 'No tienes permiso para modificar esta embarcación.']);
        }

        // Creamos el validador; en este caso la matrícula debe ser única excepto para este barco
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'matricula' => 'required|string|max:50|unique:embarcacion,matricula,' . $id . ',id_embarcacion',
            'eslora' => 'required|numeric|min:0',
            'manga' => 'required|numeric|min:0',
            'calado' => 'required|numeric|min:0',
            'tipo' => 'nullable|string|max:50',
        ], [
            //en caso de no cumplirse lanzamos errores personalizados
            'matricula.unique' => 'Esta matrícula ya está registrada en el sistema.',
            'nombre.required' => 'El nombre del barco es obligatorio.',
            'eslora.required' => 'La eslora es obligatoria.',
            'manga.required' => 'La manga es obligatoria.',
            'calado.required' => 'El calado es obligatorio.',
        ]);

        //si hay algun error lo mostramos y volvemos al formulario inmediatamente
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Actualizamos los datos del barco
        $barco->update([
            'nombre' => $request->nombre,
            'matricula' => strtoupper($request->matricula),
            'eslora' => $request->eslora,
            'manga' => $request->manga,
            'calado' => $request->calado,
            'tipo' => $request->tipo,
        ]);

        //redirigimos
        return redirect()->route('cliente.dashboard')
            ->with('success', '¡Embarcación modificada con éxito!');
    }

    //****************************************************
    //funcion para eliminar una embarcación existente
    //****************************************************
    public function destroy($id)
    {
        // Buscamos el barco por su ID que nos devolverá un error en caso de no existir
        $barco = Embarcacion::findOrFail($id);

        // comprobamos que el barco pertenece al usuario
        if (!Auth::user()->embarcaciones->contains($barco->id_embarcacion)) {
            return back()->withErrors(['error' => 'No tienes permiso para eliminar esta embarcación.']);
        }

        //no podemos eliminar un barco si tiene reservas activas
        $tieneReservas = Reserva::where('id_embarcacion', $id)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->exists();

        if ($tieneReservas) {
            return back()->withErrors(['error' => 'No puedes eliminar este barco porque tiene reservas activas.']);
        }

        // el barco deja de pertenecer al usuario (en la tabla usuario_embarcación)
        $barco->usuarios()->detach();
        
        // Borramos el barco de la base de datos
        $barco->delete();

        //redirigimos
        return redirect()->route('cliente.dashboard')
            ->with('success', '¡Embarcación eliminada con éxito!');
    }
}