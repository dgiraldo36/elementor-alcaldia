<?php

use PowerpackElements\Modules\AdvancedTabs\Widgets\Advanced_Tabs;
use PowerpackElements\Classes\PP_Helper;

// Elementor Classes
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Widget_Alcaldia_Contenidos_Destacados extends Advanced_Tabs {
	public function get_name() {
		return 'contenidos-destacados';
	}

	public function get_title() {
		return 'Contenidos Destacados';
	}

	public function get_icon() {
		return [ 'ppicon-tabs' ];
	}

	public function get_categories() {
		return [ 'variables-alcaldia' ];
	}

	public function get_keywords() {
		return ['Contenidos', 'Destacados'];
	}

	protected function register_controls() {
		$this->registrar_controles_contenidos_destacados();
		$this->register_style_title_controls();
		$this->register_style_content_controls();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	CONTENT TAB
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Register accordion content controls
	 *
	 * @return void
	 */
	protected function registrar_controles_contenidos_destacados() {

		$this->start_controls_section(
			'seccion_tabs_contenidos_destacados',
			[
				'label'                 => esc_html( 'Contenidos Destacados' ),
			]
		);

		$this->add_control(
			'type',
			[
				'type'                  => Controls_Manager::HIDDEN,
				'default'               => 'at-horizontal'
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_at' );

		$repeater->start_controls_tab(
			'tab_titulos',
			array(
				'label' => 'Títulos',
			)
		);

		$repeater->add_control(
			'tab_title',
			[
				'label'                 => 'Título de tipología',
				'type'                  => Controls_Manager::TEXT,
				'label_block'           => true,
				'default'               => 'Contenido Destacado',
				'dynamic'               => [
					'active'   => true,
				],
				'placeholder' => 'Título',
				'default'     => 'Título',
			]
		);

		$repeater->add_control(
			'titulo_contenido_destacado_1',
			[
				'label'                 => 'Título Línea 1',
				'type'                  => Controls_Manager::TEXT,
				'label_block'           => true,
				'default'               => 'Contenido',
				'dynamic'               => [
					'active'   => true,
				],
			]
		);

		$repeater->add_control(
			'titulo_contenido_destacado_2',
			[
				'label'                 => 'Título Línea 2',
				'type'                  => Controls_Manager::TEXT,
				'label_block'           => true,
				'default'               => 'Destacado',
				'dynamic'               => [
					'active'   => true,
				],
			]
		);

		$repeater->add_control(
			'pp_icon_type',
			[
				'label'             => 'Tipo de Ícono',
				'type'              => Controls_Manager::CHOOSE,
				'label_block'       => false,
				'toggle'            => false,
				'default'           => 'icon',
				'options'           => [
					'none' => [
						'title' => esc_html( 'Ninguno' ),
						'icon'  => 'fa fa-ban',
					],
					'icon' => [
						'title' => esc_html( 'Ícono' ),
						'icon'  => 'fa fa-star',
					],
					'image' => [
						'title' => esc_html( 'Imagen' ),
						'icon'  => 'fa fa-picture-o',
					],
				],
			]
		);

		$repeater->add_control(
			'selected_icon',
			array(
				'label'            => 'Ícono',
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'default'          => array(
					'value'   => 'far fa-file-alt',
					'library' => 'fa-solid',
				),
				'fa4compatibility' => 'icon',
				'condition'        => [
					'pp_icon_type' => 'icon',
				],
			)
		);

		$repeater->add_control(
			'icon_img',
			[
				'label'             => 'Imagen',
				'label_block'       => true,
				'type'              => Controls_Manager::MEDIA,
				'default'           => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic'           => [
					'active'  => true,
				],
				'condition'         => [
					'pp_icon_type' => 'image',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'icon_img',
				'label'     => 'Tamaño de Imagen',
				'default'   => 'full',
				'condition' => array(
					'pp_icon_type' => 'image',
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_content',
			array(
				'label' => 'Contenido',
			)
		);

		$repeater->add_control(
			'content_type',
			[
				'type' => Controls_Manager::HIDDEN,
				'default' => 'tab_content',
			]
		);

		$repeater->add_control(
			'content',
			[
				'label'                 => 'Contenido',
				'type'                  => Controls_Manager::WYSIWYG,
				'default'               => 'Texto del Contenido Destacado. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
				'dynamic'               => [ 'active' => true ],
				'condition'             => [
					'content_type'  => 'tab_content',
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'                 => 'Elegir Imagen',
				'type'                  => Controls_Manager::MEDIA,
				'label_block'           => true,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'url_contenido_destacado',
			[
				'label'                 => 'URL botón "CONOCE MÁS"',
				'type'                  => Controls_Manager::URL,
				'label_block'           => true,
				'dynamic'               => [
					'active'   => true,
				],
				'required'    => 'yes',
				'condition'             => [
					'content_type'  => 'tab_content',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'tab_features',
			[
				'label'       => '',
				'type'        => Controls_Manager::REPEATER,
				'default'     => array(
					array(
						'tab_title' => 'Título Pestaña 1',
						'titulo_contenido_destacado_1' => 'Contenido 1',
						'titulo_contenido_destacado_2' => 'Destacado 1',
						'content'   => 'Texto del Contenido Destacado 1. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
					),
					array(
						'tab_title' => 'Título Pestaña 2',
						'content'   => 'Texto del Contenido Destacado 2. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.'
					),
					array(
						'tab_title' => 'Título Pestaña 3',
						'content'   => 'Texto del Contenido Destacado 3. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
					),
				),
				'fields'                => $repeater->get_controls(),
				'title_field'           => '{{tab_title}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'seccion_tabs_titulos',
			[
				'label'                 => esc_html( 'Etiquetas Títulos' ),
			]
		);

		$this->add_control(
			'tab_title_tag',
			array(
				'label'	  => 'Etiqueta HTML Título de tipología',
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
			)
		);

		$this->add_control(
			'tag_titulo_contenido',
			array(
				'label'                 => 'Etiqueta HTML Título',
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
			)
		);

		$this->add_control(
			'custom_style',
			[
				'type'                  => Controls_Manager::HIDDEN,
				'default'               => 'style-0'
			]
		);

		$this->add_control(
			'toggle_icon_show',
			[
				'type'                  => Controls_Manager::HIDDEN,
				'default'               => 'yes'
			]
		);

		$this->add_control(
			'toggle_icon_align',
			[
				'type'                  => Controls_Manager::HIDDEN,
				'default'               => 'right'
			]
		);

		$this->add_control(
			'toggle_icon_normal',
			[
				'type'                  => Controls_Manager::HIDDEN,
				'default'               => 'fas fa-chevron-down'
			]
		);

		$this->add_control(
			'toggle_icon_normal_color',
			[
				'type'                  => Controls_Manager::HIDDEN,
				'default'               => '#00AEEF',
				'selectors'				=> [
					'{{WRAPPER}} .pp-advanced-tabs-title.pp-tabs-label .cd-top-text .pp-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'toggle_icon_active',
			[
				'type'                  => Controls_Manager::HIDDEN,
				'default'               => 'fas fa-chevron-up'
			]
		);

		$this->add_control(
			'toggle_icon_active_color',
			[
				'type'                  => Controls_Manager::HIDDEN,
				'default'               => '#FF8403',
				'selectors'				=> [
					'{{WRAPPER}} .pp-advanced-tabs-title.pp-tab-active .cd-top-text *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'responsive_support',
			[
				'type'                  => Controls_Manager::HIDDEN,
				'default'               => 'mobile'
			]
		);

		$this->add_control(
			'scroll_top',
			[
				'type'                  => Controls_Manager::HIDDEN,
				'default'               => 'no'
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_title_controls() {
		/**
		 * Style Tab: Title
		 */
		$this->start_controls_section(
			'section_title_style',
			array(
				'label' => 'Título',
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => 'Tamaño del Ícono',
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 40,
				),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-advanced-tabs-title .cd-title-text .pp-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .cd-title-text-lines div' => 'height: calc( {{SIZE}}{{UNIT}}/2 + 10px );',

				),
			)
		);
		$this->add_responsive_control(
			'icon_image_width',
			array(
				'label'      => 'Ancho de Imagen Ícono',
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 30,
				),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-advanced-tabs-title .pp-icon-img img' => 'width: {{SIZE}}{{UNIT}}',
				),
				'separator'  => 'after',
			)
		);
		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => 'Espaciado',
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'separator'  => 'after',
				'default'    => array(
					'top'    => 17,
					'bottom' => 12,
					'left'   => 19,
					'right'  => 19,
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-advanced-tabs-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => 'Tipografía Título de tipología',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .pp-advanced-tabs-title .pp-advanced-tabs-title-text',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'titulo_linea_1',
				'label'    => 'Tipografía Título Línea 1',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .pp-advanced-tabs-title .cd-title-text .cd-title-text-line-1',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'titulo_linea_2',
				'label'    => 'Tipografía Título Línea 2',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .pp-advanced-tabs-title .cd-title-text .cd-title-text-line-2',
			)
		);


		$this->start_controls_tabs( 'tabs_title_style' );

		$this->start_controls_tab(
			'tab_title_normal',
			array(
				'label' => 'Normal',
			)
		);
		$this->add_control(
			'icon_color',
			array(
				'label'     => 'Color del Ícono',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .cd-title-text .pp-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .cd-title-text svg' => 'fill: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_text_color',
			array(
				'label'     => 'Color Título de tipología',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .pp-advanced-tabs-title .pp-advanced-tabs-title-text' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_text_color_line1',
			array(
				'label'     => 'Color Título Línea 1',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .pp-advanced-tabs-title .cd-title-text .cd-title-text-line-1' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_text_color_line2',
			array(
				'label'     => 'Color Título Línea 2',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .pp-advanced-tabs-title .cd-title-text .cd-title-text-line-2' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_bg_color',
			array(
				'label'     => 'Color Fondo de la tarjeta',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .pp-advanced-tabs-title' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_bg_color_line1',
			array(
				'label'     => 'Color Fondo Título Línea 1',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#58C4CF',
				'selectors' => array(
					'{{WRAPPER}} .cd-title-text-line-1' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_bg_color_line2',
			array(
				'label'     => 'Color Fondo Título Línea 2',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#58C4CF',
				'selectors' => array(
					'{{WRAPPER}} .cd-title-text-line-2' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab(); // End Normal Tab

		$this->start_controls_tab(
			'tab_title_active',
			array(
				'label' => 'Activo',
			)
		);
		$this->add_control(
			'icon_color_active',
			array(
				'label'     => 'Color del Ícono',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .pp-advanced-tabs-title.pp-tab-active .pp-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .pp-advanced-tabs-title.pp-tab-active svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .at-hover .pp-advanced-tabs-title:hover .pp-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .at-hover .pp-advanced-tabs-title:hover svg' => 'fill: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_text_color_active',
			array(
				'label'     => 'Color del Título',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .pp-tab-active .pp-advanced-tabs-title-text' => 'color: {{VALUE}}',
					'{{WRAPPER}} .at-hover .pp-advanced-tabs-title:hover .pp-advanced-tabs-title-text' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_bg_color_active',
			array(
				'label'     => 'Color de Fondo',
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-tab-active' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .at-hover .pp-advanced-tabs-title:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .pp-style-1 .at-horizontal .pp-tab-active:after' => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .pp-style-1 .at-vertical .pp-tab-active:after' => 'border-left-color: {{VALUE}}',
					'{{WRAPPER}} .pp-style-6 .pp-advanced-tabs-title.pp-tab-active:after' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_tab(); // End Hover Tab

		$this->end_controls_tabs(); // End Controls Tab

		$this->end_controls_section();
	}

	protected function register_style_content_controls() {
		/**
		 * Style Tab: Content
		 */
		$this->start_controls_section(
			'section_content_style',
			array(
				'label' => 'Contenido',
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'tab_align',
			array(
				'label'     => 'Alineación',
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'start'  => array(
						'title' => 'Izquierda',
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => 'Centro',
						'icon'  => 'fa fa-align-center',
					),
					'end'    => array(
						'title' => 'Derecha',
						'icon'  => 'fa fa-align-right',
					),
				),
				'default'   => 'center',
				'separator' => 'after',
				'selectors' => array(
					'{{WRAPPER}} .pp-advanced-tabs-content'   => 'text-align: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'tab_bg_style',
				'label'    => 'Tipo de fondo',
				'types'    => array( 'none', 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .pp-advanced-tabs-content',
			)
		);
		$this->add_control(
			'text_color',
			array(
				'label'     => 'Color del texto',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .pp-advanced-tabs-content' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_text_typography',
				'label'    => 'Tipografía del texto',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .pp-advanced-tabs-content',
			)
		);
		$this->add_responsive_control(
			'tab_padding',
			array(
				'label'      => 'Espaciado',
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'    => 17,
					'bottom' => 12,
					'left'   => 19,
					'right'  => 19,
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-advanced-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_section();
	}

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_register_style( 'contenidos-destacados-css', ELEMENTOR_ALCALDIA_URL . 'assets/css/contenidos-destacados.css');
		wp_register_script( 'contenidos-destacados-js', ELEMENTOR_ALCALDIA_URL . 'assets/js/contenidos-destacados.js', [ 'elementor-frontend', 'pp-advanced-tabs' ], ELEMENTOR_ALCALDIA_VERSION, true );
	}

	protected function render() {
		$settings        = $this->get_settings();
		$tabs            = $this->get_settings_for_display( 'tab_features' );
		$id_int          = substr( $this->get_id_int(), 0, 3 );
		$hover_class     = '';
		$default_tab_no  = '';
		$default_title   = '';
		$default_content = '';

		$fallback_defaults = array(
			'fa fa-check',
			'fa fa-times',
			'fa fa-dot-circle-o',
		);
		
		$default_tab_no = 0;

		$this->add_render_attribute(
			'container',
			array(
				'class' => array( 'pp-advanced-tabs', 'pp-' . $settings['custom_style'], 'pp-tabs-responsive-' . $settings['responsive_support'] ),
				'role'  => 'tablist',
			)
		);

		if ( 'no' !== $settings['scroll_top'] ) {
			$this->add_render_attribute( 'container', 'data-scroll-top', 'yes' );
		}

		if ( 'no' !== $settings['responsive_support'] ) {
			$this->add_render_attribute( 'container', 'class', 'pp-advanced-tabs-responsive' );
		}

		$this->add_render_attribute(
			'tabs-wrap',
			'class',
			array(
				'pp-advanced-tabs-wrapper',
				'pp-tabs-labels',
				'pp-toggle-icon-align-' . $settings['toggle_icon_align'], 
				$settings['type'],
				$hover_class,
			)
		);

		$top_title_tag = PP_Helper::validate_html_tag( $settings['tab_title_tag'] );
		$title_tag = PP_Helper::validate_html_tag( $settings['tag_titulo_contenido'] );

		$contenido = array();
		$lineas = 0;
		ob_start();
		foreach ( $tabs as $index => $item ) {

			$tab_count = $index + 1;
			$default_title = '';

			$tab_id = 'pp-advanced-tabs-title-' . $id_int . $tab_count;

			$title_text_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tab_features', $index );

			$this->add_render_attribute(
				$title_text_setting_key,
				array(
					'id'            => $tab_id,
					'class'         => array( 'pp-advanced-tabs-title', 'pp-tabs-label', 'pp-advanced-tabs-desktop-title', $default_title ),
					'data-tab'      => $tab_count,
					'data-wrapper'  => $lineas + 1,
					'data-index'    => $id_int . $tab_count,
					'tabindex'      => $id_int . $tab_count,
					'role'          => 'tab',
					'aria-controls' => 'pp-advanced-tabs-content-' . $id_int . $tab_count,
				)
			);
			?>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( $title_text_setting_key ) ); ?>>
				<div class="cd-top-text">
					<<?php esc_html_e( $top_title_tag ); ?> class="pp-advanced-tabs-title-text">
						<?php echo wp_kses_post( $item['tab_title'] ); ?>
					</<?php esc_html_e( $top_title_tag ); ?>>
					<?php $this->render_tab_top_title_icon( $item ); ?>
				</div>
				<div class="cd-title-text">
					<?php $this->render_tab_title_icon( $item ); ?>
					<<?php esc_html_e( $title_tag ); ?> class="cd-title-text-lines">
						<div class="cd-title-text-line-1"><?php echo wp_kses_post( $item['titulo_contenido_destacado_1'] ); ?></div>
						<div class="cd-title-text-line-2"><?php echo wp_kses_post( $item['titulo_contenido_destacado_2'] ); ?></div>
					</<?php esc_html_e( $title_tag ); ?>>
				</div>
			</div>
			<?php
			if ( $tab_count % 4 === 0 ) {
				$contenido[$lineas]['tabs'] = ob_get_clean();
				$lineas++;
				ob_start();
			}
		}

		$post_ciclo = ob_get_clean();

		if ( trim( $post_ciclo ) ) {
			$contenido[$lineas]['tabs'] = $post_ciclo;
		}

		$total_lineas = $lineas;
		$lineas = 0;
		ob_start();
		foreach ( $tabs as $index => $item ) :
			$tab_count = $index + 1;
			$default_content = '';
			$tab_id = 'pp-advanced-tabs-title-' . $id_int . $tab_count;
			$tab_title = wp_kses_post( $item['tab_title'] );
			$image_key = $this->get_repeater_setting_key( 'image', 'cd-item', $tab_count );

			if ( ! empty( $item['url_contenido_destacado']['url'] ) ) {
				$button_key = $this->get_repeater_setting_key( 'button', 'cd-items', $tab_count );

				$this->add_render_attribute( $button_key, 'class', [
					'cd-button',
					'elementor-button',
					'elementor-size-md',
				] );

				$this->add_link_attributes( $button_key, $item['url_contenido_destacado'] );
			}

			$tab_content_setting_key = $this->get_repeater_setting_key( 'content', 'tab_features', $index );

			$this->add_render_attribute(
				$tab_content_setting_key,
				array(
					'id'              => 'pp-advanced-tabs-content-' . $id_int . $tab_count,
					'class'           => array( 'pp-advanced-tabs-content', 'elementor-clearfix', 'pp-advanced-tabs-' . $item['content_type'], $default_content ),
					'data-tab'        => $tab_count,
					'role'            => 'tabpanel',
					'aria-labelledby' => $tab_id,
				)
			);
			?>
			<div class="pp-tabs-panel">
			<div class="pp-advanced-tabs-title pp-tabs-label pp-tab-responsive <?php echo esc_attr( $default_content ) . esc_attr( $hover_class ); ?>" data-index ="<?php echo esc_attr( $id_int ) . esc_attr( $tab_count ); ?>">
				<div class="cd-top-text">
					<<?php esc_html_e( $top_title_tag ); ?> class="pp-advanced-tabs-title-inner">
						<?php echo $tab_title; ?>
					</<?php esc_html_e( $top_title_tag ); ?>>
					<?php $this->render_tab_top_title_icon( $item ); ?>
				</div>
				<div class="cd-title-text">
					<?php $this->render_tab_title_icon( $item ); ?>
					<<?php esc_html_e( $title_tag ); ?> class="cd-title-text-lines">
						<div class="cd-title-text-line-1"><?php echo wp_kses_post( $item['titulo_contenido_destacado_1'] ); ?></div>
						<div class="cd-title-text-line-2"><?php echo wp_kses_post( $item['titulo_contenido_destacado_2'] ); ?></div>
					</<?php esc_html_e( $title_tag ); ?>>
				</div>
			</div>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( $tab_content_setting_key ) ); ?>>
				<div class="cd-content">
					<<?php esc_html_e( $top_title_tag ); ?> class="cd-content-title">
						<?php echo $tab_title; ?>
					</<?php esc_html_e( $top_title_tag ); ?>>
					<p class="cd-content-text"><?php echo $this->get_tabs_content( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<?php if ( ! empty( $item['url_contenido_destacado']['url'] ) ) { ?>
					<a <?php echo wp_kses_post( $this->get_render_attribute_string( $button_key ) ); ?>>
						<span class="pp-button-text">CONOCE MÁS</span>
					</a>
					<?php } ?>
				</div>
				<?php
				if ( $item['image']['url'] ) {
					$image_url = Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'image', $settings );

					if ( ! $image_url ) {
						$image_url = $item['image']['url'];
					}

					$this->add_render_attribute( $image_key, [
						'src' => $image_url,
					] );
				?>
				<div class="cd-content-image">
					<img <?php echo wp_kses_post( $this->get_render_attribute_string( $image_key ) ); ?>>
				</div>
				<?php
				}
				?>
			</div>
			</div>
			<?php
			if ( $tab_count % 4 === 0 ) {
				$contenido[$lineas]['content'] = ob_get_clean();
				$lineas++;
				ob_start();
			}
			?>
		<?php endforeach; ?>
		<?php
		$post_ciclo = ob_get_clean();

		if ( trim( $post_ciclo ) ) {
			$contenido[$lineas]['content'] = $post_ciclo;
		}
		?>
		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'container' ) ); ?>>
			<?php foreach ($contenido as $index => $bloque): ?>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'tabs-wrap' ) ); ?>>
				<?php echo $bloque['tabs']; ?>
			</div>
			<div class="pp-advanced-tabs-content-wrapper cd-tabs-content-wrapper-<?php echo esc_attr( $index + 1 ); ?> pp-tabs-panels <?php echo esc_attr( $settings['type'] ); ?>-content">
				<?php echo $bloque['content']; ?>
			</div>
			<?php endforeach ?>
		</div>
		<?php
	}

	/**
	 *  Get Saved Widgets
	 *
	 *  @param string $type Type.
	 *
	 *  @return string
	 */
	public function render_tab_title( $item ) {
		$settings = $this->get_settings();

		$migration_allowed = Icons_Manager::is_migration_allowed();

		// add old default
		if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
			$item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
		}

		$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
		$is_new   = ! isset( $item['icon'] ) && $migration_allowed;

		if ( 'icon' === $item['pp_icon_type'] && ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) ) {
			?>
			<span class="pp-icon pp-advanced-tabs-icon-left">
			<?php
			if ( $is_new || $migrated ) {
				Icons_Manager::render_icon( $item['selected_icon'], array( 'aria-hidden' => 'true' ) );
			} else {
				?>
				<i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
			<?php } ?>
			</span>
			<?php
		}
	}

	/**
	 *  Get Saved Widgets
	 *
	 *  @param string $type Type.
	 *
	 *  @return string
	 */
	public function render_tab_top_title_icon( $item ) {
		$settings = $this->get_settings();

		$has_toggle_icon = ! empty( $settings['toggle_icon_normal'] );

		if ( $has_toggle_icon ) {
			$this->add_render_attribute( 'toggle-icon-normal', 'class', $settings['toggle_icon_normal'] );
			$this->add_render_attribute( 'toggle-icon-normal', 'aria-hidden', 'true' );
		}

		$has_toggle_active_icon = ! empty( $settings['toggle_icon_active'] );

		if ( $has_toggle_active_icon ) {
			$this->add_render_attribute( 'toggle-icon-active', 'class', $settings['toggle_icon_active'] );
			$this->add_render_attribute( 'toggle-icon-active', 'aria-hidden', 'true' );
		}

		?>
		<div class="pp-accordion-toggle-icon">
				<span class='pp-accordion-toggle-icon-open pp-icon'>
					<?php
					if ( ! empty( $settings['toggle_icon_active'] ) ) {
						?><i <?php echo wp_kses_post( $this->get_render_attribute_string( 'toggle-icon-active' ) ); ?>></i><?php
					}
					?>
				</span>
				<span class='pp-accordion-toggle-icon-close pp-icon'>
					<?php
					if ( ! empty( $settings['toggle_icon_active'] ) ) {
						?><i <?php echo wp_kses_post( $this->get_render_attribute_string( 'toggle-icon-normal' ) ); ?>></i><?php
					}
					?>
				</span>
		</div>
		<?php
	}

	public function render_tab_title_icon( $item ) {
		$settings = $this->get_settings();
		if ( 'none' === $item['pp_icon_type'] ) {
			return;
		}

		$migration_allowed = Icons_Manager::is_migration_allowed();

		// add old default
		if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
			$item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
		}

		$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
		$is_new   = ! isset( $item['icon'] ) && $migration_allowed;

		if ( 'icon' === $item['pp_icon_type'] && ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) ) {
			?>
			<span class="pp-icon pp-advanced-tabs-icon-left">
			<?php
			if ( $is_new || $migrated ) {
				Icons_Manager::render_icon( $item['selected_icon'], array( 'aria-hidden' => 'true' ) );
			} else {
				?>
				<i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
			<?php } ?>
			</span>
			<?php
		} elseif ( 'image' === $item['pp_icon_type'] ) {
			?>
			<span class="pp-icon-img pp-advanced-tabs-icon-left">
			<?php echo wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $item, 'icon_img', 'icon_img' ) ); ?>
			</span>
			<?php
		}
	}

	public function get_style_depends() {
		return [ 'contenidos-destacados-css' ];
	}

	public function get_script_depends() {
		return [ 'contenidos-destacados-js' ];
	}

}