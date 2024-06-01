@push('js')
@if(session('success'))
<script>
    swal("¡Buen trabajo!", "{{session('success')}}", "success");
</script>
@endif

@if(session('info'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: "<strong>{{session('info')}}</strong>",
        icon: "info",
        html: `
    You can use <b>bold text</b>,
    <a href="#">links</a>,
    and other HTML tags
  `,
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: `
    <i class="fa fa-thumbs-up"></i> Great!
  `,
        confirmButtonAriaLabel: "Thumbs up, great!",
        cancelButtonText: `
    <i class="fa fa-thumbs-down"></i>
  `,
        cancelButtonAriaLabel: "Thumbs down"
    });
</script>
@endif


@if(session('paySuccess'))
<script>
    swal("¡Gracias por su compra!", "{{session('paySuccess')}}", "success");
</script>
@endif



@if(session('payPending'))
<script>
    swal("¡Gracias por su compra!", "{{session('payPending')}}", "info");
</script>
@endif

@if(session('payInProccess'))
<script>
    swal("¡Gracias por su compra!", "{{session('payInProccess')}}", "warning");
</script>
@endif

@if(session('success-auto-close'))
<script>
    alertFloat();

    function alertFloat() {
        type = ["info", "danger", "success", "warning", "rose", "primary"];

        color = Math.floor(Math.random() * 6 + 1);

        $.notify({
            icon: "check_circle",
            message: "{{session('success-auto-close')}}",
        }, {
            type: type[color],
            timer: 3000,
            placement: {
                from: "top",
                align: "right",
            },
        });
    }
</script>
@endif


@if (session('error'))
<script>
    swal("¡error!", "{{session('error')}}", "error");
</script>
@endif

@if (session('status'))
<script>
    swal("¡Buen trabajo!", "{{session('status')}}", "success");
</script>
@endif




@endpush