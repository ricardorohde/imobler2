var account_favorites = app['account_favorites'] = {};
var account_favorites_images_slider = null;

(function (window, document, $, undefined) {
  'use strict';

  account_favorites.slider = function() {

    if(account_favorites_images_slider){
      account_favorites_images_slider.trigger('destroy.owl.carousel').removeClass().addClass('properties-search-images owl-carousel owl-theme');
      account_favorites_images_slider.find('.owl-stage-outer').children().unwrap();

      account_favorites_images_slider = null;
      console.log('slider destroy');
    }

    account_favorites_images_slider = $('.properties-search-images');

    account_favorites_images_slider.owlCarousel({
      loop: false,
      margin:0,
      responsiveClass: true,
      lazyLoad:true,
      dots: false,
      navText : ["",""],
      responsive:{
        0:{
          items: 1,
          nav: true
        }
      }
    });

    console.log('slider init');
  };

  account_favorites.slider();

}(this, document, jQuery));
