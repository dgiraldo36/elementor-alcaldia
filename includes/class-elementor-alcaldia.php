<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once ELEMENTOR_ALCALDIA_PATH . 'includes/functions.php';

class Elementor_Alcaldia {
	private $widgets_alcaldia = array(
		'eventos-convocatorias'  => 'Eventos_Convocatorias',
		'contenidos-destacados' => 'Contenidos_Destacados',
		'biblioteca-multimedia' => 'Biblioteca_Multimedia',
		'siata' => 'Siata'
	);

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

	public function enqueue_scripts() {
		wp_enqueue_style(
			'el-font-awesome',
			ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css',
			[],
			'4.7.0'
		);
	}

	public function register_widgets() {
		foreach( $this->widgets_alcaldia as $carpeta_archivo => $clase ) {
			$archivo = sprintf( ELEMENTOR_ALCALDIA_PATH . 'widgets/%1$s/%1$s.php', $carpeta_archivo );
			if ( file_exists( $archivo ) ) {
				require_once $archivo;
				$classname = 'Widget_Alcaldia_' . $clase;
				$widget = new $classname;
				\Elementor\Plugin::instance()->widgets_manager->register_widget_type( $widget );
			}
		}
		// require_once ELEMENTOR_ALCALDIA_PATH . 'widgets/contenidos-destacados/contenidos-destacados.php';

		// $test_widget = new Alcaldia_Widget_Contenidos_Destacados();

		// \Elementor\Plugin::instance()->widgets_manager->register_widget_type( $test_widget );

	}

	protected function add_actions() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts') );
		add_action( 'elementor/init', array( $this, 'elementor_init' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
		add_action( 'ppe_before_single_post_button', array($this, 'typ_boton_post'), 10, 2 );
	}

	public function typ_boton_post( $post_id, $settings ) {
	    if ( $settings && 'variable-tys' === $settings['_css_classes'] ) {
	        $link = get_field( 'link_tramite-servicio', get_the_ID() );
	    	if ( $link ) {
	        ?>
		        <a href="<?php esc_attr_e( $link ); ?>" class="boton-realizar-tys button-<?php echo get_the_ID() ?>" target="_blank"><span class="boton-tys-texto">Realizar</span></a>
	        <?php
		    }
	    }
	}

	/**
	 * Plugin constructor.
	 */
	private function __construct() {
		$this->add_actions();
	}
}
