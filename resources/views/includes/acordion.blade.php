<div class="accordion " id="accordion-show-product">
    <div class="accordion-item">
        <h2 class="accordion-header " id="headingOne">
            <button class="accordion-button  " type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="material-icons my-auto mr-2 text-info">info</i>Información
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-mdb-parent="#accordion-show-product">
            <div class="accordion-body">

                <div class="mb-3">
                    <span class="text-sm text-muted">{{ $product->information }} </span>
                </div>
                <div class="text-center">
                    @foreach($product->membresias as $membresia)
                    <a href="{{route('membership.show',$membresia->slug)}}">
                        <span class="badge badge-sm badge-info m small px-1 mx-0" style="cursor:pointer">
                            Incluido en la membresía {{$membresia->title}}
                        </span>
                    </a>
                    @endforeach
                </div>


            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed " type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <i class="material-icons my-auto mr-2 text-success">done</i> Detalles
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-mdb-parent="#accordion-show-product">
            <div class="accordion-body ">
                <div class="d-flex  mt-2  akign-items-center">
                    <i class="material-icons my-auto mr-2 text-success">done</i>
                    <span class="text-xs">Descarga inmediata. </span>
                </div>
                <div class="d-flex  mt-2  akign-items-center">
                    <i class="material-icons my-auto mr-2 text-success">done</i>
                    <span class="text-xs">Este es un archivo digital. </span>
                </div>
                <div class="d-flex  mt-2 akign-items-center">
                    <i class="material-icons my-auto mr-2 text-success">done</i>
                    <span class="text-xs">Recibirá un archivo en formato {{ $product->format }}. </span>
                </div>


            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <i class="material-icons my-auto mr-2 text-danger">close</i> Restricciones
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-mdb-parent="#accordion-show-product">
            <div class="accordion-body">
                <div class="d-flex mt-2 align-items-center">
                    <i class="material-icons my-auto mr-2  text-danger">close</i>
                    <span class="text-xs">Editar o alterar alguna parte del documento. </span>
                </div>
                <div class="d-flex mt-2 align-items-center">
                    <i class="material-icons my-auto mr-2  text-danger">close</i>
                    <span class="text-xs">Revender el documento. </span>
                </div>
                <div class="d-flex mt-2 align-items-center">
                    <i class="material-icons my-auto mr-2 text-danger">close</i>
                    <span class="text-xs">Compartir el archivo en algún sitio web. </span>
                </div>
                <div class="d-flex mt-2 align-items-center">
                    <i class="material-icons my-auto mr-2  text-danger">close</i>
                    <span class="text-xs">Compartir el archivo en algúna red social o WhatsApp. </span>
                </div>
                <div class="d-flex mt-2 align-items-center">
                    <i class="material-icons my-auto mr-2  text-danger">close</i>
                    <span class="text-xs">No se aceptan devoluciones. </span>
                </div>


            </div>
        </div>
    </div>
</div>