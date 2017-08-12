var properties_details = app['properties_details'] = {};
var property_latitude;
var property_longitude;
var properties_details_coordinates;
var properties_details_map_options = {};
var properties_details_panorama_options = {};
var properties_details_map;
var properties_details_panorama;
var properties_mapa_processo = false;
var properties_slide_status = false;

(function (window, document, $, undefined) {
  'use strict';

  var section_body = $('#section-body');
  property_latitude = section_body.data('property_latitude');
  property_longitude = section_body.data('property_longitude');

  properties_details.mapa = function(callback){
    properties_details_coordinates = new google.maps.LatLng(property_latitude, property_longitude);

    properties_details_map_options = {
      center: properties_details_coordinates,
      zoom: 18
    };

    properties_details_panorama_options = {
      position: properties_details_coordinates,
      pov: {
        heading: 34,
        pitch: 10
      }
    };

    properties_details_map = new google.maps.Map(document.getElementById('map'), properties_details_map_options);
    properties_details_panorama = new google.maps.StreetViewPanorama(document.getElementById('street-map'), properties_details_panorama_options);

    properties_details_map.setStreetView(properties_details_panorama);

    if(callback) callback();
  };

  properties_details.mapa_processo = function(callback) {
    if(!properties_mapa_processo){
        properties_mapa_processo = true;
        properties_details.mapa(callback);
    }else{
        callback();
    }
  };

  // properties_details.slick = function(local, status) {
  //   var slide = $(local);

  //   if(status == 'slick') {
  //     if(!properties_slide_status){
  //       properties_slide_status = true;
  //       slide.slick({
  //         speed: 500,
  //         autoplay: false,
  //         autoplaySpeed: 4000,
  //         slidesToShow: 1,
  //         slidesToScroll: 1,
  //         arrows: true,
  //         accessibility: true,
  //         asNavFor: '.slideshow-nav'
  //       });
  //     }
  //   }else{
  //     properties_slide_status = false;
  //     slide.slick("unslick");
  //   }
  // }

  properties_details.init_gallery = function(){
    var property_slideshow = $('.properties-slideshow.owl-carousel');
    property_slideshow.owlCarousel({
        items:1,
        lazyLoad:true,
        loop:false,
        nav: true,
        navText : ["",""],
        margin:0
    });
  };

  properties_details.init_map = function(){
    properties_details.mapa_processo(function(){
      var center = properties_details_panorama.getPosition();
      google.maps.event.trigger(properties_details_map, "resize");
      properties_details_map.setCenter(center);
    });
  };


  properties_details.init = function(){

    if($('#gallery').hasClass('active')){
      properties_details.init_gallery();
    }

    $('a[href="#gallery"]').on('shown.bs.tab', function (e) {
      property_slideshow.trigger('to.owl.carousel', [0,10,true] );
    });

    if($('#map').hasClass('active')){
      properties_details.init_map();
    }

    $('a[href="#map"]').on('shown.bs.tab', function (e) {
      properties_details.init_map();
    });

    $('a[href="#street-map"]').on('shown.bs.tab', function (e) {
      properties_details.mapa_processo(function(){
        properties_details_coordinates = properties_details_panorama.getPosition();
        properties_details_panorama_options.position = properties_details_coordinates;
        properties_details_panorama = new google.maps.StreetViewPanorama(document.getElementById('street-map'), properties_details_panorama_options);
        properties_details_map.setStreetView(properties_details_panorama);
      });
    });

    $('a.go-to-section').bind('click', function(event) {
      var $link = $(this);
      var $section = $($link.attr('data-go-to') ? $link.attr('data-go-to') : $link.attr('href'));
      var $position = $section.offset().top;

      if($link.attr('data-respiro')){
        var $respiro = $link.attr('data-respiro');

        if($respiro < 0){
          console.log('tira');
          $position = (parseInt($position) + parseInt($respiro));
        }else{
          console.log('add');
          $position = (parseInt($position) - parseInt($respiro));
        }
      }

      $('html, body').stop().animate({
        scrollTop: $position
      }, 500, 'easeInOutExpo');

      event.preventDefault();
    });


    var SPMaskBehavior = function (val) {
      return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
      onKeyPress: function(val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };

    $('.phone-mask').mask(SPMaskBehavior, spOptions);
  };

  properties_details.init();

}(this, document, jQuery));



// $(function(){










// }); //$function




// var map = null;
// var panorama = null;
// var fenway = new google.maps.LatLng(25.762449, -80.188872);
// var mapOptions = {
//     center: fenway,
//     zoom: 12
// };
// var panoramaOptions = {
//     position: fenway,
//     pov: {
//         heading: 34,
//         pitch: 10
//     }
// };
// var tabsHeight = function() {
//     //jQuery(".detail-media .tab-content").css('min-height',jQuery("#gallery").innerHeight());
//     jQuery("#map,#street-map").css('min-height',jQuery(".detail-media #gallery").innerHeight());
// };

// jQuery(window).on('load',function(){
//     tabsHeight();
// });
// jQuery(window).on('resize',function(){
//     tabsHeight();
// });
// function initialize() {

//     map = new google.maps.Map(document.getElementById('map'), mapOptions);
//     panorama = new google.maps.StreetViewPanorama(document.getElementById('street-map'), panoramaOptions);
//     map.setStreetView(panorama);
// }



// jQuery('a[href="#map"]').on('shown.bs.tab', function (e) {
//     var center = panorama.getPosition();
//     google.maps.event.trigger(map, "resize");
//     map.setCenter(center);
// });
// jQuery('a[href="#street-map"]').on('shown.bs.tab', function (e) {
//     fenway = panorama.getPosition();
//     panoramaOptions.position = fenway;
//     panorama = new google.maps.StreetViewPanorama(document.getElementById('street-map'), panoramaOptions);
//     map.setStreetView(panorama);
// });
// google.maps.event.addDomListener(window, 'load', initialize);
