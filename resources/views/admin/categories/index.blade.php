@extends('layouts.app',[
'title'=>'Categorias',
'navbarClass'=>'navbar-transparent',
'activePage'=>'categories',
])
@section('content')
<div class="content py-0 bg-white">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">category</i>
                        </div>
                        <h4 class="card-title font-weight-bold">Categorias ({{$categories->total()}} registros).</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-end">
                            <div class="col-12 col-md-auto  align-self-md-center">
                                <a class="btn btn-primary btn-block" href="{{ route('category.create') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons mr-2">add_circle</i>
                                        <span>Nueva categoria</span>
                                    </div>
                                </a>
                            </div>

                        </div>

                        @if (isset($categories) && $categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>

                                        <th>Categoria</th>
                                        <th>Materiales</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                    <tr>

                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->products->count() }}</td>
                                        <td class="td-actions">
                                            <a class="btn btn-success btn-link " href="{{ route('category.edit', $category->id) }}">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form method="post" action=" {{ route('category.destroy', $category->id) }} " style="display: inline" id="form-delete-category">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" rel="tooltip" class="btn btn-danger btn-link" onclick="confirmDeleteCategory('{{ $category->id }}', '{{ $category->name }}')" id="btn-delete-category">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="col-12">
                            <p class="alert alert-warning">⚠️ ¡Ooooups! No se encontraron resultados.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //Confirmar eliminar producto
    function confirmDeleteCategory($id, $name) {
        var form = $("#form-delete-category");
        event.preventDefault();


        Swal.fire({
            title: "¿Realmente quiere eliminar la categoria: " + $name + "  ? ",
            text: "No podrás revertir esto.!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            } else {
                Swal.fire({
                    title: "Cancelado!",
                    text: "El registro está seguro :)",
                    icon: "error"
                });
            }
        });
    }
</script>
@endsection