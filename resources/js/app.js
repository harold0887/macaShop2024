import './bootstrap';








$(function () {

  extraBtn()
  autoplay();
  comentsAutoplay();
  showFilters();
  relacionadosAutoplay()
  showModalLoad();
  loginModal();
  clearlogin();
  rangeCalendar()



});

function extraBtn() {
  $(".b-close").on("click", function () {
    $("#adCart,#product-view").modal("hide");

  });
  //hide div result and clear input
  $(".btn-cleare").on("click", function () {
    $("#input-search-home, #input-search-home1").val("");
    $("#null-search1, #null-search").addClass("d-none").text("");

  });
  //hide div result
  $("#input-search-home1").on("keyup", function () {
    if ($("#input-search-home1").val() == "") {
      $("#null-search1").addClass("d-none").text("");
    }
  })
  $("#input-search-home").on("keyup", function () {
    if ($("#input-search-home").val() == "") {
      $("#null-search").addClass("d-none").text("");
    }
  })
}
function rangeCalendar() {
  $('input[name="datefilter"]').daterangepicker({
    autoUpdateInput: false,
    locale: {
      cancelLabel: 'Borrar',
      applyLabel: 'Aplicar'
    }
  });
  $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {

    Livewire.dispatch('setRange',
      {
        start: picker.startDate.format('YYYY-MM-DD'),
        end: picker.endDate.format('YYYY-MM-DD')
      })
  });
}





function destroyAutoplay() {
  setTimeout(function () {
    $(".best-autoplay,.novedades-autoplay,.relacionados1").slick('destroy');
  }, 50)
}
function autoplay() {
  setTimeout(function () {
    $(".best-autoplay,.novedades-autoplay").slick({
      autoplay: true,
      autoplaySpeed: 3000,
      arrows: false,
      infinite: true,

      responsive: [
        {
          breakpoint: 2048,
          settings: {
            slidesToShow: 5,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 700,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
      ],
    });
  }, 50);
}
function comentsAutoplay() {
  $(".coments-autoplay").slick({
    autoplay: true,
    autoplaySpeed: 3000,
    arrows: false,
    infinite: true,
    dots: false,

    responsive: [
      {
        breakpoint: 2048,
        settings: {
          slidesToShow: 5,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 700,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });
}
function relacionadosAutoplay() {
  setTimeout(function () {
    $(".relacionados1").slick({
      autoplay: true,
      autoplaySpeed: 3500,
      arrows: false,
      dots: false,
      infinite: true,
      adaptiveHeight: true,
      responsive: [
        {
          breakpoint: 2048,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 700,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });
  }, 50);
}


function showFilters() {
  $("#sidebarCollapse1").on("click", function () {
    $("#sidebar11").toggleClass("d-none");
    var $value = $("#text-filter").text();
    if ($value == "Mostrar filtros") {
      $("#text-filter").text("Ocultar filtros");
      $("#icon-filter").text("remove");
    }
    if ($value == "Ocultar filtros") {
      $("#text-filter").text("Mostrar filtros");
      $("#icon-filter").text("add");
    }
  });
}


//activar modal al enviar, se cierra al retornar controlador
function showModalLoad() {
  $(
    "#create-product-admin,#create-membership-admin,#create-package,#edit-package,#edit-product-admin, #resend-verified, #forgot-password"
  ).submit(() => {
    $("#modal-spinner").modal("show");
  });

  $(".active-modal").submit(() => {
    $("#modal-spinner").modal("show");
  });
}

function showloginModal() {
  $("#loginModal").modal("show");

}

function clearlogin() {
  $("#btn-login-close").on("click", function () {
    $("#email-error,#password-error").children("span").text("");
    $("#login-email").val("").attr("placeholder", "Correo electrónico");
    $("#login-password").val("").attr("placeholder", "Contraseña");

  });
} //limpiar registro al cerrar

function loginModal() {
  var frm = $("#loginForm1");
  $("#btn-login-modal").on("click", function (e) {
    e.preventDefault();
    $.ajax({
      type: frm.attr("method"),
      headers: {
        Accept: "application/json",
      },
      url: frm.attr("action"),
      data: frm.serialize(),
      success: function success() {
        return window.location.reload();
      },
      error: function error(response) {
        if (response.status === 422) {
          var errors = response.responseJSON.errors;
          Object.keys(errors).forEach(function (key) {
            $("#" + key + "-error")
              .children("span")
              .text(errors[key][0]);
          });
        } else {
          window.location.reload();
        }
      },
    });
  });
}


//Livewire


Livewire.on('addCartAlert', ({ title, price, img }) => {
  $("#cartTitle").text(title);
  $("#cartPrice").text(price);
  $("#cartImage").attr("src", img);
  $("#adCart").modal("show");
  destroyAutoplay();
  autoplay();
  relacionadosAutoplay()


})





Livewire.on('deleteCartAlert', ({ message }) => {
  alertFloat("right", message, "check_circle");
})



Livewire.on('info', ({ message }) => {
  alertFloat("right", message, "cancel");
})



Livewire.on('showProductDetails', ({ title, itemMain, items }) => {
  $("#title-product-modal-view").text(title);
  $("#itemMain-product-modal-view").attr("src", "/public/storage/" + itemMain);
  $('#product-view').modal('show');

  //clear items and reload
  $('#items-product-modal-view').children().remove();


  var $json = items;
  $.each($json, function (index, valores) {
    var c = valores.photo;
    $("#items-product-modal-view").append("<img class='rounded w-100 shadow border mt-2' src='/public/storage/" + c + "' alt='' >")
  })


})


Livewire.on('error', ({ message }) => {
  Swal.fire({
    title: "¡Error!",
    text: message,
    icon: "error"
  });
})



Livewire.on('success', ({ title, message }) => {
  if (title) {
    Swal.fire({
      title: title,
      text: message,
      icon: "success"
    });
  } else {
    Swal.fire({
      title: "¡Buen trabajo!",
      text: message,
      icon: "success"
    });
  }

})
Livewire.on('success-auto-close', ({ message }) => {
  alertFloat("right", message, "check_circle");
})

Livewire.on('alertDownload', ({ message }) => {
  alertFloat("left", message, "check_circle");
})

Livewire.on('alertComment', ({ message }) => {
  alertFloat("right", message, "check_circle");
})
Livewire.on('alertlogin', ({ message }) => {
  alertFloat("right", message, "check_circle");
  showloginModal();
})

Livewire.on('reload', () => {
  return window.location.reload();
})

// Livewire.on('refresh-calendar-js', () => {
//   rangeCalendar();
// })




Livewire.on('sendSuccessHtml', ({ product, note, email }) => {
  //alert('entro');
  var text =
    "<span class='font-weight-bold'>" +
    product +
    "</span>" +
    "<span> <br><br> " +
    note +
    "</span>" +
    "<span class='font-italic font-weight-bold'> " +
    email +
    "</span>";

  Swal.fire({
    title: "Enviado!",
    icon: "success",
    html: text,
    showCloseButton: false,
    showCancelButton: false,
    focusConfirm: false,

  });



})


Livewire.on('infoPro', ({ message }) => {
  Swal.fire({
    title: `
    Adquiera la versión <b>PRO</b>,
    <a href=https://materialdidacticomaca.com/asistencia>aquí</a>.
    `,
    icon: "info",
    html: message,
    showCloseButton: false,
    showCancelButton: false,
    focusConfirm: false,
  });

})



function alertFloat(align, message, icon) {
  const type = ["info", "danger", "success", "warning", "rose", "primary"];

  const color = Math.floor(Math.random() * 6 + 1);

  $.notify(
    {
      icon: icon,
      message: message,
    },
    {
      type: type[color],
      timer: 3000,
      placement: {
        from: "top",
        align: align,
      },
    }
  );
}


