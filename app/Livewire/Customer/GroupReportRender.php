<?php

namespace App\Livewire\Customer;

use DateTime;
use Carbon\Carbon;
use App\Models\Grupo;
use Livewire\Component;
use App\Models\Asistencia;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class GroupReportRender extends Component
{


    public $patch, $ids, $group;
    public $search = '';
    public $monthSelect, $yearSelect;
    public $sortDirection = 'desc';
    public $sortField = 'id';
    public $monthSelectName;
    //public $firstDay, $lastDay;


    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];
        $this->group = Grupo::findOrFail($this->ids);
        $this->monthSelect = now()->format('m');
        $this->yearSelect = now()->format('Y');
        // $this->firstDay = now()->format('Y-m-01');
        // $this->lastDay = now()->format('Y-m-t');

        //dd($this->firstDay. " - ". $this->lastDay);
    }
    public function render()
    {

        if ($this->group->id == 1) {
            $estudiantes = Estudiante::where('grupo_id', $this->group->id)

                ->where(function ($query) {
                    $query->where('nombres', 'like', '%' . $this->search . '%')
                        ->orWhere('apellidos', 'like', '%' . $this->search . '%');
                })
                ->orderBy('apellidos', 'asc')
                ->get();
        } else {
            $estudiantes = Estudiante::where('grupo_id', $this->group->id)
                ->whereHas('grupo', function ($query) {
                    $query
                        ->where('user_id', Auth::user()->id);
                })
                ->where(function ($query) {
                    $query->where('nombres', 'like', '%' . $this->search . '%')
                        ->orWhere('apellidos', 'like', '%' . $this->search . '%');
                })
                ->orderBy('apellidos', 'asc')
                ->get();
        }
        $asistencias = Asistencia::whereHas('estudiante', function ($query) {
            $query
                ->where('grupo_id', $this->group->id);
        })
            ->whereMonth('dia', $this->monthSelect)
            ->whereYear('dia', $this->yearSelect)
            //       ->where('status_id', 1)
            ->get();


        $dt2 = Carbon::createFromDate($this->yearSelect . "-" . $this->monthSelect . '-01');



        $firstDay = $dt2->firstOfMonth()->format('d');
        $lastDay = $dt2->LastOfMonth()->format('d');


        $diasMes = [];

        for ($i = 0; $i < $lastDay; $i++) {

            $day = Carbon::create($this->yearSelect, $this->monthSelect, 01)->addDays($i);

            if ($day->format('l') == 'Saturday' || $day->format('l') == 'Sunday') {
            } else {


                array_push($diasMes, $day);
            }
        }


        $this->setNames();




        return view('livewire.customer.group-report-render', compact('estudiantes', 'asistencias', 'firstDay', 'lastDay', 'diasMes'));
    }

    public function setNames()
    {
        switch ($this->monthSelect) {
            case 1:
                $this->monthSelectName = "Enero";
                break;
            case 2:
                $this->monthSelectName = "Febrero";
                break;
            case 3:
                $this->monthSelectName = "Marzo";
                break;
            case 4:
                $this->monthSelectName = "Abril";
                break;
            case 5:
                $this->monthSelectName = "Mayo";
                break;
            case 6:
                $this->monthSelectName = "Junio";
                break;
            case 7:
                $this->monthSelectName = "Julio";
                break;
            case 8:
                $this->monthSelectName = "Agosto";
                break;
            case 9:
                $this->monthSelectName = "Septiembre";
                break;
            case 10:
                $this->monthSelectName = "Octubre";
                break;
            case 11:
                $this->monthSelectName = "Noviembre";
                break;
            case 12:
                $this->monthSelectName = "Diciembre";
                break;
            default:

                break;
        }
    }
}
