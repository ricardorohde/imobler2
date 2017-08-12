var properties_add = app['properties_add'] = {};

$(function(){

  properties_add.init_cep = function($templates, $callback){

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

            $('#logradouro').focus();

            $('#logradouro').val('');
            $('#bairro').val('');
            $('#cidade').val('');
            $('#estado').selectpicker('val', '');
          }else{
            $('#numero').focus();
            $('#logradouro').val(response.logradouro);
            $('#bairro').val(response.bairro);
            $('#cidade').val(response.localidade);
            $('#estado').selectpicker('val', response.uf);

          }
        });
      }
    };

    $('.cep-mask').mask('00000-000', options);
  };

  // Init
  properties_add.init = function(){
    $('.price-mask').mask('000.000.000.000.000,00', {reverse: true});
    $('.area-mask').mask('000.000.000.000.000', {reverse: true});

    var SPMaskBehavior = function (val) {
      return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
      onKeyPress: function(val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };

    $('.phone-mask').mask(SPMaskBehavior, spOptions);

    $('textarea[maxlength]').maxlength({
      alwaysShow: true,
      threshold: 10,
      warningClass: "label label-info",
      limitReachedClass: "label label-danger"
    });

    properties_add.init_cep();
  };

  properties_add.init();

}); //$function
