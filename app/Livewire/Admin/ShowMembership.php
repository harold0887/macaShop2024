<?php

namespace App\Livewire\Admin;

use App\Models\Membership;
use Livewire\Component;
use Illuminate\Support\Facades\Request;
class ShowMembership extends Component
{
    public $patch, $ids, $membership;
    public $sortDirection = 'asc';
    public $sortField = 'created_at';


    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];
       

        //dd($this->order);
    }
    public function render()
    {
        $this->membership = Membership::findOrFail($this->ids);
        return view('livewire.admin.show-membership');
    }
     //sort
     public function setSort($field)
     {
 
         $this->sortField = $field;
 
         if ($this->sortDirection == 'desc') {
             $this->sortDirection = 'asc';
         } else {
             $this->sortDirection = 'desc';
         }
     }
     public function clearSearch()
     {
         $this->reset(['search']);
     }
}
