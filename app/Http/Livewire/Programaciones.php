<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Programacion;
use App\Models\Persona;
use App\Models\Tarea;

class Programaciones extends Component
{
    
    public $programaciones;
    public $clientes=[]; //variable que permite cargar los datos en el combo de clientes
    public $tareas=[];
    public $tecnicos=[];
    public $estados=[];

    public $programacion_id;
    public $cliente_id;
    public $tarea_id;
    public $tecnico_id;
    public $tiempo_inicio;
    public $tiempo_fin;
    public $fecha;
    public $estado;
    public $latitud;
    public $longitug;
    public $observaciones;

    public $modal = false;

    public function render()
    {
        $this->programaciones = Programacion::all(); 
        $this->clientes = Persona::where('tipo','=','cliente')->get();
        $this->tecnicos = Persona::where('tipo','=','tecnico')->get();
        $this->tareas = Tarea::all();
        return view('livewire.programaciones');
    }
    public function crear()
    {
        $this->limpiarCampos();
        $this->abrirModal();
        $this->estados();        
    }

    public function abrirModal()
    {
        $this->modal = true;
    }

    public function cerrarModal(){
        $this->modal = false;
    }

    public function limpiarCampos()
    {
        $this ->programacion_id= null;
        $this ->cliente_id="";
        $this ->tarea_id="";
        $this ->tecnico_id="";
        $this ->tiempo_inicio="";
        $this ->tiempo_fin="";
        $this ->fecha="";
        $this ->estado="";
        $this ->latitud="";
        $this ->longitug="";
        $this ->observaciones="";
  
    }

    public function editar($id)
    {
        $programacion = Programacion::findOrFail($id);
        
        $this ->programacion_id= $programacion->id;
        $this ->cliente_id=$programacion->cliente_id;
        $this ->tarea_id=$programacion->tarea_id;
        $this ->tecnico_id=$programacion->tecnico_id;
        $this ->tiempo_inicio=$programacion->tiempo_inicio;
        $this ->tiempo_fin=$programacion->tiempo_fin;
        $this ->fecha=$programacion->fecha;
        $this ->estado=$programacion->estado;
        $this ->latitud=$programacion->latitud;
        $this ->longitug=$programacion->longitug;
        $this ->observaciones=$programacion->observaciones;
        $this->abrirModal();
    }

    public function borrar($id)
    {
        Programacion::find($id)->delete();
        session()->flash('message', 'Programacion eliminada correctamente');
    }

    public function guardar()
    {
        $programacion = null;

        if(is_null($this->programacion_id))
        {
            Programacion::create(
            [
                'id_cliente' => $this->id_cliente,
                'id_tarea' => $this->id_tarea,
                'id_tecnico' => $this->id_tecnico,
                'tiempo_inicio' => $this->tiempo_inicio,
                'tiempo_fin' => $this->tiempo_fin,
                'fecha' => $this->fecha,
                'estado' => $this->estado,
                'latitud' => $this->latitud,
                'longitud' => $this->longitud,
                'latitud' => $this->nombre,
                'observaciones' => $this->observaciones,
                  
            ]);    
        }
        else
        {
            $programacion = Programacion::find($this->progrmacion_id);
            $programacion->id_cliente = $this->id_cliente;
            $programacion->id_tarea = $this->id_tarea;
            $programacion->id_tecnico = $this->id_tecnico;
            $programacion->tiempo_inicio = $this->tiempo_inicio;
            $programacion->tiempo_fin = $this->tiempo_fin;
            $programacion->fecha = $this->fecha;
            $programacion->estado = $this->estado;
            $programacion->latitud = $this->latitud;
            $programacion->longitud = $this->longitud;
            $programacion->observaciones = $this->observaciones;
          

            $programacion->save();
        }
        
         session()->flash('message',
            $this->programacion_id ? '¡Actualización exitosa!' : '¡Se creo una Nueva Programacion!');
         
         $this->cerrarModal();
         $this->limpiarCampos();
    }

    public function estados()
    {
        $this->estados = array('asignado', 'ejecutando', 'finalizado');
    }

    public function calcularTiempoDeFin()
    {
        //dd($this->tarea_id);
        $tarea = Tarea::find($this->tarea_id);
        //dd($tarea);
        $tiempo = ($tarea->tiempo * 8)/100;
        $tiempoTemp = strtotime($this->tiempo_inicio) + $tiempo*60*60;
        $this->tiempo_fin = date('H:i', $tiempoTemp);
    }
    
}
