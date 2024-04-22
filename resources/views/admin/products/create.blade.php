@extends('layouts.app',[
'title'=>'Productos',
'navbarClass'=>'navbar-transparent',
'activePage'=>'products',
])
@section('content')
<div class="content pt-0">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">menu_book</i>
                        </div>
                        <h4 class="card-title">Agregar producto</h4>
                    </div>
                    <div class="card-body ">
                        <form id="create-product-admin" action="{{ route('products.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-row ">
                                <div class="form-group col-12 col-md-4">
                                    <label class="bmd-label-floating">Titulo</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                    @error('title')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label class="bmd-label-floating">Precio sin descuento</label>
                                    <input id="pricePublic" type="number" class="form-control" name="price" value="{{ old('price') }}" step="0.01">
                                    @error('price')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label class="bmd-label-floating">Precio con descuento</label>
                                    <input id="price_discount" type="number" class="form-control" name="price_discount" value="{{ old('price_discount') }}" step="0.01">
                                    @error('price_discount')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row px-0 mt-5">
                                <div class="form-group col-12 col-md-4">
                                    <select name="categories[]" class="selectpicker form-control" data-size="7" data-style="select-with-transition " multiple title="Categoria (opcional)...">

                                        @if (isset($categories) && $categories->count() > 0)
                                        @foreach ($categories as $category)
                                        <option value=" {{ $category->id }}" {{ (collect(old('categories'))->contains($category->id)) ? 'selected':'' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('category')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4 ">
                                    <select name="grade" class="selectpicker form-control" data-size="7" data-style="select-with-transition " title="Grado...">
                                        <option disabled>Selecciona una opcion...</option>
                                        @if (isset($degrees) && $degrees->count() > 0)
                                        @foreach ($degrees as $grade)
                                        <option value=" {{ $grade->id }}" {{ old('grade') == $grade->id ? 'selected' : '' }}>
                                            {{ $grade->name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('grade')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <select name="memberships[]" class="selectpicker form-control" data-size="7" data-style="select-with-transition " multiple title="Membresia (opcional) ...">

                                        @if (isset($memberships) && $memberships->count() > 0)
                                        @foreach ($memberships as $membership)
                                        <option value=" {{ $membership->id }}" {{ (collect(old('memberships'))->contains($membership->id)) ? 'selected':'' }}>

                                            {{ $membership->title }} - {{ $membership->vigencia }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('categradegory')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row   mt-lg-5">
                                <div class="form-group col-12">
                                    <label class="bmd-label-floating">Informacion</label>
                                    <textarea class="form-control border rounded" name="information" rows="5" value="">{{ old('information') }}</textarea>
                                    @error('information')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title ">Documento</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Selecciona el documento</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="document" accept=".doc,.docx,.pdf,.ppt,.pptx,.ppxs, .zip " />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
                                        </div>
                                    </div>
                                    <div>
                                        @error('document')
                                        <small class=" text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title">Imagen principal</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Selecciona La portada</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="itemMain" accept="image/*" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
                                        </div>
                                    </div>
                                    <div>
                                        @error('itemMain')
                                        <small class=" text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title">Fotos (maximo 10 items)</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Selecciona las fotos</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="items[]" multiple accept="image/*">
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
                                        </div>
                                    </div>
                                    <div>
                                        @error('items')
                                        <small class=" text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title">Video (opcional)</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Selecciona el video</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="video" accept="video/*" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
                                        </div>
                                    </div>
                                    <div>
                                        @error('video')
                                        <small class=" text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10 text-center mt-5">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="reset" class="btn">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection