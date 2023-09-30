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

  jQuery( function($) {
      $( ".slider-range" ).slider({
          range: true,
          min: 0,
          max: 10000,
          values: [ 5     , 6000 ],
          slide: function( event, ui ) {
              $( "#amount" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
              $( "#price" ).val( "" + ui.values[ 0 ] + "," + ui.values[ 1 ] );
              $("#searchForm").submit();
          }
      });
      $( "#amount" ).val( "" + $( ".slider-range" ).slider( "values", 0 ) +
          " - " + $( ".slider-range" ).slider( "values", 1 ) );
      $( "#price" ).val( "" + $( ".slider-range" ).slider( "values", 0 ) +
          "," + $( ".slider-range" ).slider( "values", 1 ) );
  } );

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

  $(document).ready(function(){

      var quantitiy=0;
      $('#plus-btn').click(function(e){

          // Stop acting like a button
          e.preventDefault();
          // Get the field name
          var quantity = parseInt($('#qty_input').val());

          // If is not undefined

          $('#qty_input').val(quantity + 1);


          // Increment

      });

      $('#minus-btn').click(function(e){
          // Stop acting like a button
          e.preventDefault();
          // Get the field name
          var quantity = parseInt($('#qty_input').val());

          // If is not undefined

          // Increment
          if(quantity>0){
              $('#qty_input').val(quantity - 1);
          }
      });

  });

  function addToCompare(pro_id){
      $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/addtoCompare",
          data: {product_id:pro_id},
          success: function(response){
              $('#mesVal').html(response);
              $('.message_alert').show();
              setTimeout(function(){ $("#messAlt").fadeOut(1500);}, 600);
          }
      });
  }

  function removeToCompare(key_id){
      $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/removeToCompare",
          data: {key_id:key_id},
          success: function(response){
              $('#compReload').load(location.href + " #compReload");
              $('#mesVal').html(response);
              $('.message_alert').show();
              setTimeout(function(){ $("#messAlt").fadeOut(1500);}, 600);
          }
      });
  }

  function addToWishlist(pro_id){
      $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/addtoWishlist",
          data: {product_id:pro_id},
          success: function(response){
              $('#mesVal').html(response);
              $('.message_alert').show();
              setTimeout(function(){ $("#messAlt").fadeOut(1500);}, 600);
          }
      });
  }

  function removeToWishlist(proId){
      $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/removeToWishlist",
          data: {product_id:proId},
          success: function(response){
              $('#reloadDiv').load(location.href + " #reloadDiv");
              $('#mesVal').html(response);
              $('.message_alert').show();
              setTimeout(function(){ $("#messAlt").fadeOut(1500);}, 600);
          }
      });
  }



  function addToCart(pro_id){
      var size = $("input[name='size']:checked").val();
      var color = $("input[name='color']:checked").val();

      $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/checkoption",
          data: {product_id:pro_id },
          success: function(response){
              if (response == true){
                  adtocartAction(pro_id);
              }else{
                  if (size == null  ||  color == null){
                      $('.mes-1').html('Required field');
                      $('.mes-2').html('Required field');
                  }else{
                      $('.mes-1').html('');
                      $('.mes-2').html('');
                      adtocartAction(pro_id);
                  }
              }
          }
      });
  }
  function adtocartAction(pro_id){
      var qty = $('#qty_input').val();
      if (qty == null){
          qty = '1';
      }
      var size = $("input[name='size']:checked").val();
      if (size == null){
          size = '';
      }
      var color = $("input[name='color']:checked").val();
      if (color == null){
          color = '';
      }
      $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/addtocart",
          data: {product_id:pro_id,qtyall:qty,size:size,color:color },
          success: function(response){
              $('#cartReload').load(location.href + " #cartReload");
              $('#cartReload2').load(location.href + " #cartReload2");
              $('#mesVal').html(response);
              $('.btn-count').load(location.href + " .btn-count");
              $('.body-count').load(location.href + " .body-count");
              $('#carticon2').css('transform','rotate(90deg)');
              $( '#collapseExample' ).addClass('show');
              $('.message_alert').show();
              setTimeout(function(){ $("#messAlt").fadeOut(1500);}, 600);
          }
      });
  }

  function addToCartdetail(){
      $("#addto-cart-form").on('submit', (function(e) {
          e.preventDefault();
          $.ajax({
              url: $(this).attr('action'),
              type: "POST",
              data: new FormData(this),
              contentType: false,
              cache: false,
              processData: false,
              success: function(response) {
                  $('#cartReload').load(location.href + " #cartReload");
                  $('#cartReload2').load(location.href + " #cartReload2");
                  $('#mesVal').html(response);
                  $('.btn-count').load(location.href + " .btn-count");
                  $('.body-count').load(location.href + " .body-count");
                  $('#carticon2').css('transform','rotate(90deg)');
                  $( '#collapseExample' ).addClass('show');

                  $('.message_alert').show();
                  setTimeout(function(){ $("#messAlt").fadeOut(1500);}, 600);

              }
          });
      }));
  };

  function checkoption(pro_id){
      var result;
      $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/checkoption",
          data: {product_id:pro_id },
          success: function(response){
              result = response;
          }
      });
      return result;
  }



  function minusItem(rowid){
      var quantity = parseInt($('.item_'+rowid).val());
      if(quantity>1){
          $('.item_'+rowid).val(quantity - 1);
      }
      $('#btn_'+rowid).show();
  }

  function plusItem(rowid){
      var quantity = parseInt($('.item_'+rowid).val());
      $('.item_'+rowid).val(quantity + 1);
      $('#btn_'+rowid).show();

  }

  function updateQty(rowid){
      var qty = $('.item_'+rowid).val();
      $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/updateToCart",
          data: {rowid:rowid,qty:qty },
          success: function(response){
              $('#cartReload').load(location.href + " #cartReload");
              $('#tableReload').load(location.href + " #tableReload");
              $('#cartReload2').load(location.href + " #cartReload2");
              $('#mesVal').html(response);
              $('.btn-count').load(location.href + " .btn-count");
              $('.body-count').load(location.href + " .body-count");
              $( '#collapseExample' ).addClass('show');
              $('.message_alert').show();
              setTimeout(function(){ $("#messAlt").fadeOut(1500);}, 600);
          }
      });
  }

  function removeCart(rowid){
      $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/removeToCart",
          data: {rowid:rowid},
          success: function(response){
              $('#cartReload').load(location.href + " #cartReload");
              $('#cartReload2').load(location.href + " #cartReload2");
              $('#tableReload').load(location.href + " #tableReload");
              $('#mesVal').html(response);
              $('.btn-count').load(location.href + " .btn-count");
              $('.body-count').load(location.href + " .body-count");
              $( '#collapseExample' ).addClass('show');
              $('.message_alert').show();
              setTimeout(function(){ $("#messAlt").fadeOut(1500);}, 600);
          }
      });
  }

  function pass_show(val){
      var html = '<h6 class="mt-2">Change information</h6><div class="form-group mt-4"><label>Current password</label><input type="password" name="current_password" class="form-control" placeholder="Current password" required></div><div class="form-group mt-4"><label>New password</label><input type="password" name="new_password" class="form-control" placeholder="New password" required></div><div class="form-group mt-4"><label>Confirm password</label><input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" required></div>';
      if (val == '1') {
          $('#passReset').val(0);
          $('#pass-data').html(html);
      }else{
          $('#passReset').val(1);
          $('#pass-data').html('');
      }
  }

  function selectState(country_id,id){
      $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/checkout_country_zoon",
          data: {country_id:country_id},
          success: function(data){
              $('#'+id).html(data);
          }
      });
  }

  function user_create(){

      var createNew = $('#createNew').val();
      var html = '<div class="row"><div class="col-lg-6"><div class="form-group mb-4"><label class="w-100" for="password">Password</label><input class="form-control rounded-0" type="password" name="password" id="password" placeholder="Password"  required></div></div> <div class="col-lg-6"><div class="form-group mb-4"><label class="w-100" for="password">Confirm Password</label><input class="form-control rounded-0" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"  required></div></div></div>'
      if (createNew == 0){
          $('#createNew').val(1);
          $('#regData').html(html);
      }else{
          $('#createNew').val(0);
          $('#regData').html('');
      }
  }


  function shippingCharge(){
      var paymethod = $('#shipping_method:checked').val();
      var cityId = $('#stateView').val();
      var totalAmount = $('#totalamo').val();
      var shipcityId = $('#sh_stateView').val();
              $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/shipping_rate",
          data: {amount:totalAmount,city_id:cityId,shipCityId:shipcityId,paymethod:paymethod},
          dataType: 'json',
          success: function(data){
              var charge = Number(data.charge);
              var total = Number(totalAmount);
              var amount = total+charge;

              $('#chargeShip').html('৳ '+data.charge);
              $('#total').html('৳ '+amount);
              $('#shipping_charge').val(charge);
          }
      });
  }

  function viewStyle(view){
      if (view == 'list'){
          $( "#list-btn" ).addClass( 'active-view');
          $( "#gird-btn" ).removeClass( 'active-view');
          $( "#grid-view" ).hide();
          $( "#list-view" ).show();
      }
      if (view == 'gird'){
          $( "#gird-btn" ).addClass( 'active-view');
          $( "#list-btn" ).removeClass( 'active-view');
          $( "#grid-view" ).show();
          $( "#list-view" ).hide();
      }
  }

  function formSubmit(){
      $("#searchForm").submit();
  }
  function subscription(){

      $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/newsletter_action",
          success: function(data){
              $("#message").html(data);
          }
      });
  }

  function bothPriceCalculat(){

      var formData = $('#both-product').serialize();
      $.ajax({
          type: "POST",
          url: 'http://eCommerce_amazingGadgets.test/both_product_price',
          data: formData,
          success: function(data) {
              $('#price-both').html(data);
          }
      });


  }

  function groupAdtoCart(){
      var formData = $('#both-product').serialize();
      $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/addtocartgroup",
          data: formData,
          success: function(response){
              $('#cartReload').load(location.href + " #cartReload");
              $('#cartReload2').load(location.href + " #cartReload2");
              $('#mesVal').html(response);
              $('.btn-count').load(location.href + " .btn-count");
              $('.body-count').load(location.href + " .body-count");
              $( '#collapseExample' ).addClass('show');
              $('.message_alert').show();
              setTimeout(function(){ $("#messAlt").fadeOut(1500);}, 600);
          }
      });
  }

  function subscribe(){
      var email = $('#subscribe_email').val();
      if (email == ''){
          $('#mesVal').html('Email required');
          $('.message_alert').show();
          setTimeout(function () {
              $("#messAlt").fadeOut(1500);
          }, 600);
      }else {
          $.ajax({
              method: "POST",
              url: "http://eCommerce_amazingGadgets.test/user_subscribe",
              data: {email:email},
              success: function (response) {
                  $('#subscribe_email').val('');
                  $('#mesVal').html(response);
                  $('.message_alert').show();
                  setTimeout(function () {
                      $("#messAlt").fadeOut(1500);
                  }, 600);
              }
          });
      }
  }

  function optionPriceCalculate(product_id){
              var size = $('input[name="size"]:checked').val();
              var color = $('input[name="color"]:checked').val();
              $.ajax({
          method: "POST",
          url: "http://eCommerce_amazingGadgets.test/optionPriceCalculate",
          data: {
              product_id:product_id,
                                  size: size,
                                  color: color,
                          },
          success: function (data) {
              $('#priceVal').html(data);
          }
      });
  }

  function video_close(){
      $("#sample_video")[0].src += "?autoplay=0";
  }

  function topSearchValidation(formId,catId,keyId,validId){

      var cat = $('#'+catId).val();
      var key = $('#'+keyId).val();

      if ((cat == '') && (key == '')){
          $('#'+validId).css('border','1px solid #ff0000');
          $('#'+keyId).attr("placeholder", "Please type something to search....");
      }else{
          $('#'+formId).submit();
      }

      // border: 1px solid red;
  }

  function livenameView(newVal,viewId){
      var f = $('#fname').val();
      var l = $('#lname').val();
      $('#'+viewId).html(f+' '+l);
  }

  function livename1View(newVal,viewId){
      var f = $('#fname1').val();
      var l = $('#lname1').val();
      $('#'+viewId).html(f+' '+l);
  }

  function liveTextView(newVal,viewId){

      $('#'+viewId).html(newVal);

  }

  function liveView(val,viewId){
      // var data = $(val).attr(option);
      var data = $(val).find('option:selected').html();
      $('#'+viewId).html(data);
  }


  $(document).ready(function() {
      $('.toggleButton').click(function() {
          $(this).toggleClass('active');
          $(this).siblings('.elementToToggle').slideToggle();
          $(this).siblings('.elementToToggle').removeClass('d-none');
      });
  });


  
  var btnCartElements = document.getElementsByClassName('btn-cart');
// Get the Mini Cart element
var miniCart = document.getElementById('miniCart');
for (var i = 0; i < btnCartElements.length; i++) {
  var btnCartElement = btnCartElements[i];
  btnCartElement.addEventListener('click', function() {
    // Show the Mini Cart
    miniCart.classList.add('show');
    setTimeout(function() {
      miniCart.classList.remove('show');
    }, 5000);
  });
}