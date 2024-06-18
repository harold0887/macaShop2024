@extends('layouts.app',[
'title'=>'Grados',
'navbarClass'=>'navbar-transparent',
'activePage'=>'grados',
])
@section('content')
<div class="content py-0 bg-white">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">grain</i>
                        </div>
                        <h4 class="card-title font-weight-bold">Grados ({{$degrees->count()}} registros).</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-end">
                            <div class="col-12 col-md-auto  align-self-md-center">
                                <a class="btn btn-primary btn-block" href="{{ route('degrees.create') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons mr-2">add_circle</i>
                                        <span>Nuevo grado</span>
                                    </div>
                                </a>
                            </div>

                        </div>
                        @if (isset($degrees) && $degrees->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>

                                        <th>Grado</th>
                                        <th>Productos</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($degrees as $grade)
                                    <tr>
                                        <td>{{ $grade->name }}</td>
                                        <td>{{ $grade->products->count() }}</td>
                                        <td class="td-actions ">
                                            <a class="btn btn-success btn-link" href="{{ route('degrees.edit', $grade->id) }}">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form method="post" action=" {{ route('degrees.destroy', $grade->id) }} " style="display: inline" id="form-delete-degrees">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-link" onclick="confirmDeleteDegrees('{{ $grade->id }}', '{{ $grade->name }}')">
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
    function confirmDeleteDegrees($id, $name) {
        var form = $("#form-delete-degrees");
        event.preventDefault();
        Swal.fire({
            title: "¿Realmente quiere eliminar el grado: " + $name + "  ? ",
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