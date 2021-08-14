(function ($) {
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/contenidos-destacados.default', function($widget) {

			CDAdvancedTabs = function( $scope )
			{
				this.elem  = $scope;
				this.elemClass  = $scope.find('.pp-advanced-tabs');
				this.tabs  = $scope.find('.pp-tabs-labels .pp-advanced-tabs-title');
				this.tabsResponsive  = $scope.find('.pp-tabs-panels .pp-advanced-tabs-title');
				this._init();
			};

			CDAdvancedTabs.prototype = PPAdvancedTabs.prototype;

			CDAdvancedTabs.prototype._labelClick = function(e)
			{
				var label       = $(e.target).closest('.pp-tabs-label'),
					is_current  = label.hasClass('pp-tab-active'),
					index       = label.data('index'),
					wrap        = label.closest('.pp-advanced-tabs'),
					scroll_top  = wrap.data('scroll-top'),
					tabs_wrap   = label.closest('.pp-advanced-tabs-wrapper');

				// Toggle the responsive icons.
				//allIcons.addClass('fa-plus');
				//icon.removeClass('fa-plus');

				if ( tabs_wrap.hasClass('at-vertical') ) {
					if ( scroll_top === 'yes' ) {
						$('html, body').animate({
							scrollTop: wrap.offset().top
						}, 500 );
					}
				}

				// Toggle the tabs.
				wrap.find('.pp-tabs-labels:first > .pp-tab-active').removeClass('pp-tab-active');
				wrap.find('.pp-tabs-panels:first > .pp-tabs-panel > .pp-tab-active').removeClass('pp-tab-active');
				wrap.find('.pp-tabs-panels:first > .pp-tabs-panel > .pp-tabs-label').removeClass('pp-tab-active');

				if( ! is_current ) {

					wrap.find('.pp-tabs-labels:first > .pp-tabs-label[data-index="' + index + '"]').addClass('pp-tab-active');
					wrap.find('.pp-tabs-panels:first > .pp-tabs-panel > #pp-advanced-tabs-content-' + index ).addClass('pp-tab-active');
					wrap.find('.pp-tabs-panels:first > .pp-tabs-panel > .pp-tabs-label[data-index="' + index + '"]').addClass('pp-tab-active');

					$(document).trigger('ppe-tabs-switched', [ wrap.find( '#pp-advanced-tabs-content-' + index ) ]);
				} else {
					wrap.find( '#pp-advanced-tabs-content-' + index ).hide();
				}
			}

			new CDAdvancedTabs($widget);
		});
	});

}(jQuery));