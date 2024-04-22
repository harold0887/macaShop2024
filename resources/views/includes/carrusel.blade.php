 <!-- Carousel wrapper -->
 <div id="carouselDarkVariant" class="carousel slide carousel-fade carousel-dark  " data-mdb-ride="carousel">
     <!-- Indicators -->
     <div class="carousel-indicators">
         <button data-mdb-target="#carouselDarkVariant" data-mdb-slide-to="0" class="active bg-primary" aria-current="true" aria-label="Slide 1"></button>
         @foreach($product->items as $item)

         <button class="bg-primary " data-mdb-target="#carouselDarkVariant" data-mdb-slide-to="{{ $loop->index+1 }}" aria-label="Slide {{ $loop->index+2 }}"></button>
         @endforeach


     </div>

     <!-- Inner -->
     <div class="carousel-inner justify-content-center ">
         <!-- Single item -->
         <div class="carousel-item active  d-flex justify-content-center ">
             <img class="rounded w-100 d-block d-xl-none border" src="{{ Storage::url($product->itemMain) }}" alt="" class="carousel-img">
             <img class="rounded w-75 d-none d-xl-block border" src="{{ Storage::url($product->itemMain) }}" alt="" class="carousel-img">
         </div>

         @foreach($product->items as $item)
         <div class="carousel-item   d-flex justify-content-center ">
             <img class="rounded w-100 d-block d-xl-none border" src="{{ Storage::url($item->photo) }}" alt="" class="carousel-img">
             <img class="rounded w-75 d-none d-xl-block border" src="{{ Storage::url($item->photo) }}" alt="" class="carousel-img">
         </div>
         @endforeach

     </div>

     <!-- Controls -->
     <button class="carousel-control-prev" type="button" data-mdb-target="#carouselDarkVariant" data-mdb-slide="prev">
         <span class="material-icons text-white fw-bold bg-primary rounded p-2 rounded-circle">arrow_back_ios</span>
     </button>
     <button class="carousel-control-next " type="button" data-mdb-target="#carouselDarkVariant" data-mdb-slide="next">
         <span class="material-icons text-white fw-bold bg-primary rounded p-2 rounded-circle">arrow_forward_ios</span>
     </button>
 </div>



