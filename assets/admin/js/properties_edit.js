var properties_edit = app['properties_edit'] = {};
var properties_edit__init_mapa;

var properties_edit__map;
var properties_edit__markers = [];


$(function(){

  properties_edit__init_mapa = function() {
    if (typeof google === 'object' && typeof google.maps === 'object') {
      var latitude = parseFloat($("#latitude").val());
      var longitude = parseFloat($("#longitude").val());

      var latitude_site = parseFloat($("#latitude_site").val());
      var longitude_site = parseFloat($("#longitude_site").val());

      var latitude_mapa = (latitude_site.length && (latitude_site != latitude) ? latitude_site : latitude);
      var longitude_mapa = (longitude_site.length && (longitude_site != longitude) ? longitude_site : longitude);


      var localizacao_mapa_box = $('#localizacao_mapa_box');
      var localizacao_mapa = localizacao_mapa_box.find('#localizacao_mapa');

      localizacao_mapa_box.removeClass('hide').show();
      localizacao_mapa.css('height', 400);

      properties_edit__map = new google.maps.Map(localizacao_mapa.get(0), {
        zoom: 18,
        center: {lat: latitude_mapa, lng: longitude_mapa},
        mapTypeId: 'roadmap',
        scrollwheel: false
      });

      var styles = [
         {
           featureType: "poi",
           stylers: [
            { visibility: "off" }
           ]
          }
      ];

      var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});

      properties_edit__addMarker();
    }else{
      console.log('tentando');
      setTimeout(properties_edit__init_mapa, 300);
    }
  };

  var properties_edit__delMarker = function(map) {
    for (var i = 0; i < properties_edit__markers.length; i++) {
      properties_edit__markers[i].setMap(map);
    }
  }

  var properties_edit__addMarker = function() {
    properties_edit__delMarker(null);

    var latitude = $("#latitude").val();
    var longitude = $("#longitude").val();

    var latitude_site = $("#latitude_site").val();
    var longitude_site = $("#longitude_site").val();

    var latitude_mapa = latitude_site && latitude_site != latitude ? latitude_site : latitude;
    var longitude_mapa = longitude_site && longitude_site != longitude ? longitude_site : longitude;

    properties_edit__map.panTo({lat: parseFloat(latitude_mapa), lng: parseFloat(longitude_mapa)});

    var imovel = new google.maps.Marker({
      position: {lat: parseFloat(latitude), lng: parseFloat(longitude)},
      map: properties_edit__map,
      title: 'Localização do imóvel',
      icon: app.get_asset_url('img/icon-imovel.png')
    });

    properties_edit__markers.push(imovel);

    var centro = new google.maps.Marker({
      position: {lat: parseFloat(latitude_mapa), lng: parseFloat(longitude_mapa)},
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

    $('#tags').select2({
      tags: true
    });

    var buscar_coordenadas = 0;
    $('#logradouro, #numero, #bairro, #cidade').on('keyup', function(){
      var $this = $(this);

      clearTimeout(buscar_coordenadas);


      buscar_coordenadas = setTimeout(function(){

        var endereco = $('#logradouro').val() + ($('#numero').val().length ? ',' + $('#numero').val() : '') + ($('#bairro').val().length ? '+-+' + $('#bairro').val() : '') + ($('#cidade').val().length ? '+-+' + $('#cidade').val() : '');

        $.ajax({
          url: app.base_url('admin/tools/buscar_coordenadas'),
          data: {
            'endereco' : endereco
          },
          method: 'post',
          dataType: 'json'
        }).done(function(response) {
          $("#latitude").val(response.latitude);
          $("#longitude").val(response.longitude);
          $("#latitude_site").val('');
          $("#longitude_site").val('');

          if(!properties_edit__map){
            properties_edit__init_mapa();
          }else{
            properties_edit__addMarker();
          }
        });
      }, 500);
    });

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
            swal(
              'Ooops...',
              'O CEP informado não foi encontrado. Preencha o endereço manualmente.',
              'error'
            );

            $('#logradouro').val('');
            $('#bairro').val('');
            $('#cidade').val('');
            $('#estado').val('');
            $('#estado').val('').trigger('change');
          }else{

            $('#logradouro').val(response.logradouro);
            $('#bairro').val(response.bairro);
            $('#cidade').val(response.localidade);
            $('#estado').val(response.uf);

            if(response.coordenadas){
              $("#latitude").val(response.coordenadas.latitude);
              $("#longitude").val(response.coordenadas.longitude);
              $("#latitude_site").val('');
              $("#longitude_site").val('');

              if(!properties_edit__map){
                properties_edit__init_mapa();
              }else{
                properties_edit__addMarker({lat: response.coordenadas.latitude, lng: response.coordenadas.longitude});
              }
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
    $('.price-mask').mask('000.000.000.000.000,00', {reverse: true});
    $('.area-mask').mask('000.000.000.000.000', {reverse: true});

    $('textarea[maxlength]').maxlength({
      alwaysShow: true,
      threshold: 10,
      warningClass: "label label-info",
      limitReachedClass: "label label-danger"
    });
  };

  // Init
  properties_edit.init = function(){
    if($('#latitude').val().length && $('#longitude').val().length){
      properties_edit__init_mapa();
    }

    var images_order = function(){
        var images = [];
        $.each($('.dz-item'), function(i, item){
          $(item).find('.dz-counter').html((i+1));
          images.push($(item).attr('data-image_id'));
        });

        $.ajax({
          url: app.base_url('admin/tools/ordenar_imagens'),
          data: {
            'imagens' : images
          },
          method: 'post',
          dataType: 'json'
        }).done(function(response) {
          console.log(response);
        });
    };


    $('#property-uploads--view').sortable({
      handle: ".dz-handle",
      update: function() {
        images_order();
      }
    });

    Dropzone.autoDiscover = false;

    app.mustache('properties-edit__image-item', function(template){

      var propertyDropzone = new Dropzone(".property-uploads", {
        url: app.base_url('admin/tools/enviar-imagens'),
        previewsContainer: '#property-uploads--view',
        previewTemplate: template,
        addRemoveLinks: false,
        dictDefaultMessage: 'Clique ou arraste e solte aqui, os arquivos que você deseja enviar',
        init: function() {
          var thisDropzone = this;

          var data_images = {};

          var property_id = app.body.data('property_id');
          var property_guid = $('#guid').val();
          var property_folder = 0;

          if(property_id){
            property_folder = property_id;
            data_images['property_id'] = property_id;
          }else{
            property_folder = property_guid;
            data_images['property_guid'] = property_guid;
          }

          $.ajax({
            url: app.base_url('admin/tools/imagens'),
            data: data_images,
            method: 'post',
            dataType: 'json'
          }).done(function(response) {
            $.each(response, function(key, value){
              // console.log(value);
              var mockFile = { name: value.arquivo, size: value.filesize };
              thisDropzone.options.addedfile.call(thisDropzone, mockFile);
              thisDropzone.options.thumbnail.call(thisDropzone, mockFile, app.base_url('imagens/imoveis/'+ property_folder +'/100/100/80/0/'+ value.arquivo));
              thisDropzone.emit("success", mockFile, JSON.stringify(value));
            });
            thisDropzone.emit("complete", {});
          });

          // thisDropzone.on('addedfile', function(file) {
          //   console.log('addedfile');
          //   console.log(file);
          // });




// $.get('upload.php', function(data) {

//     <!-- 5 -->
//     $.each(data, function(key,value){

//

//

//

//     });

// });

          // thisDropzone.on('chupeta', function(file, response) {
          //   var $item = $(file.previewTemplate);
          //   var $image = JSON.parse(response);

          //   $item.attr('data-image_id', $image.image_id);
          //   $item.find('.dz-caption').attr('name', 'imagens[legendas]['+ $image.image_id +']');
          // });

          thisDropzone.on('complete', function(file, response) {
            $('#property-uploads--view').sortable('refresh');
            images_order();
            console.log('complete');
          });

          thisDropzone.on('success', function(file, response) {
            var $item = $(file.previewTemplate);
            var $image = JSON.parse(response);

            $item.attr('data-image_id', $image.id);
            $item.find('.dz-caption').val($image.legenda);
            $item.find('[data-dz-name]').html($image.arquivo);


          });

          thisDropzone.on('removedfile', function(file) {
            var $item = $(file.previewTemplate);

            var data_images = {};

            var property_id = app.body.data('property_id');
            var property_guid = $('#guid').val();

            if(property_id){
              data_images['imovel'] = property_id;
            }else{
              data_images['imovel_temp'] = property_guid;
            }

            data_images['id'] = $item.attr('data-image_id');

            $.ajax({
              url: app.base_url('admin/tools/excluir_imagens'),
              data: data_images,
              method: 'post',
              dataType: 'json'
            }).done(function(response) {
              images_order();
            });
          });
        }
      });

      propertyDropzone.on('sending', function(file, xhr, formData){
        formData.append('upload_folder', 'imoveis');

        var property_id = app.body.data('property_id');
        var property_guid = $('#guid').val();

        if(property_id){
          formData.append('property_id', property_id);
        }else{
          formData.append('property_guid', property_guid);
        }
      });
    });

    var image_caption_timeout = 0;
    var image_caption_changed = false;
    var salvar_caption = function(el){
      if(el.val().length){
        $.ajax({
          url: app.base_url('admin/tools/atualizar_imagem'),
          data: {
            'id': el.closest('.dz-item').attr('data-image_id'),
            'legenda': el.val()
          },
          method: 'post',
          dataType: 'json'
        }).done(function(response) {
        });
      }
    };


    $('#property-uploads--view').on('blur', '.dz-caption.changed', function(){
      clearTimeout(image_caption_timeout);
      var $this = $(this);
      $this.removeClass('changed');
      salvar_caption($this);
    });

    $('#property-uploads--view').on('keyup', '.dz-caption', function(){
      var $this = $(this);
      $this.addClass('changed');
      clearTimeout(image_caption_timeout);
      image_caption_timeout = setTimeout(function(){
        salvar_caption($this);
      }, 500);
    });






    //
    // $('#property-images').disableSelection();


    // Dropzone.autoDiscover = false;
    // var propertyDropzone = new Dropzone(".property-uploads", {
    //     url: app.base_url('admin/tools/enviar-imagens'),
    //
    //     previewTemplate: $('#image-preview-template').html(),
    //
    //     removedfile: function(file) {
    //       // console.log(file);

    //       // var name = file.previewElement.id;
    //       // $.ajax({
    //       //   type: 'POST',
    //       //   url: 'deletefile.php',
    //       //   data: "fn="+name,
    //       //   dataType: 'html'
    //       // });

    //       // var _ref;
    //       // return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
    //     },
    //     init: function() {
    //       this.on('completemultiple', function(file, response) {
    //         //$('.sortable').sortable('enable');
    //         $('.sortable').sortable('refresh');
    //         console.log('complete');
    //       });

    //       this.on('success', function(file, response) {
            // var $item = $(file.previewTemplate);

            // var response_json = JSON.parse(response);

            // console.log('success');
            // console.log(response);


            // $item.find('.dz-input-filename').val(response_json.file_name);
            // $item.find('.dz-input-legend').val(response_json.file_name);

            // $(file.previewTemplate).find('.dz-file-preview').attr('id', "document-" + response_json.image_id);

            // console.log(JSON.parse(json));
        //   });





        //   this.on('drop', function(file) {
        //     console.log('File',file)
        //   });
        // }
        // addedfile: function(file) {
        //   file.previewElement = Dropzone.createElement(this.options.previewTemplate);
        // },
        // thumbnail: function(file, dataUrl) {
        // },
        // uploadprogress: function(file, progress, bytesSent) {
        // },

        // success: function (file, response) {
        //     var imgName = response;
        //     file.previewElement.classList.add("dz-success");
        //     console.log("Successfully uploaded :" + imgName);
        // },
        // error: function (file, response) {
        //     file.previewElement.classList.add("dz-error");
        // }
    // });



    /*(".property-uploads").dropzone({
      url: "/upload",
      maxFilesize: 100,
      paramName: "uploadfile",
      maxThumbnailFilesize: 99999,

      previewTemplate : $('.preview').html(),
      success: function (file, response) {
          var imgName = response;
          file.previewElement.classList.add("dz-success");
          console.log("Successfully uploaded :" + imgName);
      },
      error: function (file, response) {
          file.previewElement.classList.add("dz-error");
      },
      init: function() {
        this.on('completemultiple', function(file, json) {
         $('.sortable').sortable('enable');
        });
        this.on('success', function(file, json) {
          alert('aa');
        });

        this.on('addedfile', function(file) {

        });

        this.on('drop', function(file) {
          console.log('File',file)
        });
      }
    });*/

    properties_edit.init_cep();
  };

  properties_edit.init();

}); //$function
