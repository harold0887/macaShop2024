<?php

namespace App\Livewire\Customer;


use Carbon\Carbon;
use App\Models\Grupo;
use Livewire\Component;
use App\Models\Asistencia;
use App\Models\Estudiante;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class GroupReportExcelRender extends Component
{
    public $patch, $ids, $group;
    public $search = '';
    //public $monthSelect, $yearSelect;
    public $sortDirection = 'desc';
    public $sortField = 'id';
    // public $monthSelectName;
    // public $firstDay, $lastDay;

    public $filters = [
        'fromDate' => '',
        'toDate' => '',
    ];
    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];
        $this->group = Grupo::findOrFail($this->ids);
        $this->filters['fromDate'] = now()->format('Y-m-01');
        $this->filters['toDate'] = now()->format('Y-m-t');
        // $this->yearSelect = now()->format('Y');
        // $this->firstDay = now()->format('Y-m-01');
        // $this->lastDay = now()->format('Y-m-t');

        //dd($this->firstDay. " - ". $this->lastDay);
    }

    public function render()
    {
        $estudiante1 = Estudiante::find(1)->with('asistencias')->whereHas('asistencias', function ($query) {
            $query->where('dia', '>=', $this->filters['fromDate'])
                ->where('dia', '<=', $this->filters['toDate']);
        })->get();

        $estudiantes = Estudiante::where('grupo_id', $this->group->id)
            ->whereHas('grupo', function ($query) {
                $query
                    ->where('user_id', Auth::user()->id);
            })
            ->where(function ($query) {
                $query->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('apellidos', 'like', '%' . $this->search . '%');
            })



            // ->whereHas('asistencias', function ($query) {
            //     $query
            //         ->where('dia', '>=', $this->filters['fromDate'])
            //         ->where('dia', '<=', $this->filters['toDate']);
            // })


            ->orderBy('apellidos', 'asc')
            ->get();

        $asistencias = Asistencia::whereHas('estudiante', function ($query) {
            $query
                ->where('grupo_id', $this->group->id);
        })
            ->where('dia', '>=', $this->filters['fromDate'])
            ->where('dia', '<=', $this->filters['toDate'])

            ->get();





        $lastDay = Carbon::parse($this->filters['fromDate'])->diffInDays(Carbon::parse($this->filters['toDate']));










        $diasMes = [];

        for ($i = 0; $i <= $lastDay; $i++) {

            $day = Carbon::create($this->filters['fromDate'])->addDays($i);

            if ($day->format('l') == 'Saturday' || $day->format('l') == 'Sunday') {
            } else {
                array_push($diasMes, $day);
            }
        }

        return view('livewire.customer.group-report-excel-render', compact('estudiantes', 'asistencias', 'lastDay', 'diasMes', 'estudiante1'));
    }
}
