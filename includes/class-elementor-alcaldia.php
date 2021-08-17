<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Elementor_Alcaldia {
	/**
	 * @var Plugin
	 */
	public static $instance = null;

	/**
	 * @return Plugin
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function elementor_init() {
		// Add element category in panel
		\Elementor\Plugin::instance()->elements_manager->add_category(
			'variables-alcaldia', // This is the name of your addon's category and will be used to group your widgets/elements in the Edit sidebar pane!
			array(
				'title' => 'Variables Alcaldía', // The title of your modules category - keep it simple and short!
				'icon'  => 'font',
			),
			1
		);
	}

	public function register_widgets() {
		require_once ELEMENTOR_ALCALDIA_PATH . 'widgets/contenidos-destacados/contenidos-destacados.php';

		$test_widget = new Alcaldia_Widget_Contenidos_Destacados();

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( $test_widget );

	}

	protected function add_actions() {
		add_action( 'elementor/init', array( $this, 'elementor_init' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
	}

	/**
	 * Plugin constructor.
	 */
	private function __construct() {
		$this->add_actions();
	}
}
