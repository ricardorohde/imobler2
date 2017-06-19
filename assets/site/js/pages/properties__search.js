var properties_search = app['properties_search'] = {};
var ajax_process = null;
var property_item_template = null;
var property_search_location_item_template = null;
var properties_search_images_slider = null;

jQuery.fn.toggleAttr = function(attr) {
  return this.each(function() {
    var $this = $(this);
    $this.attr(attr) ? $this.removeAttr(attr) : $this.attr(attr, attr);
  });
};

(function (window, document, $, undefined) {
  'use strict';

  properties_search.slider = function() {

    if(properties_search_images_slider){
      properties_search_images_slider.trigger('destroy.owl.carousel').removeClass().addClass('properties-search-images owl-carousel owl-theme');
      properties_search_images_slider.find('.owl-stage-outer').children().unwrap();

      properties_search_images_slider = null;
      console.log('slider destroy');
    }

    properties_search_images_slider = $('.properties-search-images');

    properties_search_images_slider.owlCarousel({
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

  properties_search.getFilter = function(name, url) {
      if (!url) url = window.location.href;
      name = name.replace(/[\[\]]/g, "\\$&");
      var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
          results = regex.exec(url);
      if (!results) return null;
      if (!results[2]) return '';
      return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  properties_search.populate = function(properties){
    if(properties.results){
      window.history.pushState('page2', 'Title', properties.url_new);

      properties['site_base_url'] = app.base_url();

      if(property_item_template){
        var rendered = Mustache.render(property_item_template, properties);
        $('#properties-list').html(rendered);
        properties_search.slider();
      }else{
        $.get(app.get_asset_url('templates/properties-search__property-item.mustache'), function(template) {
          property_item_template = template;
          var rendered = Mustache.render(template, properties);
          $('#properties-list').html(rendered);
          properties_search.slider();
        });
      }

      if(properties.pagination){
        $('#properties-pagination').html(properties.pagination);
      }else{
        $('#properties-pagination').html('');
      }
    }else{
      window.history.pushState('page2', 'Title', properties.url_new);

      $('#properties-list').html('Nada ver');
      $('#properties-pagination').html('');
    }
  };

  properties_search.form_submit = function(){
    var $form = $('#properties-list-form');

    var $data = $form.serializeArray();
    $data.push({'name':'ajaxsubmit','value':'true'});

    $form.ajaxSubmit({
        dataType: 'json',
        data: $data,
        success: function(properties) {
          properties_search.populate(properties);
        },

        error: function(){
          swal(
            'Ooops!',
            'Ocorreu um erro no processamento. Pedimos desculpas pelo ocorrido, nós já fomos avisados e vamos corrigir o problema. Por favor, continue navegando normalmente.',
            'error'
          );
        }
    });
  };

  properties_search.poulate_location = function(new_location, callback) {

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

    if(property_search_location_item_template){
      var rendered = Mustache.render(property_search_location_item_template, {'location' : locations});
      $('#property-location-items').html(rendered);
      if(!repeated){
        properties_search.form_submit();
      }
    }else{
      $.get(app.get_asset_url('templates/properties-search__filter-location.mustache'), function(template) {
        property_search_location_item_template = template;
        var rendered = Mustache.render(property_search_location_item_template, {'location' : locations});
        $('#property-location-items').html(rendered);
        if(!repeated){
          properties_search.form_submit();
        }
      });
    }

    if(repeated){
      setTimeout(function(){
        $('.properties-search-location-item.has-repeated').removeClass('has-repeated');
      }, 1000);
    }

    if(callback) return callback(repeated);

    return repeated;
  };

  properties_search.init = function() {
    var properties_types = $('#properties_types');
    properties_types.hide();
    properties_types.selectpicker();
    $('#properties_types__container').on('hide.bs.dropdown', function () {
        properties_search.form_submit();
    });

    var property_listing_order = $('#property-listing-order');
    property_listing_order.hide();
    property_listing_order.selectpicker();
    $('.sort-tab').on('hide.bs.dropdown', function () {
        properties_search.form_submit();
    });



    // MASK
    $('.price-mask, .area-mask').mask('000.000.000.000.000', {reverse: true});

    // PRICE/AREA
    var text_input_timeout = 0;
    var text_input_changed = false;
    $('#search-min_price, #search-max_price, #search-min_area, #search-max_area').on('keyup', function(){
      text_input_changed = true;
      clearTimeout(text_input_timeout);
      text_input_timeout = setTimeout(properties_search.form_submit, 500);
    });

    $('#search-min_price, #search-max_price, #search-min_area, #search-max_area').on('blur', function(){
      if(text_input_changed){
        text_input_changed = false;
        properties_search.form_submit();
      }
    });

    app.body.on('click', '.pagination-item', function(e){
      var $this = $(this);

      $.ajax({
        url: app.base_url('buscar-imoveis'),
        method: 'post',
        dataType: 'json',
        data: {
          'ajaxsubmit' : 'true',
          '_' : properties_search.getFilter('_', $this.attr('href')),
          'page' : $this.attr('data-ci-pagination-page')
        }
      }).done(function(properties) {
        properties_search.populate(properties);
      });

      e.preventDefault();
    });

    window.onpopstate = function(e){
      var $data = {
        'ajaxsubmit' : 'true',
        'url' : window.location.href
      };

      var $filter = properties_search.getFilter('_');
      if($filter){
        $data['_'] = $filter;
      }

      $.ajax({
        url: app.base_url('buscar-imoveis'),
        method: 'post',
        dataType: 'json',
        data: $data
      }).done(function(properties) {
        properties_search.populate(properties);
      });

    };

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

        properties_search.poulate_location(new_location);

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
          properties_search.poulate_location();
        });
      }else{
        $this.remove();
        properties_search.poulate_location();
      }
    });

    $('#properties-list-form').submit(function(e){
      properties_search.form_submit();
      e.preventDefault();
    });

    $('.radio-as-button input[type="radio"]').on('click', function(){
      $(this).toggleAttr('checked');
      properties_search.form_submit();
    });

    $('input[name="params[property_features][]"]').on('click', function(){
      properties_search.form_submit();
    });

    properties_search.slider();
  };

  properties_search.init();

}(this, document, jQuery));
