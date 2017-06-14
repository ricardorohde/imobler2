var home = app['home'] = {};

(function (window, document, $, undefined) {
  'use strict';

  home.init = function() {
    $('.selectpicker').selectpicker();
  };

  home.init();

}(this, document, jQuery));
