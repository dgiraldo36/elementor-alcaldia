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
					tabs_wrap   = label.closest('.pp-advanced-tabs-wrapper'),
					content_wrap = wrap.find('.cd-tabs-content-wrapper-' + label.data('wrapper'));

					// console.log(label.data('wrapper'),content_wrap);

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
				wrap.find('.pp-tab-active').removeClass('pp-tab-active');
				// wrap.find('.pp-tabs-panels > .pp-tabs-panel > .pp-tab-active').removeClass('pp-tab-active');
				wrap.find('.pp-tabs-label').removeClass('pp-tab-active');

				if( ! is_current ) {

					tabs_wrap.find('.pp-tabs-label[data-index="' + index + '"]').addClass('pp-tab-active');
					content_wrap.find('#pp-advanced-tabs-content-' + index ).addClass('pp-tab-active');
					content_wrap.find('.pp-tabs-label[data-index="' + index + '"]').addClass('pp-tab-active');

					$(document).trigger('ppe-tabs-switched', [ wrap.find( '#pp-advanced-tabs-content-' + index ) ]);
				} else {
					wrap.find( '#pp-advanced-tabs-content-' + index ).hide();
				}
			}

			CDAdvancedTabs.prototype._responsiveLabelClick = function(e)
			{
				var label           = $(e.target).closest('.pp-tabs-label'),
					is_current      = label.hasClass('pp-tab-active'),
					wrap            = label.closest('.pp-advanced-tabs'),
					index           = label.data('index'),
					content         = label.siblings('.pp-advanced-tabs-content'),
					activeContent   = wrap.find('.pp-advanced-tabs-content.pp-tab-active'),
					activeIndex     = activeContent.data('index');


				// Should we proceed?
				if (is_current) {
					activeContent.slideUp('normal');
					activeContent.removeClass('pp-tab-active');
					this.elemClass.find('.pp-tabs-panels .pp-tabs-label').removeClass('pp-tab-active');
					//$(this.elemClass + ' .pp-tabs-panels .pp-tabs-label').removeClass('pp-tab-active');
					wrap.removeClass('pp-tabs-animation');
					return;
				}
				if (wrap.hasClass('pp-tabs-animation')) {
					return;
				}

				// Toggle the icons.
				//allIcons.addClass('fa-plus');
				//icon.removeClass('fa-plus');

				// Run the animations.
				wrap.addClass('pp-tabs-animation');
				activeContent.slideUp('normal');


				if (is_current) {
					return;
				}

				content.slideDown('normal', function(){

					wrap.find('.pp-tab-active').removeClass('pp-tab-active');
					wrap.find('.pp-tabs-label[data-index="' + index + '"]').addClass('pp-tab-active');
					content.addClass('pp-tab-active');
					wrap.removeClass('pp-tabs-animation');

					// Content Grid module support.
					if ( 'undefined' !== typeof $.fn.isotope ) {
						content.find('.pp-content-post-grid').isotope('layout');
					}

					if(label.offset().top < $(window).scrollTop() + 100) {
						$('html, body').animate({ scrollTop: label.offset().top - 100 }, 500, 'swing');
					}

					$(document).trigger('ppe-tabs-switched', [ content ]);
				});
			}

			new CDAdvancedTabs($widget);
		});
	});

}(jQuery));