@extends('layouts.app',[
'title'=>'Productos',
'navbarClass'=>'navbar-transparent',
'activePage'=>'products',
])
@section('content')
<div class="content py-0 bg-white">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">menu_book</i>
                        </div>
                        <h4 class="card-title">Editar {{ $product->title }}</h4>
                    </div>
                    <div class="card-body ">
                        <form id="edit-product-admin" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PATCH')
                            <div class="form-row mt-lg-5">
                                <div class="form-group col-md-1">
                                    <label for="numero">Número</label>
                                    <input type="number" class="form-control" name="numero" value="{{ old('numero') ?: $product->numero }}" step="0.01">
                                    @error('numero')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="title">Titulo</label>
                                    <input type="text" class="form-control" name="title" value=" {{ old('title') ?: $product->title }} ">
                                    @error('title')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="price">Precio sin descuento</label>
                                    <input type="number" class="form-control" name="price" value="{{ old('price') ?: $product->price }}" step="0.01">
                                    @error('price')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="discount">Precio con descuento</label>
                                    <input type="number" class="form-control" name="discount" value="{{ $product->price_with_discount }}{{ old('discount') }}" step="0.01">
                                    @error('discount')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="disponible">Disponible en membresia</label>
                                    <input type="date" class="form-control" name="disponible" required value="{{ old('disponible')?: (new DateTime($product->fecha_membresia))->format('Y-m-d')  }}">
                                    @error('disponible')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row mt-lg-5">
                                <div class="form-group col-12 col-md-4">
                                    <select name="categories[]" class="selectpicker form-control" data-size="7" data-style="select-with-transition " multiple title="Categoria...">

                                        @if (isset($categories) && $categories->count() > 0)
                                        @foreach ($categories as $category)

                                        <option value=" {{ $category->id }}" @foreach($product->categorias as $categoriaProduct)
                                            @if($categoriaProduct->id == $category->id)
                                            selected
                                            @endif
                                            @endforeach
                                            {{ (collect(old('categories'))->contains($category->id)) ? 'selected':'' }}>
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
                                        <option value=" {{ $grade->id }}" {{ $product->grado->id == $grade->id ? 'selected' : '' }} {{ old('grade') == $grade->id ? 'selected' : '' }}>
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
                                        <option value=" {{ $membership->id }}" @foreach($product->membresias as $membresiaProduct)
                                            @if($membresiaProduct->id == $membership->id)
                                            selected
                                            @endif
                                            @endforeach
                                            {{ (collect(old('memberships'))->contains($membership->id)) ? 'selected':'' }}>
                                            {{ $membership->title }} - {{$membership->vigencia}}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('categradegory')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row mt-lg-5">
                                <div class="form-group col-md-12">
                                    <label for="information">Informacion</label>
                                    <textarea class="form-control border rounded mt-2" name="information" rows="5" value="">{{ old('information') ?: $product->information }}</textarea>
                                    @error('information')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title ">Documento</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="height:300px !important">
                                            @if ($product->document && Storage::exists($product->document))
                                            <img src="{{ asset('img') }}/docs/{{$product->format}}.png" alt="...">
                                            <span class="m-2 text-base">{{$product->title}}.{{ $product->format }}</span>

                                            @else

                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                            <h6 class="m-2">No existe un documento para este producto.</h6>
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Selecciona un nuevo documento</span>
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
                                        <div class="fileinput-new thumbnail" style="height:300px !important">
                                            @if ($product->itemMain && Storage::exists($product->itemMain))
                                            <img src="{{ Storage::url($product->itemMain)  }}" alt="...">
                                            @else
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                            <h6 class="m-2">No existe una portada para este producto.</h6>
                                            @endif

                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Selecciona una nueva portada</span>
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
                                        <div class="fileinput-new thumbnail" style="height:300px !important">

                                            @if($product->items->count() > 0)
                                            <div class="row">
                                                @foreach($product->items as $item)
                                                <div class="col-4">
                                                    <img class="w-100" src="{{ Storage::url($item->photo)  }}" alt="...">
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                            <h6 class="m-2">No existen imagenes este producto.</h6>
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Añadir más imagenes</span>
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
                                        <div class="fileinput-new thumbnail" style="height:300px !important">
                                            @if ($product->video && Storage::exists($product->video))
                                            <video class="  w-75 " src="{{ Storage::url($product->video) }}" autoplay muted loop></video>
                                            @else
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                            <h6 class="m-2">No existe un video para este producto.</h6>
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Selecciona un nuevo video</span>
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
                            <livewire:delete-items />
                            <div class="form-row">
                                <div class="col-12 text-center pt-5 border-top">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="material-icons">autorenew</i>
                                        Actualizar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection