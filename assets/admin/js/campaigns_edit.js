var campaigns_edit = app['campaigns_edit'] = {};
var ajax_process = null;
var property_item_template = null;
var property_search_location_item_template = null;
var campaigns_edit_images_slider = null;

// jQuery.fn.toggleAttr = function(attr) {
//   return this.each(function() {
//     var $this = $(this);
//     $this.attr(attr) ? $this.removeAttr(attr) : $this.attr(attr, attr);
//   });
// };

(function (window, document, $, undefined) {
  'use strict';

  // campaigns_edit.slider = function() {

  //   if(campaigns_edit_images_slider){
  //     campaigns_edit_images_slider.trigger('destroy.owl.carousel').removeClass().addClass('properties-search-images owl-carousel owl-theme');
  //     campaigns_edit_images_slider.find('.owl-stage-outer').children().unwrap();

  //     campaigns_edit_images_slider = null;
  //     console.log('slider destroy');
  //   }

  //   campaigns_edit_images_slider = $('.properties-search-images');

  //   campaigns_edit_images_slider.owlCarousel({
  //     loop: false,
  //     margin:0,
  //     responsiveClass: true,
  //     lazyLoad:true,
  //     dots: false,
  //     navText : ["",""],
  //     responsive:{
  //       0:{
  //         items: 1,
  //         nav: true
  //       }
  //     }
  //   });

  //   console.log('slider init');
  // };

  // campaigns_edit.getFilter = function(name, url) {
  //   if (!url) url = window.location.href;
  //   name = name.replace(/[\[\]]/g, "\\$&");
  //   var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
  //       results = regex.exec(url);
  //   if (!results) return null;
  //   if (!results[2]) return '';
  //   return decodeURIComponent(results[2].replace(/\+/g, " "));
  // }

  // campaigns_edit.populate = function(properties){
  //   if(properties.results){
  //     window.history.pushState('page2', 'Title', properties.url_new);

  //     properties['site_base_url'] = app.base_url();

  //     app.mustache('campaigns-location-item', function(template){
  //         var rendered = Mustache.render(template, properties);
  //         $('#properties-list').html(rendered);
  //     });

  //     if(property_item_template){
  //       var rendered = Mustache.render(property_item_template, properties);
  //       $('#properties-list').html(rendered);
  //       campaigns_edit.slider();
  //     }else{
  //       $.get(app.get_asset_url('templates/.mustache'), function(template) {
  //         property_item_template = template;

  //       });
  //     }

  //     if(properties.pagination){
  //       $('#properties-pagination').html(properties.pagination);
  //     }else{
  //       $('#properties-pagination').html('');
  //     }
  //   }else{
  //     window.history.pushState('page2', 'Title', properties.url_new);

  //     $('#properties-list').html('Nada ver');
  //     $('#properties-pagination').html('');
  //   }

  //   $('body, html').animate({ scrollTop: 0 },"slow");
  // };

  // campaigns_edit.form_submit = function(){
  //   var $form = $('#properties-list-form');

  //   var $data = $form.serializeArray();
  //   $data.push({'name':'ajaxsubmit','value':'true'});

  //   $form.ajaxSubmit({
  //       dataType: 'json',
  //       data: $data,
  //       success: function(properties) {
  //         campaigns_edit.populate(properties);
  //       },

  //       error: function(){
  //         swal(
  //           'Ooops!',
  //           'Ocorreu um erro no processamento. Pedimos desculpas pelo ocorrido, nós já fomos avisados e vamos corrigir o problema. Por favor, continue navegando normalmente.',
  //           'error'
  //         );
  //       }
  //   });
  // };

  campaigns_edit.poulate_location = function(new_location, callback) {

    var locations = [];
    var repeated = false;
    var count = 0;

    $.each($('.properties-search-location-item'), function(location_index, location_item){
      var $this = $(location_item);
      var has_repeated = false;

      if(typeof new_location != 'undefined'){
        if(new_location.label === $this.find('input[data-area="label"]').val()){
          repeated = true;
          has_repeated = true;
        }
      }

      var location = {};

      $.each($this.find('input'), function(item_index, item_value){
        var $item = $(item_value);
        location[$item.attr('data-area')] = $item.attr('value');
      });

      location['index'] = count;
      if(has_repeated){
        location['repeated'] = true;
      }
      locations.push(location);

      count++;
    });

    if(typeof new_location != 'undefined'){
      if(!repeated){
        new_location['index'] = count;
        locations.push(new_location);
      }
    }

    app.mustache('campaigns-location-item', function(template){
      var rendered = Mustache.render(template, {'location' : locations});
      $('#property-location-items').html(rendered);
    });

    if(callback) return callback(repeated);

    return repeated;
  };

  campaigns_edit.init = function() {




    // MASK
    $('.price-mask').mask('000.000.000.000.000,00', {reverse: true});
    $('.area-mask').mask('000.000.000.000.000', {reverse: true});

    $('textarea[maxlength]').maxlength({
      alwaysShow: true,
      threshold: 10,
      warningClass: "label label-info",
      limitReachedClass: "label label-danger"
    });


    // LOCATION AUTOCOMPLETE
    $.widget("custom.catcomplete", $.ui.autocomplete, {
      _create: function() {
        this._super();
        this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
      },
      _renderMenu: function( ul, items ) {
        var that = this,
        currentCategory = "";
        $.each( items, function( index, item ) {
          var li;
          if ( item.category.slug != currentCategory ) {
            ul.append( "<li class='ui-autocomplete-category'>" + item.category.name + "</li>" );
            currentCategory = item.category.slug;
          }
          li = that._renderItemData( ul, item );
          if ( item.category.slug ) {
            li.attr( "aria-label", item.category.slug + " : " + item.label );
          }
        });
      }
    });

    $(".input-search-local").catcomplete({
      source: app.base_url('api/get_locations'),
      minLength: 2,
      delay: 250,
      select: function(event, ui) {
        var new_location = ui.item.location;
        new_location.label = ui.item.label;

        console.log(new_location);

        campaigns_edit.poulate_location(new_location);

        setTimeout(function(){
          $(".input-search-local").val('');
        }, 200);
      }
    });

    // REMOVER LOCALIZAÇÃO
    $('#property-location-items').on('click', '.property-location-item-remove', function(){
      var $this = $(this).closest('.properties-search-location-item');

      if($('.properties-search-location-item').length == 1){
        swal({
          title: 'Você tem cereza?',
          text: "Quanto mais específica sua busca, maiores chances de encontrar o imóvel perfeito. Quer mesmo remover todas as regiões de sua busca?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Remover',
          cancelButtonText: 'Não remover'
        }).then(function () {
          $this.remove();
          campaigns_edit.poulate_location();
        });
      }else{
        $this.remove();
        campaigns_edit.poulate_location();
      }
    });

  };

  campaigns_edit.init();

}(this, document, jQuery));
