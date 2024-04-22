  <!--Modal add cart-->
  <div class="modal fade" id="adCart" data-mdb-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title text-muted d-flex align-items-center justify-content-center">
                      <i class=" material-icons text-primary mr-2 text-2x1">check</i>
                      Agregado al carrito
                  </h4>
                  <button type="button" class="close b-close" data-dismiss="modal" aria-hidden="false">
                      <i class="material-icons">clear</i>
                  </button>
              </div>
              <div class="modal-body border-top border-bottom">
                  <div class="row">
                      <div class="col-6 img-product">
                          <img class="w-100 shadow rounded" id="cartImage" src="" alt="">
                      </div>
                      <div class="col-6 text-muted text-2xl">
                          <span id="cartTitle"></span>
                          <div class="pt-3">
                          <span class="fw-bold " id="cartPrice"></span>
                          </div>
                          


                      </div>
                  </div>
              </div>
              <div class="modal-footer  justify-content-center">
                  <div class="row justify-content-center  w-100">
                      <div class="col-12 col-md-6 ">
                          <button type="button" class="btn btn-block  btn-outline-primary  b-close w-100 mt-1">Seguir comprando</button>
                      </div>
                      <div class="col-12 col-md-6">
                          <a href="{{ route('cart.index') }}" class="btn btn-block  btn-primary w-100  ">
                              Ver carrito y pagar
                          </a>

                      </div>
                  </div>
              </div>



          </div>
      </div>
  </div>
  <!-- End Modal add cart-->