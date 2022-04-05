(function ($) {
	$(document).ready( function () {
		agregar_hooks_select_siata();
	});

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/siata.default', function($widget) {
			agregar_hooks_select_siata();
		})
	});

	const agregar_hooks_select_siata = function() {
		$('.estado_tiempo_ .select_formulario select').on('change', function() {
			option_elemento = $(this).find('option:selected');
			estado = option_elemento.attr('data-estado');

			texto_contenedor = $('.situ_t');
			texto_elemento = texto_contenedor.find('.siata_estado_texto');
			estado_actual  = texto_contenedor.attr('data-estado');

			texto_contenedor.removeClass('siata_estado_' + estado_actual);
			texto_elemento.html((estado.charAt(0).toUpperCase() + estado.slice(1)).replace('_', ' '));
			texto_contenedor.addClass('siata_estado_' + estado);
			texto_contenedor.attr('data-estado', estado);
		});
	}

}(jQuery));