$(document).scroll(function() {
    var y = $(this).scrollTop();
    if (y > 200) {
        // $(".btn-cat-show").removeClass("show");
        // $(".menu-show-hide").slideDown(200);

    } else if (y < 200) {
          // $(".btn-cat-show").addClass("show");
        // $(".menu-show-hide").slideUp(200);
    }
  });

  $('.ratingPiont').starRating({
      starSize: 1.5,
      showInfo: true
  });

  $('.ratingView').starRating({
      starSize: 1.5,
      showInfo: true
  });

  function shippingAddress() {
      var shipping = document.getElementById('shipping_address');
      var shippingicon = document.getElementById('shippingicon2');

      if (shipping.style.display === "none") {
          shipping.style.display = "block";
          shippingicon.style.transform = "rotate(90deg)";
      } else {
          shipping.style.display = "none";
          shippingicon.style.transform = "rotate(0deg)";
      }
  }

  function iconRotate(){
      var cart = document.getElementById('carticon2');
      var attVal = $('.ft-cart-btn').attr('aria-expanded');
      if (attVal == 'true'){
          cart.style.transform = "rotate(90deg)";
      }else{
          cart.style.transform = "rotate(0deg)";
      }
  }

  

  var slider = new Swiper ('.gallery-slider', {
      slidesPerView: 1,
      centeredSlides: true,
      loop: true,
      loopedSlides: 4,
  });

  var thumbs = new Swiper ('.gallery-thumbs', {
      slidesPerView: 'auto',
      spaceBetween: 10,
      loopedSlides: 4,
      centeredSlides: true,
      loop: true,
      slideToClickedSlide: true,
      navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
      },
  });
  slider.controller.control = thumbs;
  thumbs.controller.control = slider;

  const formSelect = document.getElementById('form-select');
  // Update the custom select
  // FancySelect.update(formSelect);

  // Get a reference to the button and the dropdown menu
//   const currencyDropdownButton = document.getElementById('currencyDropdown');
//   const currencyDropdownItems = document.querySelectorAll('.dropdown-item');

//   // Add an event listener to each dropdown item
//   currencyDropdownItems.forEach(item => {
//       item.addEventListener('click', function (event) {
//           event.preventDefault(); // Prevent the default link behavior

//           // Get the selected currency from the data attribute
//           const selectedCurrency = event.target.getAttribute('data-currency');

//           // Update the button text with the selected currency symbol
//           currencyDropdownButton.textContent = '$ ' + selectedCurrency;
//       });
//   });

  $('#navbarPopUp').click(function () {
      $('#navbarNav').addClass('offcanvas offcanvas-end text-bg-dark');
      $('.navbar-primary ul.navbar-nav').addClass('offcanvas-body');
  });
  $('#navClose').click(function () {
      $("#navbarNav").removeClass('show');

  });
  var swiper = new Swiper(".bannerSlide", {
      loop: true,
      autoplay: {
          delay: 5000,
      },
      pagination: {
          el: ".swiper-pagination",
          clickable: true,
      }
  });
  
  var swiper = new Swiper(".apparelsSlide", {
    slidesPerView: 5,
    slidesPerColumn: 2,
    autoplay: {
    delay: 3000,
    },
    loop: true,
    navigation: {
        nextEl: ".apparels-button-next",
        prevEl: ".apparels-button-prev",
    },
    breakpoints: {
        992: {
            slidesPerView: 5,
        },
        768: {
            slidesPerView: 4,
        },
        480: {
            slidesPerView: 3,
        },
        0: {
            slidesPerView: 2,
        },
    },
  });

  var swiper = new Swiper(".treasuresSlide", {
    slidesPerView: 5,
    slidesPerColumn: 2,
    autoplay: {
    delay: 3000,
    },
    loop: true,
    navigation: {
        nextEl: ".treasures-button-next",
        prevEl: ".treasures-button-prev",
    },
    breakpoints: {
        992: {
            slidesPerView: 5,
        },
        768: {
            slidesPerView: 4,
        },
        480: {
            slidesPerView: 3,
        },
        0: {
            slidesPerView: 2,
        },
    },
  });

  var swiper = new Swiper(".bagSlide", {
    slidesPerView: 5,
    slidesPerColumn: 2,
    autoplay: {
    delay: 3000,
    },
    loop: true,
    navigation: {
        nextEl: ".bag-button-next",
        prevEl: ".bag-button-prev",
    },
    breakpoints: {
        992: {
            slidesPerView: 5,
        },
        768: {
            slidesPerView: 4,
        },
        480: {
            slidesPerView: 3,
        },
        0: {
            slidesPerView: 2,
        },
    },
  });

  var swiper = new Swiper(".jewelrySlide", {
    slidesPerView: 5,
    slidesPerColumn: 2,
    autoplay: {
    delay: 3000,
    },
    loop: true,
    navigation: {
        nextEl: ".jewelry-button-next",
        prevEl: ".jewelry-button-prev",
    },
    breakpoints: {
        992: {
            slidesPerView: 5,
        },
        768: {
            slidesPerView: 4,
        },
        480: {
            slidesPerView: 3,
        },
        0: {
            slidesPerView: 2,
        },
    },
  });

  var swiper = new Swiper(".shoesSlide", {
    slidesPerView: 5,
    slidesPerColumn: 2,
    autoplay: {
    delay: 3000,
    },
    loop: true,
    navigation: {
        nextEl: ".shoes-button-next",
        prevEl: ".shoes-button-prev",
    },
    breakpoints: {
        992: {
            slidesPerView: 5,
        },
        768: {
            slidesPerView: 4,
        },
        480: {
            slidesPerView: 3,
        },
        0: {
            slidesPerView: 2,
        },
    },
  });

  var swiper = new Swiper(".brandsSlide", {
    slidesPerView: 5,
    slidesPerColumn: 2,
    spaceBetween: 100,
    autoplay: {
    delay: 3000,
    },
    loop: true,
    navigation: {
        nextEl: ".brands-button-next",
        prevEl: ".brands-button-prev",
    },
    breakpoints: {
        992: {
            slidesPerView: 5,
        },
        768: {
            slidesPerView: 4,
        },
        480: {
            slidesPerView: 3,
        },
        0: {
            slidesPerView: 2,
        },
    },
  });

 