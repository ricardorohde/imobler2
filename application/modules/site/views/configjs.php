<?php header('Content-type: application/javascript'); ?>
var app = app || {};

var usuario_logado = <?php echo $this->session->userdata('usuario_logado') ? "JSON.parse('" . json_encode($this->session->userdata("usuario_logado")) . "')" : 'false'; ?>;

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
			var response = '<?php echo get_asset(null); ?>';
			return response + '/' + (typeof $path !== 'undefined' ? $path : '');
		},

		get_asset_path: function($path) {
			var response = '<?php echo get_asset(null, 'path'); ?>';
			return response + '/' + (typeof $path !== 'undefined' ? $path : '');
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