<?php header('Content-type: application/javascript'); ?>
var app = app || {};
var mustache_templates = {};

(function (window, document, $, undefined) {
	'use strict';

	app = {
		body: $("body"),

		base_url: function($uri){
			var $base_url = '<?php echo base_url(); ?>';

			if(typeof $uri != 'undefined'){
				$base_url += $uri;
			}

			return $base_url;
		},

		get_asset_url: function($path) {
			var response = '<?php echo get_asset('%PATH%'); ?>';
			return (response.replace('%PATH%', $path));
		},

		get_asset_path: function($path) {
			var response = '<?php echo get_asset('%PATH%', 'path'); ?>';
			return (response.replace('%PATH%', $path));
		},

    mustache: function(check_template, callback){
      if(typeof mustache_templates[check_template] != 'undefined'){
        return callback(mustache_templates[check_template]);
      }else{
        $.get(app.get_asset_url('templates/'+ check_template +'.mustache'), function(template) {
          mustache_templates[check_template] = template;
          return callback(template);
        });
      }
    },

		slug: function(str) {
			str = str.replace(/^\s+|\s+$/g, ''); // trim
			str = str.toLowerCase();

			// remove accents, swap ñ for n, etc
			var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
			var to   = "aaaaeeeeiiiioooouuuunc------";
			for (var i=0, l=from.length ; i<l ; i++) {
			str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
			}

			str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
			.replace(/\s+/g, '-') // collapse whitespace and replace by -
			.replace(/-+/g, '-'); // collapse dashes

			return str;
		}
	};
}(this, document, jQuery));
