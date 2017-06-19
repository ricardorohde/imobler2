var account = app['account'] = {};
var property_like_post = null;

(function (window, document, $, undefined) {
  'use strict';

  var property_like = function($params) {
    $.ajax({
      url: app.base_url('api/property-like'),
      data: $params,
      method: 'post',
      dataType: "json"
    }).done(function(response) {
      $('.btn-like[data-property_id='+ response.property_id +']').attr('data-like_status', response.status);
      $('.link-like[data-property_id='+ response.property_id +']').attr('data-like_status', response.status);
      return true;
    });
  };

  $('#pop-login-form').ajaxForm({
    dataType: 'json',
    success: function(response){
      if(response.error){
        $('.tab-pane-login').find('.message-text').removeClass('text-success').addClass('text-danger').html('<i class="fa fa-close"></i> ' + response.error);
      }else{
        usuario_logado = response;
        $('.tab-pane-login').find('.message-text').removeClass('text-danger').addClass('text-success').html('<i class="fa fa-check"></i> ' + response.success);

        property_like(property_like_post); property_like_post = null;

        $.get(app.get_asset_url('templates/header__account.mustache'), function(template) {
          response['site_base_url'] = app.base_url();
          var rendered = Mustache.render(template, response);
          $('#header-account').html(rendered);
          $('#header-account-mobile').html(rendered);

          $('#pop-login').modal('toggle');
        });
      }
    }
  });



  app.body.on('click', '.btn-like, .link-like', function(){
    var $this = $(this);

    property_like_post = {
      'property_id' : $this.attr('data-property_id'),
      'status' : $this.attr('data-like_status')
    };

    if(usuario_logado){
      property_like(property_like_post);
    }else{
      $('#pop-login').modal('toggle');
      return false;
    }
  });


}(this, document, jQuery));






// var account = app['account'] = {};

// $(function(){
//   var modal_login = $('#pop-login');

//   account.login = {
//     toggle: function(){
//       modal_login.modal('toggle');
//     },

//     header: function(response){
//       console.log(response);
//       $.ajax({
//         url: app.base_url('api/mustache/header-account.mustache'),
//         data: response,
//         method: 'post',
//         dataType: "html"
//       }).done(function(html) {
//         // Seta variavel com ID logado
//         account_user_logged = response.id;

//         // Se existir like em andamento
//         if(properties_like_property_id){
//           app.properties.like(properties_like_property_id, 'like');
//         }

//         //Atualiza Header
//         $('#header-account').html(html);

//         //Fecha login
//         app.account.login.toggle();
//       });
//     }
//   };

//   account.facebook = {
//     status: function(response){
//       if (response.status === 'connected') {
//         FB.api('/me?fields=first_name,last_name,gender,email,picture', function(response) {
//           $.ajax({
//             url: app.base_url('api/login_facebook'),
//             data: response,
//             method: 'post',
//             dataType: "json"
//           }).done(function(result) {
//             account.login.header(result);
//           });
//         });
//       }else if (response.status === 'not_authorized') {
//         console.log('Não autorizado');
//       }else{
//         console.log(response);
//       }
//     },

//     login: function(){
//       FB.login(function(response) {
//         if (response.authResponse) {
//           app.account.facebook.status(response);
//         }else{
//           console.log('User cancelled login or did not fully authorize.');
//         }
//       }, {
//         scope: 'public_profile,email'
//       });
//     },

//     check: function(){
//       FB.getLoginStatus(function(response) {
//         app.account.facebook.status(response);
//       });
//     }
//   }

//   modal_login.on('hide.bs.modal', function (e) {
//     if(properties_like_property_id){
//       properties_like_property_id = 0;
//     }
//   });

//   // user: {
//   //   'is_logged': function(){
//   //     if(user_is_logged){
//   //       return true;
//   //     }else{
//   //       $.ajax({
//   //         url: app.base_url('api/is_logged'),
//   //         dataType: "json"
//   //       }).done(function(result) {
//   //         user_is_logged = true;
//   //         $("#pop-login").modal();
//   //       });
//   //     }
//   //   }
//   // }

//   $('#login-form').submit(function() {
//     $(this).ajaxSubmit({
//       success: function(responseText){
//         if(responseText == 'false'){
//           $('#login-message').empty().removeClass('').addClass('error text-danger').html('<i class="fa fa-close"></i> E-mail e/ou Senha inválidos').show();
//         }else{
//           $('#login-message').empty().removeClass('').addClass('success text-success').html('<i class="fa fa-check"></i> Você está logado no sistema').show();
//           account.login.header(jQuery.parseJSON(responseText));
//         }
//       }
//     });
//     return false;
//   });

//   $('.btn-facebook-login').on('click', function(){
//     app.account.facebook.login();
//   });
// });
