<!-- Modal -->
<div  class="modal fade" id="modalLinkPago" tabindex="-1" aria-labelledby="modalLinkPago" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviar recordatorio de pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="col-form-label">Link:</label>
                        <input type="text" class="form-control" wire:model.live.debounce.500ms='idSelect'>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row justify-content-center  w-100">
                    <div class="col-12 col-md-6 ">
                        <button type="button" class="btn btn-block  btn-outline-primary  b-close w-100 mt-1" >Prueba</button>
                    </div>
                    <div class="col-12 col-md-6 ">
                        <button type="button" class="btn btn-block  btn-primary  b-close w-100 mt-1">Enviar a cliente</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>