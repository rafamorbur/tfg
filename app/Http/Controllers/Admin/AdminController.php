<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserva;
use App\Models\Amarre; 
use App\Models\User;

class AdminController extends Controller
{   
    //Método para mostrar las reservas
    public function index()
    {
        $usuario = Auth::user();

        // Mostramos las RESERVAS PENDIENTES
        //Primero verificamos el rol
        if ($usuario->id_rol == 3) {
            // si es rol admin verá todas las reservas pendentes
            $reservasPendientes = Reserva::with(['usuario', 'embarcacion', 'amarre.muelle'])
                ->where('estado', 'pendiente')
                ->orderBy('fecha_entrada', 'asc')
                ->get();
        } else {
            // si es empleado solo verá las reservas de su muelle
            $reservasPendientes = Reserva::with(['usuario', 'embarcacion', 'amarre.muelle'])
                ->where('estado', 'pendiente')
                //de todas las reservas solo cogemos aquellas cuyo amarre asociado pertenezca
                //al id_muelle del usuario logueado
                ->whereRelation('amarre', 'id_muelle', $usuario->id_muelle)
                ->orderBy('fecha_entrada', 'asc')
                ->get();
        }

        // Mostramos el historial de reservas:
        if ($usuario->id_rol == 3) {
            //si es admin verá todo el historial
            $reservasHistorial = Reserva::with(['usuario', 'embarcacion', 'amarre.muelle'])
                ->whereIn('estado', ['confirmada', 'cancelada'])
                ->orderBy('fecha_entrada', 'desc')
                ->get();
        } else {
            // Si es empleado solo verá el historial de su muelle
            $reservasHistorial = Reserva::with(['usuario', 'embarcacion', 'amarre.muelle'])
                ->whereIn('estado', ['confirmada', 'cancelada'])
                ->whereRelation('amarre', 'id_muelle', $usuario->id_muelle)
                ->orderBy('fecha_entrada', 'desc')
                ->get();
        }

        //Amarres
        if ($usuario->id_rol == 3) {
            $amarres = Amarre::with('muelle')->orderBy('id_muelle')->orderBy('numero')->get();
            
            // si es admin cargamos todos los usuarios
            $usuarios = User::orderBy('id_rol', 'asc')->get();
        } else {
            $amarres = Amarre::where('id_muelle', $usuario->id_muelle)
                ->with('muelle')
                ->orderBy('numero')
                ->get();
                
            // Si es empleado, no ve la lista de usuarios
            $usuarios = [];
        }

        // enivamos las 4 variables a una única vista
        return view('admin.backoffice', compact('reservasPendientes', 'reservasHistorial', 'amarres', 'usuarios'));
    }

    
    //Método para gestionar las reservas
    public function aceptarReserva($id)
    {   
        //primero comprobamos si la reserva existe
        $reserva = Reserva::findOrFail($id);
        
        // comprobamos que si es empleado, la reserva pertenezca a su muelle
        $usuario = Auth::user();
        if ($usuario->id_rol === 2 && $reserva->amarre->id_muelle !== $usuario->id_muelle) {
            return back()->withErrors(['error' => 'No tienes permiso para gestionar reservas de otro muelle.']);
        }

        // cambiamos su estado
        $reserva->update(['estado' => 'confirmada']);

        //devolvemos la vista con un mensaje de éxito
        return back()->with('success', "La reserva {$reserva->codigo_reserva} ha sido confirmada con éxito.");
    }

    //Método para denergar las reservas
    public function denegarReserva($id)
    {   
        //primero comprobamos si la reserva existe
        $reserva = Reserva::findOrFail($id);

        //  comprobamos que si es empleado, la reserva pertenezca a su muelle
        $usuario = Auth::user();
        if ($usuario->id_rol === 2 && $reserva->amarre->id_muelle !== $usuario->id_muelle) {
            return back()->withErrors(['error' => 'No tienes permiso para gestionar reservas de otro muelle.']);
        }

        // cambiamos su estado
        $reserva->update(['estado' => 'cancelada']);

        //devolvemos la vista con un mensaje de éxito
        return back()->with('success', "La reserva {$reserva->codigo_reserva} ha sido denegada.");
    }

    
    //método para gestionar amarres
    public function actualizarEstadoAmarre(Request $request, $id)
    {   
        //validamos que el estado pertenezca a una de las opciones permitidas
        $request->validate([
            'estado' => 'required|in:disponible,ocupado,mantenimiento'
        ]);

        //recuperamos el modelo
        $amarre = Amarre::findOrFail($id);

        // comprobamso que si es empleado el amarre pertenezca al muelle
        $usuario = Auth::user();
        if ($usuario->id_rol === 2 && $amarre->id_muelle !== $usuario->id_muelle) {
            return back()->withErrors(['error' => 'No tienes permiso para modificar amarres de otro muelle.']);
        }

        //actualizamos el estado
        $amarre->update(['estado' => $request->estado]);

        //devolvemos mensaje de éxito
        return back()->with('success', "El estado del amarre {$amarre->numero} se ha actualizado a " . ucfirst($request->estado) . ".");
    }

    //método para actualizar el rol de un usuario
    public function actualizarRol(Request $request, $id)
    {
        // Comprobamos que es Admin (Rol 3)
        if (Auth::user()->id_rol !== 3) {
            return back()->withErrors(['error' => 'Solo el administrador puede cambiar roles.']);
        }

        //validamos que el rol sea uno de los permitidos (1=cliente, 2=empleado, 3=admin)
        $request->validate([
            'id_rol' => 'required|in:1,2,3'
        ]);

        //recuperamos el usuario
        $usuario = User::findOrFail($id);
        
        // Evitamos que el admin se quite su propio rol
        if ($usuario->id_usuario === Auth::id()) {
            return back()->withErrors(['error' => 'No puedes cambiar tu propio rol.']);
        }

        //actualizamos el rol
        $usuario->update(['id_rol' => $request->id_rol]);

        //devolvemos mensaje de éxito
        return back()->with('success', "El rol de {$usuario->nombre} ha sido actualizado.");
    }

    //método para activar/desactivar un usuario
    public function cambiarEstadoUsuario($id)
    {
        //Comprobamos que es Admin (Rol 3)
        if (Auth::user()->id_rol !== 3) {
            return back()->withErrors(['error' => 'Solo el administrador puede cambiar el estado de los usuarios.']);
        }

        //recuperamos el usuario
        $usuario = User::findOrFail($id);

        // Evitamos que el admin desactive su propia cuenta
        if ($usuario->id_usuario === Auth::id()) {
            return back()->withErrors(['error' => 'No puedes desactivar tu propia cuenta.']);
        }

        // Invertimos el estado actual (si está activo, lo desactiva; si está inactivo, lo activa)
        $usuario->update(['activo' => !$usuario->activo]);

        //comprobamos el nuevo estado para el mensaje
        $estado = $usuario->activo ? 'activado' : 'desactivado';
        
        //devolvemos mensaje de éxito
        return back()->with('success', "El usuario {$usuario->nombre} ha sido {$estado}.");
    }
}