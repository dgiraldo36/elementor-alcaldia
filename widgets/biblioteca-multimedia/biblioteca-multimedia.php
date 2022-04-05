	<?php

	use Widgets_Alcaldia\Modulos\Eventos_Convocatorias\Temas;

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

	class Widget_Alcaldia_Biblioteca_Multimedia extends Posts_Base {
		public function get_name() {
			return 'biblioteca-multimedia';
		}

		public function get_title() {
			return 'Biblioteca Multimedia';
		}

		public function get_icon() {
			return [ 'eicon-video-playlist' ];
		}

		public function get_categories() {
			return [ 'variables-alcaldia' ];
		}

		public function get_keywords() {
			return ['Biblioteca', 'Multimedia', 'Fotos', 'Imágenes', 'Videos', 'Audios'];
		}

		/**
		 * Register widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function _register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
			$this->register_query_section_controls( array(), 'posts', '', 'yes' );

			$this->update_control(
				'query_type',
				[
					'type'    => Controls_Manager::HIDDEN,
					'default' => 'custom'
				]
			);

			$this->update_control(
				'post_type',
				[
					'type'    => Controls_Manager::HIDDEN,
					'default' => 'videos'
				]
			);
		}

		protected function render() {
			$settings = $this->get_settings();
			$posts_count = 4;
			$this->query_posts( '', '', '', '', '', 'posts', '', '', $posts_count );
			$loop = $this->get_query();
			// Link hacia ver más vídeos
			$tabmulti_linkmasvideos = '#';

			?>
			<div class="centradototal_">
		    <div class="tabs_multimedias">
	        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
	            <li class="nav-item" role="presentation">
	                <a class="titulo_tabs active" id="pills-videos-tab" data-toggle="pill" href="#pills-videos" role="tab" aria-controls="pills-videos" aria-selected="true"><b>Vídeos</b></a>
	            </li>
	            <li class="nav-item" role="presentation">
	                <a class="titulo_tabs" id="pills-imagenes-tab" data-toggle="pill" href="#pills-imagenes" role="tab" aria-controls="pills-imagenes" aria-selected="false"><b>Imágenes</b></a>
	            </li>
	            <li class="nav-item" role="presentation">
	                <a class="titulo_tabs" id="pills-audios-tab" data-toggle="pill" href="#pills-audios" role="tab" aria-controls="pills-audios" aria-selected="false"><b>Audios</b></a>
	            </li>
	        </ul>
	        <div class="tab-content" id="pills-tabContent">
	            <div class="tab-pane fade show active" id="pills-videos" role="tabpanel" aria-labelledby="pills-videos-tab">
	            <!-- Tab videos  -->
	               <div class="loadmore_contenido_ salaprensa">
	                <div class="list_articulos">
	                    <div class="listado_loadmore">
	                    <?php
	                        if ($loop->have_posts()) :
	                            while ($loop->have_posts()) : $loop->the_post()
	                        ?>
	                        <div class="grid">
	                            <div class="reset_formato_video">
	                            <a href="<?php the_permalink(); ?>">
	                                <iframe width="100%" height="150" src="https://www.youtube.com/embed/<?php the_field('id_video'); ?>" title="<?php the_title(); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	                                <!-- <img src="https://img.youtube.com/vi/<?php the_field('id_video'); ?>/0.jpg" alt="<?php the_title(); ?>"> -->
	                                <div class="play_"><ion-icon name="caret-forward-outline"></ion-icon></div>
	                            </a>
	                            </div>
	                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	                        </div>
	                        <?php endwhile ?>
	                    <!-- <span class="link_vermascontent_tabs"><a href="<?php echo $tabmulti_linkmasvideos;?>"> Ver más vídeos</a></span> -->
	                <!-- Modulo más leidas -->
	                    <?php else :?>
	                    	<div class="paginador__glo">
	                        <?php _e('No hay contenido', ''); ?>
	                        </div>
	                    <?php endif; wp_reset_postdata();?>
	                    </div>
	                </div>
	              </div>
	            </div>
	            <div class="tab-pane fade" id="pills-imagenes" role="tabpanel" aria-labelledby="pills-imagenes-tab">
								<!-- Histórico de audios -->
							  <div class="loadmore_contenido_ salaprensa">
								  <div class="list_articulos">
								    <div class="listado_loadmore">
								      <?php
							      	add_filter('ppe_posts_query_args', [ $this, 'imagenes_query_args'], 10 , 2 );
							      	$this->query_posts( '', '', '', '', '', 'posts', '', '', $posts_count );
											$loop = $this->get_query();
											remove_filter('ppe_posts_query_args', [ $this, 'imagenes_query_args']);
							      	if ($loop->have_posts()) :
							      		while ($loop->have_posts()) : $loop->the_post()
							      	?>
							      	<div class="grid">
								        <a href="<?php the_permalink(); ?>">
								      		<div class="grid_galeria_mad">
									        	<img src="<?php the_post_thumbnail_url();?>" alt="" class="img__img">
									        	<div class="img__description_layer">
									          	<div class="listadogaleri_vim">
									            	<h2 class="img__description"><?php the_title(); ?></h2>
									            	<?php
												          $tag_list = get_the_tag_list( '<ul><li><ion-icon name="radio-button-on-outline"></ion-icon>', '</li><li><ion-icon name="radio-button-on-outline"></ion-icon>', '</li></ul>' );
											          	if ($tag_list) :
											          ?>
									            	<span class="pertenece_a">Galería asociado a</span>
									            		<?php echo $tag_list; ?>
									            	<?php endif; ?>
									          	</div>
									        	</div>
									      	</div>
									    	</a>
								    	</div>
								    	<?php endwhile ?>
										  <!-- Modulo más leidas -->
										  <?php else :?>
									  	<div class="paginador__glo">
										    <p>No hay contenido de imágenes para este módulo...</p>
									    </div>
										  <?php endif; wp_reset_postdata();?>
							  		</div>
									</div>
								</div>
	            </div>
	            <div class="tab-pane fade" id="pills-audios" role="tabpanel" aria-labelledby="pills-audios-tab">
	              <div class="loadmore_contenido_ salaprensa">
								  <div class="list_articulos">
								    <div class="listado_loadmore">
								      <?php
								      	$paged = get_query_var('paged') ? get_query_var('paged') : 1;
								      	$args = array(
								      		'post_type' => 'audios',
								      		'post_status' => 'publish',
								      		'posts_per_page' => 8,
								      		'paged' => $paged,
								      	);
								      	$arr_posts = new WP_Query( $args );
								      	if ($arr_posts->have_posts()) :
								      		while ($arr_posts->have_posts()) : $arr_posts->the_post()
								      	?>
								      <div class="grid audioslist_">
								        <h2><ion-icon name="musical-note-outline"></ion-icon><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								        <div class="audiogrid_">
								          <?php
								          $attr = array(
								          	'src'      => get_field('audio'),
								          	'loop'     => '',
								          	'autoplay' => '',
								          	'preload' => 'none'
								          	);
								          echo wp_audio_shortcode( $attr );
								          ?>
								        </div>
								        <?php
								          $tag_list = get_the_tag_list( '<ul><li><ion-icon name="radio-button-on-outline"></ion-icon>', '</li><li><ion-icon name="radio-button-on-outline"></ion-icon>', '</li></ul>' );
							          	if ($tag_list) :
							          ?>
									        <span class="pertenece_a">Contenido asociado a</span>
									        <div class="listado_vim">
									        	<?php echo $tag_list; ?>
									        </div>
									      <?php endif; ?>
								      </div>
								    		<?php endwhile ?>
										  <!-- Modulo más leidas -->
											  <?php else :?>
										  	<div class="paginador__glo">
										    	<p>No hay contenido de audios para este módulo...</p>
										    </div>
										  	<?php endif; wp_reset_postdata();?>
								  	</div>
									</div>
								</div>
	            </div>
	        </div>
		    </div>
			</div>
	    <?php
		}

		public function __construct($data = [], $args = null) {
			parent::__construct($data, $args);
			wp_register_style( 'biblioteca-multimedia-css', ELEMENTOR_ALCALDIA_URL . 'assets/css/biblioteca-multimedia.css');
		}

		public function get_style_depends() {
			return [ 'biblioteca-multimedia-css' ];
		}

		public function imagenes_query_args($query_args, $settings) {
			$query_args['post_type'] = 'imagenes';
			return $query_args;
		}

	}