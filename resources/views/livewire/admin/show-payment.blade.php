<div class="row">
    <div class="col-12 col-md-3">
        <label class="bmd-label-floating">Pago</label>
        <input type="text" class="form-control" placeholder="Ingresa el numero de pago de Mercado Pago" wire:model.defer="payment">
        @error('payment')
        <small class="text-danger"> {{ $message }} </small>
        @enderror
        <button class="btn btn-primary w-100 " wire:click="submit">
            <span>Consultar Pago </span>
        </button>
    </div>


</div>