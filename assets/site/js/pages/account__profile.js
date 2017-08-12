var account_profile = app['account_profile'] = {};
var search_process = false;

(function (window, document, $, undefined) {
  'use strict';

  account_profile.init = function() {
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

  account_profile.init();

}(this, document, jQuery));
