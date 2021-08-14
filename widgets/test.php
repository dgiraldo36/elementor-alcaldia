<?php

use PowerpackElements\Modules\AdvancedTabs\Widgets\Advanced_Tabs;
use PowerpackElements\Classes\PP_Helper;

// Elementor Classes
use Elementor\Group_Control_Image_Size;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Alcaldia_Widget_Contenidos_Destacados extends Advanced_Tabs {
	public function get_name() {
		return 'contenidos-destacados';
	}

	public function get_title() {
		return 'Contenidos Destacados';
	}

	public function get_categories() {
		return [ 'variables-alcaldia' ];
	}

	public function get_keywords() {
		return ['Contenidos', 'Destacados'];
	}

	protected function register_controls() {
		$this->registrar_controles_contenidos_destacados();
		// parent::register_style_items_controls();
		parent::register_style_title_controls();
		parent::register_style_content_controls();
		// parent::register_style_toggle_icon_controls();
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
			'tab_content',
			array(
				'label' => __( 'Content', 'powerpack' ),
			)
		);

		$repeater->add_control(
			'tab_title',
			[
				'label'                 => 'Título de la pestaña',
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

		// Verificar!
		$repeater->add_control(
			'tab_title_icon',
			[
				'label'                 => __( 'Ícono', 'powerpack' ),
				'type'                  => Controls_Manager::ICONS,
				'label_block'           => true,
			]
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
				'default'               => 'Texto del Contenido Destacado. Puedes editar el texto directamente en esta ventana. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
				'dynamic'               => [ 'active' => true ],
				'condition'             => [
					'content_type'  => 'tab_content',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_icon',
			array(
				'label' => __( 'Icon', 'powerpack' ),
			)
		);

		$repeater->add_control(
			'pp_icon_type',
			[
				'label'             => __( 'Icon Type', 'powerpack' ),
				'type'              => Controls_Manager::CHOOSE,
				'label_block'       => false,
				'toggle'            => false,
				'default'           => 'icon',
				'options'           => [
					'none' => [
						'title' => esc_html__( 'None', 'powerpack' ),
						'icon'  => 'fa fa-ban',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'powerpack' ),
						'icon'  => 'fa fa-star',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'powerpack' ),
						'icon'  => 'fa fa-picture-o',
					],
				],
			]
		);

		$repeater->add_control(
			'selected_icon',
			array(
				'label'            => __( 'Icon', 'powerpack' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'default'          => array(
					'value'   => 'fas fa-check',
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
				'label'             => __( 'Image', 'powerpack' ),
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
				'label'     => __( 'Image Size', 'powerpack' ),
				'default'   => 'full',
				'condition' => array(
					'pp_icon_type' => 'image',
				),
			)
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
						'content'   => 'Texto del Contenido Destacado 1. Puedes editar el texto directamente en esta ventana. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
					),
					array(
						'tab_title' => 'Título Pestaña 2',
						'content'   => 'Texto del Contenido Destacado 2. Puedes editar el texto directamente en esta ventana. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.'
					),
					array(
						'tab_title' => 'Título Pestaña 3',
						'content'   => 'Texto del Contenido Destacado 3. Puedes editar el texto directamente en esta ventana. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
					),
				),
				'fields'                => $repeater->get_controls(),
				'title_field'           => '{{tab_title}}',
			]
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
			'toggle_icon_active',
			[
				'type'                  => Controls_Manager::HIDDEN,
				'default'               => 'fas fa-chevron-up'
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

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_register_style( 'test-handle', ELEMENTOR_ALCALDIA_PATH . 'assets/css/test.css');
		wp_register_script( 'contenidos-destacados-js', ELEMENTOR_ALCALDIA_URL . 'assets/js/contenidos-destacados.js', [ 'elementor-frontend' ], ELEMENTOR_ALCALDIA_VERSION, true );
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

		$hover_state = $settings['tab_hover_effect'];

		if ( 'yes' === $hover_state ) {
			$hover_class = ' at-hover';
		} else {
			$hover_class = ' at-no-hover';
		}

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
			$this->add_render_attribute( 'container', 'class', 'pp-advabced-tabs-responsive' );
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
		?>
		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'container' ) ); ?>>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'tabs-wrap' ) ); ?>>
				<?php
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
							'data-index'    => $id_int . $tab_count,
							'tabindex'      => $id_int . $tab_count,
							'role'          => 'tab',
							'aria-controls' => 'pp-advanced-tabs-content-' . $id_int . $tab_count,
						)
					);
					?>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( $title_text_setting_key ) ); ?>>
						<div class="pp-advanced-tabs-title-text"><?php echo wp_kses_post( $item['tab_title'] ); ?></div>
						<?php $this->render_tab_title_icon( $item ); ?>
					</div>
					<?php
				}
				?>
			</div>
			<div class="pp-advanced-tabs-content-wrapper pp-tabs-panels <?php echo esc_attr( $settings['type'] ); ?>-content">
				<?php
				foreach ( $tabs as $index => $item ) :
					$tab_count = $index + 1;
					$default_content = '';
					$tab_id = 'pp-advanced-tabs-title-' . $id_int . $tab_count;

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
						<div class="pp-advanced-tabs-title-inner">
							<?php $this->render_tab_title( $item ); ?>

							<span class="pp-advanced-tabs-title-text"><?php echo wp_kses_post( $item['tab_title'] ); ?></span>
							<i class="pp-toggle-icon pp-tab-open fa"></i>
						</div>
					</div>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( $tab_content_setting_key ) ); ?>>
						<?php echo $this->get_tabs_content( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					</div>
				<?php endforeach; ?>
			</div>
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
			<span class="pp-icon pp-advanced-tabs-icon-<?php echo esc_attr( $settings['icon_position'] ); ?>">
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
	public function render_tab_title_icon( $item ) {
		$settings = $this->get_settings();

		if ( 'none' !== $item['pp_icon_type'] && false ) {

			$migration_allowed = Icons_Manager::is_migration_allowed();

			// add old default
			if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
				$item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
			}

			$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
			$is_new   = ! isset( $item['icon'] ) && $migration_allowed;

			if ( 'icon' === $item['pp_icon_type'] && ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) ) {
				?>
				<span class="pp-icon pp-advanced-tabs-icon-<?php echo esc_attr( $settings['icon_position'] ); ?>">
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
				<span class="pp-icon-img pp-advanced-tabs-icon-<?php echo esc_attr( $settings['icon_position'] ); ?>">
				<?php echo wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $item, 'icon_img', 'icon_img' ) ); ?>
				</span>
				<?php
			}
		}

		$has_toggle_icon = ! empty( $settings['toggle_icon_normal'] );

		if ( $has_toggle_icon ) {
			$this->add_render_attribute( 'toggle-icon', 'class', $settings['toggle_icon_normal'] );
			$this->add_render_attribute( 'toggle-icon', 'aria-hidden', 'true' );
		}

		$has_toggle_active_icon = ! empty( $settings['toggle_icon_active'] );

		if ( $has_toggle_active_icon ) {
			$this->add_render_attribute( 'toggle-icon', 'class', $settings['toggle_icon_active'] );
			$this->add_render_attribute( 'toggle-icon', 'aria-hidden', 'true' );
		}

		?>
		<div class="pp-accordion-toggle-icon">
				<span class='pp-accordion-toggle-icon-close pp-icon'>
					<?php
					if ( ! empty( $settings['toggle_icon_normal'] ) ) {
						?><i <?php echo wp_kses_post( $this->get_render_attribute_string( 'toggle-icon' ) ); ?>></i><?php
					}
					?>
				</span>
				<span class='pp-accordion-toggle-icon-open pp-icon'>
					<?php
					if ( ! empty( $settings['toggle_icon_active'] ) ) {
						?><i <?php echo wp_kses_post( $this->get_render_attribute_string( 'toggle-icon' ) ); ?>></i><?php
					}
					?>
				</span>
		</div>
		<?php
	}

	public function get_script_depends() {
		return [ 'contenidos-destacados-js' ];
	}

}