<?php

use PowerpackElements\Base\Powerpack_Widget;
use PowerpackElements\Modules\Posts\Widgets\Posts_Base;
use PowerpackElements\Classes\PP_Config;
use PowerpackElements\Classes\PP_Posts_Helper;

use PowerpackElements\Modules\Posts\Skins;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Modules\DynamicTags\Module as TagsModule;

class Widget_Alcaldia_Eventos_Convocatorias extends Posts_Base {
	public function get_name() {
		return 'eventos-convocatorias';
	}

	public function get_title() {
		return 'Eventos y Convocatorias';
	}

	public function get_icon() {
		return [ 'eicon-calendar' ];
	}

	public function get_categories() {
		return [ 'variables-alcaldia' ];
	}

	public function get_keywords() {
		return ['Eventos', 'Convocatorias'];
	}

	/**
	 * Register card slider widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function _register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->register_controls();
	}

	/**
	 * Register card slider widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.0.3
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_skin_field',
			array(
				'label' => 'Diseño',
			)
		);

		$this->add_control(
			'title_html_tag',
			array(
				'label'     => 'Etiqueta HTML Título',
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h2',
				'options'   => array(
					'h1'   => __( 'H1', 'powerpack' ),
					'h2'   => __( 'H2', 'powerpack' ),
					'h3'   => __( 'H3', 'powerpack' ),
					'h4'   => __( 'H4', 'powerpack' ),
					'h5'   => __( 'H5', 'powerpack' ),
					'h6'   => __( 'H6', 'powerpack' ),
					'div'  => __( 'div', 'powerpack' ),
					'span' => __( 'span', 'powerpack' ),
					'p'    => __( 'p', 'powerpack' ),
				),
				'separator' => 'before',
			)
		);

		$this->end_controls_section();
		/* Content Tab */
		$this->register_query_section_controls( array(), 'posts', '', 'yes' );

		$this->update_control(
			'nothing_found_message',
			array(
				'label'   => 'Mensaje "Sin Resultados"',
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => 'Muy pronto encontrará eventos de su interés en esta sección.', 'powerpack'
			)
		);
	}

	protected function render() {
		$settings = $this->get_settings();
		$posts_count = 4;
		$this->query_posts( '', '', '', '', '', 'posts', '', '', $posts_count );
		$loop = $this->get_query();
		$tipo_despliegue = 'principal';
		if ( $loop->post_count < 4 && $loop->post_count > 1 ) {
			$tipo_despliegue = 'simple';
		} 
		?>
		<!-- <div class="mod_conspasing"> -->
			<div class="eventos_grid_proximos">
				<div class="centradototal_">
			    <div class="grid_ <?php echo 'despliegue_' . $tipo_despliegue; ?>">
		        <?php if ( $loop->have_posts() ) : ?>
			      <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			      <div class="grid">
			        <div class="fotofechita_eventos_">
			          <a href="<?php the_permalink(); ?>">
			          	<?php
			              if (has_post_thumbnail() ) {
			                the_post_thumbnail('medium');
			              }
			              else {
			                  echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) 
			                      . '/img/eventos-estandar.jpeg" />';
			              }
			            ?>
			          </a>
			          <span class="fechaflota_">
			            <li><?php $this->imprimirFechaEvento(); ?></li>
			          </span>
			        </div>
			        <h3 class="titul_mod_evt"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			        <div class="listado_vim">
			          <?php
			          $tag_list = get_the_tag_list( '<ul><li><ion-icon name="radio-button-on-outline"></ion-icon>', '</li><li><ion-icon name="radio-button-on-outline"></ion-icon>', '</li></ul>' );
			          echo $tag_list;
			          ?>
			        </div>
			        <div class="dato_evento_modulo">
			            <span>Inicia: <?php the_field('inicio_del_evento'); ?> - Finaliza: <?php the_field('fin_del_evento'); ?></span>
			      </div>
			        <p>
			          <?php
			          	if ( function_exists('limitar_caracteres') ) {
			            	echo limitar_caracteres(get_the_excerpt(), 110);
			            } else {
				            echo substr( get_the_excerpt(), 0, 110);
				        }
			          ?>
			        </p>
			        <a href="<?php the_permalink(); ?>" class="botoneventos_grid">Conozca más</a>
			      </div>
			      <?php endwhile; ?>
			    <?php else : ?>
			    	<?php _e($settings['nothing_found_message']); ?>
			    <?php endif; ?>
			    </div>
			  </div>
			</div>
		<!-- </div> -->
    <?php
	}
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_register_style( 'eventos-convocatorias-css', ELEMENTOR_ALCALDIA_URL . 'assets/css/eventos-convocatorias.css');
	}

	private function imprimirFechaEvento() {
		// setlocale(LC_TIME, 'es_ES');
		$fechaInicio = get_field('inicio_del_evento', false, false);
	    $fechaFin    = get_field('fin_del_evento', false, false);
	    $horaInicio  = get_field('hora_inicio', false, false);
	    $horaFin     = get_field('hora_fin', false, false);

	    $timeFechaInicio = strtotime($fechaInicio);
	    $timeFechaFin = strtotime($fechaFin);

	    if( strpos($horaInicio, '00:00') !== false ) {
	    	$horaInicio = '';
	    }

	    // $date = DateTime::createFromFormat( 'Y-m-d', $fechaInicio);

	    // update_field('inicio_del_evento', $date->format('Ymd'));

	    $horaInicio = str_replace('am', 'a. m.', $horaInicio);
	    $horaInicio = str_replace('pm', 'p. m.', $horaInicio);

	    printf(
	    	"%s %s",
	    	ucfirst( $this->reemplazar_mes(strftime( '%B %e, %Y', $timeFechaInicio ) ) ),
	    	$horaInicio
	    );
	    // restore_previous_locale();
	}

	private function reemplazar_mes( $fecha ) {
		$meses = array('january' => 'enero', 'february' => 'febrero', 'march' => 'marzo', 'april' => 'abril', 'may' => 'mayo', 'june' => 'junio', 'july' => 'julio', 'august' => 'agosto', 'september' => 'septiembre', 'october' => 'octubre', 'november' => 'noviembre', 'december' => 'diciembre');
		$arreglo_fecha = explode(' ', $fecha);

		$arreglo_fecha[0] = strtolower($arreglo_fecha[0]);

		if ( array_key_exists($arreglo_fecha[0], $meses) ) {
			$arreglo_fecha[0] = $meses[$arreglo_fecha[0]];
		}

		return implode(' ', $arreglo_fecha);
	}

	public function get_style_depends() {
		return [ 'eventos-convocatorias-css' ];
	}

	/**
	 * Get post query arguments.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	public function query_posts_args( $filter = '', $taxonomy_filter = '', $search = '', $all_posts = '', $paged_args = '', $widget_type = 'posts', $old_code = '', $posts_count_var = '', $posts_count = '' ) {
		$settings  = $this->get_settings_for_display();
		$paged     = ( 'yes' === $paged_args ) ? $this->get_paged() : '';
		$tax_count = 0;

		if ( 'main' === $settings['query_type'] ) {
			$current_query_vars = $GLOBALS['wp_query']->query_vars;
			return apply_filters( "ppe_{$widget_type}_query_args", $current_query_vars, $settings );
		}

		$query_args = array(
			'post_status'         => array( 'publish' ),
			'orderby'             => $settings['orderby'],
			'order'               => 'DESC',
			'ignore_sticky_posts' => ( 'yes' === $settings['sticky_posts'] ) ? 0 : 1,
			'posts_per_page'      => -1,
		);

		if ( ! $posts_count ) {
			$posts_per_page = ( $posts_count_var ) ? $settings[ $posts_count_var ] : ( isset( $settings['posts_per_page'] ) ? $settings['posts_per_page'] : '' );
		} else {
			$posts_per_page = $posts_count;
		}

		if ( '' === $all_posts ) {
			$query_args['posts_per_page'] = $posts_per_page;
		}


		// Query Arguments.
		$query_args['post_type'] = $settings['post_type'];
		if ( 0 < $settings['offset'] ) {

			/**
			 * Offset break the pagination. Using WordPress's work around
			 *
			 * @see https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
			 */
			$query_args['offset_to_fix'] = $settings['offset'];
		}
		$query_args['paged'] = $paged;

		// Author Filter.
		if ( ! empty( $settings['authors'] ) ) {
			$query_args[ $settings['author_filter_type'] ] = $settings['authors'];
		}

		// Posts Filter.
		$post_type = $settings['post_type'];

		if ( ! empty( $settings[ $post_type . '_filter' ] ) ) {
			$query_args[ $settings[ $post_type . '_filter_type' ] ] = $settings[ $post_type . '_filter' ];
		}

		// Taxonomy Filter.
		$taxonomy = PP_Posts_Helper::get_post_taxonomies( $post_type );

		$tax_cat_in     = '';
		$tax_cat_not_in = '';
		$tax_tag_in     = '';
		$tax_tag_not_in = '';

		if ( ! empty( $taxonomy ) && ! is_wp_error( $taxonomy ) ) {

			foreach ( $taxonomy as $index => $tax ) {

				$tax_control_key = $index . '_' . $post_type;

				if ( 'yes' === $old_code ) {
					if ( 'post' === $post_type ) {
						if ( 'post_tag' === $index ) {
							$tax_control_key = 'tags';
						} elseif ( 'category' === $index ) {
							$tax_control_key = 'categories';
						}
					}
				}

				if ( ! empty( $settings[ $tax_control_key ] ) ) {

					$operator = $settings[ $index . '_' . $post_type . '_filter_type' ];

					$query_args['tax_query'][] = array(
						'taxonomy' => $index,
						'field'    => 'term_id',
						'terms'    => $settings[ $tax_control_key ],
						'operator' => $operator,
					);

					switch ( $index ) {
						case 'category':
							if ( 'IN' === $operator ) {
								$tax_cat_in = $settings[ $tax_control_key ];
							} elseif ( 'NOT IN' === $operator ) {
								$tax_cat_not_in = $settings[ $tax_control_key ];
							}
							break;

						case 'post_tag':
							if ( 'IN' === $operator ) {
								$tax_tag_in = $settings[ $tax_control_key ];
							} elseif ( 'NOT IN' === $operator ) {
								$tax_tag_not_in = $settings[ $tax_control_key ];
							}
							break;
					}
				}
			}
		}

		if ( '' !== $filter && '*' !== $filter ) {
			// Taxonomy Filter.
			$taxonomy = PP_Posts_Helper::get_post_taxonomies( $post_type );

			$tax_cat_in     = '';
			$tax_cat_not_in = '';
			$tax_tag_in     = '';
			$tax_tag_not_in = '';

			if ( ! empty( $taxonomy ) && ! is_wp_error( $taxonomy ) ) {

				foreach ( $taxonomy as $index => $tax ) {

					$tax_control_key = $index . '_' . $post_type;

					if ( 'yes' === $old_code ) {
						if ( 'post' === $post_type ) {
							if ( 'post_tag' === $index ) {
								$tax_control_key = 'tags';
							} elseif ( 'category' === $index ) {
								$tax_control_key = 'categories';
							}
						}
					}

					if ( ! empty( $settings[ $tax_control_key ] ) ) {

						$operator = $settings[ $index . '_' . $post_type . '_filter_type' ];

						$query_args['tax_query'][] = array(
							'taxonomy' => $index,
							'field'    => 'term_id',
							'terms'    => $settings[ $tax_control_key ],
							'operator' => $operator,
						);

						switch ( $index ) {
							case 'category':
								if ( 'IN' === $operator ) {
									$tax_cat_in = $settings[ $tax_control_key ];
								} elseif ( 'NOT IN' === $operator ) {
									$tax_cat_not_in = $settings[ $tax_control_key ];
								}
								break;

							case 'post_tag':
								if ( 'IN' === $operator ) {
									$tax_tag_in = $settings[ $tax_control_key ];
								} elseif ( 'NOT IN' === $operator ) {
									$tax_tag_not_in = $settings[ $tax_control_key ];
								}
								break;
						}
					}
				}
			}

			$query_args['tax_query'][ $tax_count ]['taxonomy'] = $taxonomy_filter;
			$query_args['tax_query'][ $tax_count ]['field']    = 'slug';
			$query_args['tax_query'][ $tax_count ]['terms']    = $filter;
			$query_args['tax_query'][ $tax_count ]['operator'] = 'IN';
		}

		if ( '' !== $search ) {
			$query_args['s'] = $search;
		}

		// Sticky Posts Filter.
		if ( 'yes' === $settings['sticky_posts'] && 'yes' === $settings['all_sticky_posts'] ) {
			$post__in = get_option( 'sticky_posts' );

			$query_args['ignore_sticky_posts'] = 1;
			$query_args['post__in'] = $post__in;
		}

		// Exclude current post.
		if ( 'yes' === $settings['exclude_current'] ) {
			$query_args['post__not_in'] = array( get_the_ID() );
		}

		$date = new DateTime();
		$date->add(DateInterval::createFromDateString('yesterday'));

		$query_args['meta_key'] = 'inicio_del_evento';

		$query_args['meta_query'] = array(
			array(
				'key' 	  => 'fin_del_evento',
				'value'   => $date->format('Ymd'),
				'compare' => '>=',
			),
			array(
				'key'     => 'inicio_del_evento',
				'compare' => 'EXISTS',
			),
		);

		$query_args['orderby'] = 'meta_value';
		$query_args['order'] = 'DESC';

		return apply_filters( "ppe_{$widget_type}_query_args", $query_args, $settings );
	}

}