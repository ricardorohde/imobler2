var properties_edit = app['properties_edit'] = {};
var properties_edit__init_mapa;

var properties_edit__map;
var properties_edit__markers = [];

$(function(){

  var properties_edit__google_loaded = function(callback) {
    if (typeof google === 'object' && typeof google.maps === 'object') {
      console.log('loaded');
    }
  }

  properties_edit__init_mapa = function() {
    var haightAshbury = {lat: -23.501473, lng: -46.736422};

    properties_edit__map = new google.maps.Map(document.getElementById('localizacao_mapa'), {
      zoom: 17,
      center: haightAshbury,
      mapTypeId: 'roadmap'
    });

    // Adds a marker at the center of the map.
    properties_edit__addMarker(haightAshbury);
  };

  var properties_edit__delMarker = function(map) {
    for (var i = 0; i < properties_edit__markers.length; i++) {
      properties_edit__markers[i].setMap(map);
    }
  }


  // Adds a marker to the map and push to the array.
  var properties_edit__addMarker = function(location) {
    properties_edit__delMarker(null);

    var imovel = new google.maps.Marker({
      position: location,
      map: properties_edit__map,
      title: 'Localização do imóvel',
      icon: app.get_asset_url('img/icon-imovel.png')
    });

    properties_edit__markers.push(imovel);

    $("#latitude").val(imovel.getPosition().lat());
    $("#longitude").val(imovel.getPosition().lng());
    $("#latitude_site").val('');
    $("#longitude_site").val('');

    var centro = new google.maps.Marker({
      position: location,
      map: properties_edit__map,
      draggable:true,
      title: 'Localização aproximada do imóvel'
    });

    properties_edit__markers.push(centro);

    google.maps.event.addListener(centro, 'dragend', function() {
      properties_edit__map.panTo(centro.getPosition());
      $("#latitude_site").val(centro.getPosition().lat());
      $("#longitude_site").val(centro.getPosition().lng());
    });
  }

  properties_edit.init_cep = function($templates, $callback){

    var cep_loading = $('.form-loading-cep');
    var options =  {
      onComplete: function(cep) {
        cep_loading.addClass('loading-active');

        $.ajax({
          url: app.base_url('admin/tools/buscar-cep/' + cep),
          dataType: 'json'
        }).done(function(response) {
          cep_loading.removeClass('loading-active');

          if(response.erro){

          }else{

            $('#logradouro').val(response.logradouro);
            $('#bairro').val(response.bairro);
            $('#cidade').val(response.localidade);
            $('#estado').val(response.uf);

            if(response.coordenadas){
              var mapaLatLng = {lat: response.coordenadas.latitude, lng: response.coordenadas.longitude};
              properties_edit__map.panTo(mapaLatLng);
              properties_edit__addMarker(mapaLatLng);
            }

            $.each($('#estado option'), function(i, item){
              if($(item).attr('data-sigla') == 'SP'){
                console.log($(item).val())
              }
            });


            jQuery.each(jQuery("#estado option"), function(i, item){
              if(response.uf == $(item).attr("data-sigla")){
                $('#estado').val($(item).val()).trigger('change');
              }
            });

          }
        });
      },
      onKeyPress: function(cep, event, currentField, options){

      },
      onChange: function(cep){
        console.log('cep changed! ', cep);
      },
      onInvalid: function(val, e, f, invalid, options){
        var error = invalid[0];
        console.log ("Digssssit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
      }
    };

    $('.cep-mask').mask('00000-000', options);
  };

  // Init
  properties_edit.init = function(){
    properties_edit.init_cep();
  };

  properties_edit.init();

}); //$function
