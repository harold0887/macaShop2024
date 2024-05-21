<?php

namespace App\Livewire\Customer;

use App\Models\Tag;
use App\Models\Grupo;
use Livewire\Component;
use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\Estudiante_Tag;
use Illuminate\Support\Facades\Request;

class ShowGrupos extends Component
{
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
        // $this->select_date =  "2023-01-02";

        //dd($this->group->estudiantes);

    }


    public function render()
    {

        $estudiantes = Estudiante::
            // whereHas('asistencias', function ($query) {
            //     $query->where('dia',  $this->select_date);
            // })
            //     ->

            where('grupo_id', $this->group->id)->get();

        //dd($estudiantes);

        $tags = Tag::all();


        return view('livewire.customer.show-grupos', compact('estudiantes', 'tags'));
    }
    public function saveAssistance($id)
    {
        try {
            Asistencia::create([
                'dia' => $this->select_date,
                'estudiante_id' => $id,
                'asistencia' => true,
            ]);

            $this->dispatch('success-auto-close', message: "El cambio se realizo con éxito");
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
}
