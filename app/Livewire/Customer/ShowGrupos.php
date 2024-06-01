<?php

namespace App\Livewire\Customer;

use App\Models\Tag;
use App\Models\Grupo;
use Livewire\Component;
use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\Estudiante_Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ShowGrupos extends Component
{
    public $search = '';
    public $select_date;
    public $patch, $ids, $group;

    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];
        $this->group = Grupo::findOrFail($this->ids);
        $this->select_date = date_format(now(), "Y-m-d");
        //$this->select_date =  "2025-04-03";

        //dd($this->group->estudiantes);

    }


    public function render()
    {

        $estudiantes = Estudiante::where('grupo_id', $this->group->id)
            ->where('user_id', Auth::user()->id)
            ->where(function ($query) {
                $query->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('apellidos', 'like', '%' . $this->search . '%');
            })

            ->orderBy('apellidos', 'asc')
            ->get();


        $asistencias = Asistencia::where('dia', $this->select_date)
            ->whereHas('estudiante', function ($query) {
                $query
                    ->where('grupo_id', $this->group->id);
                //->where('payment_type', '!=', 'externo');
            })
            ->get();

        $as = Asistencia::where('dia', $this->select_date)
            ->whereHas('estudiante', function ($query) {
                $query
                    ->where('grupo_id', $this->group->id);
            })
            ->where('status_id', 1)
            ->get();

        $faltas = Asistencia::where('dia', $this->select_date)
            ->whereHas('estudiante', function ($query) {
                $query
                    ->where('grupo_id', $this->group->id);
            })
            ->where('status_id', 2)
            ->get();
        $retardos = Asistencia::where('dia', $this->select_date)
            ->whereHas('estudiante', function ($query) {
                $query
                    ->where('grupo_id', $this->group->id);
            })
            ->where('status_id', 3)
            ->get();
        $faltasJustificadas = Asistencia::where('dia', $this->select_date)
            ->whereHas('estudiante', function ($query) {
                $query
                    ->where('grupo_id', $this->group->id);
            })
            ->where('status_id', 4)
            ->get();





        $tags = Tag::all();



        if ($this->group->user_id == Auth::user()->id || $this->group->id == 1) {
            return view('livewire.customer.show-grupos', compact('estudiantes', 'tags', 'asistencias', 'faltas', 'retardos', 'faltasJustificadas', 'as'));
        } else {
            abort(404);
        }
    }
    public function asistencia($id)
    {
        $register = Asistencia::where('estudiante_id', $id)->where('dia', $this->select_date)->first();
        try {

            if ($register != null && $register->count() > 0) {
                $register->update([
                    'dia' => $this->select_date,
                    'estudiante_id' => $id,
                    'status_id' => 1
                ]);
                $this->dispatch('success-auto-close', message: "El cambio se realizo con éxito");
            } else {
                Asistencia::create([
                    'dia' => $this->select_date,
                    'estudiante_id' => $id,

                    'status_id' => 1
                ]);
                $this->dispatch('success-auto-close', message: "La asistencia se registro  con éxito");
            }
        } catch (\Throwable $th) {
            $this->dispatch('error', message: "Error a guardar la asistencia" . $th->getMessage());
        }
    }
    public function falta($id)
    {
        $register = Asistencia::where('estudiante_id', $id)->where('dia', $this->select_date)->first();
        try {
            if ($register != null && $register->count() > 0) {
                $register->update([
                    'dia' => $this->select_date,
                    'estudiante_id' => $id,
                    'status_id' => 2
                ]);
                $this->dispatch('success-auto-close', message: "La falta se registro con éxito");
            } else {
                Asistencia::create([
                    'dia' => $this->select_date,
                    'estudiante_id' => $id,
                    'status_id' => 2
                ]);
                $this->dispatch('success-auto-close', message: "La falta se registro con éxito");
            }
        } catch (\Throwable $th) {
            $this->dispatch('error', message: "Error a guardar la asistencia" . $th->getMessage());
        }
    }

    public function retardo($id)
    {
        $register = Asistencia::where('estudiante_id', $id)->where('dia', $this->select_date)->first();
        try {
            if ($register != null && $register->count() > 0) {
                $register->update([
                    'dia' => $this->select_date,
                    'estudiante_id' => $id,
                    'status_id' => 3
                ]);
                $this->dispatch('success-auto-close', message: "El retardo se registro con éxito");
            } else {
                Asistencia::create([
                    'dia' => $this->select_date,
                    'estudiante_id' => $id,
                    'status_id' => 3
                ]);
                $this->dispatch('success-auto-close', message: "El retardo se registro con éxito");
            }
        } catch (\Throwable $th) {
            $this->dispatch('error', message: "Error a guardar la asistencia" . $th->getMessage());
        }
    }
    public function faltaJustificada($id)
    {
        $register = Asistencia::where('estudiante_id', $id)->where('dia', $this->select_date)->first();

        try {
            if ($register != null && $register->count() > 0) {
                $register->update([
                    'dia' => $this->select_date,
                    'estudiante_id' => $id,
                    'status_id' => 4
                ]);
                $this->dispatch('success-auto-close', message: "La falta justificada se registro con éxito");
            } else {
                Asistencia::create([
                    'dia' => $this->select_date,
                    'estudiante_id' => $id,
                    'status_id' => 4
                ]);
                $this->dispatch('success-auto-close', message: "La falta justificada se registro con éxito");
            }
        } catch (\Throwable $th) {
            $this->dispatch('error', message: "Error a guardar la asistencia" . $th->getMessage());
        }
    }
    public function sinRegistro($id)
    {
        $register = Asistencia::where('estudiante_id', $id)->where('dia', $this->select_date)->first();

        try {
            if ($register != null && $register->count() > 0) {
                Asistencia::destroy($register->id);
                $this->dispatch('success-auto-close', message: "El cambio se realizo con éxito");
            } else {

                $this->dispatch('success-auto-close', message: "El registro del alumno est vacio");
            }
        } catch (\Throwable $th) {
            $this->dispatch('error', message: "Error a guardar la asistencia" . $th->getMessage());
        }
    }
    public function saveTag($estudiante, $tag)
    {
        try {
            Estudiante_Tag::create([
                'dia' => $this->select_date,
                'estudiante_id' => $estudiante,
                'tag_id' => $tag,
            ]);

            $this->dispatch('success-auto-close', message: "El tag  se realizo con éxito");
        } catch (\Throwable $th) {
            $this->dispatch('error', message: "Error a guardar el tag" . $th->getMessage());
        }
    }

    public function deleteTag($id)
    {
        try {

            $tag = Estudiante_Tag::findOrFail($id);

            Estudiante_Tag::destroy($tag->id);



            $this->dispatch('success-auto-close', message: "El tag  se actualzo con éxito");
        } catch (\Throwable $th) {
            $this->dispatch('error', message: "Error a guardar el tag" . $th->getMessage());
        }
    }
    public function clearSearch()
    {
        $this->reset(['search']);
    }
}
