<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class IndexComments extends Component
{
    use WithPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';
    public $sortDirection = 'desc';
    public $sortField = 'id';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {




        $comments = Comment::query()
            ->with(['user', 'product'])
            ->when($this->search, function ($query) {
                $query->where('comment', 'like', '%' . trim($this->search) . '%');
            })
            ->orWhereHas('user', function ($q) {
                $q->where('email', 'like', '%' . trim($this->search) . '%')
                    ->orWhere('name', 'like', '%' . trim($this->search) . '%');
            })
            ->orWhereHas('product', function ($q) {
                $q->where('title', 'like', '%' . trim($this->search) . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);








        return view('livewire.admin.index-comments', compact('comments'))
            ->extends('layouts.app', [
                'title' => 'Comentarios',
                'navbarClass' => 'navbar-transparent',
                'activePage' => 'comments',
            ])
            ->section('content');
    }

    public function clearSearch()
    {
        $this->reset(['search']);
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


    public function changeStatusComments($id, $status)
    {

        $comment = Comment::findOrFail($id);

        try {
            if ($status == 1) {

                $comment->update([
                    'status' => 0,
                ]);

                $this->dispatch('success-auto-close', message: 'El el comentario ha sido bloqueado con éxito');
            } else {

                $comment->update([
                    'status' => 1,
                ]);
                $this->dispatch('success-auto-close', message: 'El comentario ha sido desbloqueado con éxito');
            }
        } catch (\Throwable $e) {
            $this->dispatch('error', message: $e->getMessage());
        }
    }
    public function changeStatusBest($id, $status)
    {

        $comment = Comment::findOrFail($id);

        try {
            if ($status == 1) {

                $comment->update([
                    'best' => 0,
                ]);
                $this->dispatch('success-auto-close', message: 'El comentario ha sido eliminado de mejores comentarios');
            } else {

                $comment->update([
                    'best' => 1,
                ]);
                $this->dispatch('success-auto-close', message: 'El el comentario ha sido marcado como mejor comentario');
            }
        } catch (\Throwable $e) {
            $this->dispatch('error', message: $e->getMessage());
        }
    }
}
