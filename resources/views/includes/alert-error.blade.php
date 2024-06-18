@push('js')
@if(session('success'))
<script>
    Swal.fire({
        title: "¡Buen trabajo!",
        text: "{{session('success')}}",
        icon: "success"
    });
</script>
@endif

@if(session('infoPro'))

<script>
    Swal.fire({
        title: `
    Adquiera la versión <b>PRO</b>,
    <a href=https://materialdidacticomaca.com/asistencia>aquí</a>.
    `,
        icon: "info",
        html: "{{session('infoPro')}}",
        showCloseButton: false,
        showCancelButton: false,
        focusConfirm: false,
    });
</script>
@endif


@if(session('paySuccess'))
<script>
    Swal.fire({
        title: "¡Gracias por su compra!",
        text: "{{session('paySuccess')}}",
        icon: "success"
    });
</script>
@endif



@if(session('payPending'))
<script>
    Swal.fire({
        title: "¡Gracias por su compra!",
        text: "{{session('payPending')}}",
        icon: "info"
    });
</script>
@endif

@if(session('payInProccess'))
<script>
    Swal.fire({
        title: "¡Gracias por su compra!",
        text: "{{session('payInProccess')}}",
        icon: "warning"
    });
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
    Swal.fire({
        title: "¡Error!",
        text: "{{session('error')}}",
        icon: "error"
    });
</script>
@endif

@if (session('status'))
<script>
    Swal.fire({
        title: "¡Buen trabajo!",
        text: "{{session('status')}}",
        icon: "success"
    });
</script>
@endif




@endpush