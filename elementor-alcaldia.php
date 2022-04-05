<?php
/**
 * Plugin Name: Elementor Alcaldía
 * Description: Crea y modifica las Variables de Elementor y otros aspectos para el sitio de la Alcaldía de Medellín
 * Version: 0.0.3
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
