var home = app['home'] = {};
var search_process = false;

(function (window, document, $, undefined) {
  'use strict';

  home.get_search_url_by_location = function(){
    var url = '';

    // Transaction
    if($('#banner-search-main-transaction').val().length){
      url += $('#banner-search-main-transaction').val() + '/';
    }

    // State
    if($('#banner-search-main-state').val().length){
      url += $('#banner-search-main-state').val() + '/';
    }

    // City
    if($('#banner-search-main-city').val().length){
      url += $('#banner-search-main-city').val() + '/';
    }

    // District
    if($('#banner-search-main-district').val().length){
      url += $('#banner-search-main-district').val() + '/';
    }

    // Property Type
    var property_type = $('#banner-search-main-properties_types').find('option:selected').val();
    if(property_type.length){
      url += property_type + '/';
    }

    // Redirect
    window.location.href = app.base_url(url);
  };

  home.init = function() {
    $('.selectpicker').selectpicker();

    $.widget( "custom.catcomplete", $.ui.autocomplete, {
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
      select: function( event, ui ) {
        search_process = true;

        $('#banner-search-main-state').val(ui.item.location.state);
        $('#banner-search-main-city').val(ui.item.location.city);
        $('#banner-search-main-district').val(ui.item.location.district);

        $('.btn-submit').removeAttr('disabled');

        home.get_search_url_by_location();
      }
    });

    $('#form-search-local').submit(function(e){
      home.get_search_url_by_location();
      e.preventDefault();
    });
  };

  home.init();

}(this, document, jQuery));
