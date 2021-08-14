<?php
/**
 * Plugin Name: Elementor Alcaldía
 * Description: Crea y modifica las Variables de Elementor y otros aspectos para el sitio de la Alcaldía de Medellín
 * Version: 0.0.1
 * Author: Secretaría de Innovación Digital
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define constants.
define( 'ELEMENTOR_ALCALDIA_VERSION', '0.0.1' );
define( 'ELEMENTOR_ALCALDIA_PATH', plugin_dir_path( __FILE__ ) );
define( 'ELEMENTOR_ALCALDIA_URL', plugins_url( '/', __FILE__ ) );
define( 'ELEMENTOR_ALCALDIA_BASE', plugin_basename( __FILE__ ) );

require_once dirname( __FILE__ ) . '/includes/class-elementor-alcaldia.php';

add_action( 'plugins_loaded', 'elementor_alcaldia_init' );

function elementor_alcaldia_init () {
    // Do not load classes if Elementor is not active.
    if ( ! did_action( 'elementor/loaded' ) ) {
        return;
    }

    Elementor_Alcaldia::instance();    
}


add_action( 'ppe_before_single_post_button', 'hea_boton_post', 10, 2 );


function hea_boton_post( $post_id, $settings ) {
    if ( $settings && 'variable-tys' === $settings['_css_classes'] ) {
        ?>
        <a href="<?php esc_attr_e( the_field( 'url_del_tramite', get_the_ID() ) ); ?>" class="boton-realizar-tys button-<?php echo get_the_ID() ?>"><span class="boton-tys-texto">Realizar</span></a>
        <?php
    }
}