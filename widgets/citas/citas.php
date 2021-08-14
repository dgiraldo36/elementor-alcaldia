<?php

use Elementor\Widget_Testimonial;
use PowerpackElements\Modules\AdvancedAccordion\Widgets\Advanced_Accordion;

class Alcaldia_Citas_Widget extends Widget_Testimonial {
	public function get_name() {
		return 'citas';
	}

	public function get_title() {
		return __( 'Citas Alcaldía', 'plugin-name' );
	}

	public function get_categories() {
		return [ 'variables-alcaldia' ];
	}

	public function get_keywords() {
		return ['Citas', 'qotes'];
	}

	// private function _get_settings() {
	// 	$settings = array(
	// 		'toggle_icon_align'  => 'right',
	// 		'toggle_icon_normal' => 'fas fa-chevron-down',
	// 		'toggle_icon_active' => 'fas fa-chevron-up',
	// 		'tabs' => array(

	// 		)
	// 	);

	// 	return $settings;
	// }

	public function render() {
		parent::render();
	}

	// protected function register_style_toggle_icon_controls() {}

	// protected function register_controls() {
	// 	$this->register_style_items_controls();
	// 	$this->register_style_title_controls();
	// 	$this->register_style_content_controls();
	// 	$this->register_style_toggle_icon_controls();
	// }

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_register_style( 'test-handle', ELEMENTOR_ALCALDIA_PATH . 'assets/css/test.css');
	}

}