<div class="row px-4 pt-5 justify-content-center">
    <div class="col-12 col-md-10 col-lg-6  border p-3" style="background: #52CFDD; border-radius: 20px">
        <h1 class="text-center text-lg sm:text-2x1 md:text-2xl  lg:text-2xl" style="color:white ;font-weight:700">
            Emocionantes cosas por venir ...
        </h1>

        <p class="text-justify text-sm text-muted" style="color:#fdf8f1">
            Mejoramos constantemente. Ingresa tu correo electrónico y te enviaremos actualizaciones sobre los
            próximos
            materiales educativos. También recibirá notificaciones de ofertas especiales, puede cancelar la
            suscripción en
            cualquier momento.
        </p>


        <div class="col-12 text-center">
            <form wire:submit.prevent="addSubscriber">
                <div class="my-2">
                    <input class="w-100 " type="email" name="newSubscriber" style="color:#000;border-color:#e3e3e3;border-radius:4px;font-weight:400; " placeholder="Tu correo electrónico" wire:model="newSubscriber">
                    @error('newSubscriber')
                    <div class=" bg-white border-danger">
                        <small class="text-danger"> {{ $message }} </small>
                    </div>
                    @enderror
                </div>
                <div class="my-2">
                    <button type="submit" class=" btn btn-round" style="color:#fff;background-color:#FF2D82;">
                        Suscribir
                    </button>
                </div>
            </form>
        </div>
        <div style="color:#fdf8f1;font-size:13px;font-weight:400">
            <p class="text-center">

                No recibira spam.
                Puede darse de baja en cualquier momento.
            </p>
        </div>
    </div>
</div>