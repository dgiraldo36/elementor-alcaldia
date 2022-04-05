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
use Elementor\Widget_Common;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Modules\DynamicTags\Module as TagsModule;

class Widget_Alcaldia_Siata extends Posts_Base {
	public function get_name() {
		return 'siata';
	}

	public function get_title() {
		return 'SIATA';
	}

	public function get_icon() {
		return [ 'eicon-cloud-check' ];
	}

	public function get_categories() {
		return [ 'variables-alcaldia' ];
	}

	public function get_keywords() {
		return ['Siata', 'temperatura', 'pm2-5'];
	}

	public function register_controls() {
		$this->start_controls_section(
			'section_info',
			array(
				'label' => 'Información',
				'description' => 'Este Widget consume la API de SIATA para desplegar temperatura y concentración de particulas PM2.5'
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		render_api_siata();
	}

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_register_style( 'siata-css', ELEMENTOR_ALCALDIA_URL . 'assets/css/siata.css');
		wp_register_script( 'siata-js', ELEMENTOR_ALCALDIA_URL . 'assets/js/siata.js', array(), null, true);
	}

	public function get_style_depends() {
		return [ 'siata-css' ];
	}

	public function get_script_depends() {
		return [ 'siata-js' ];
	}

}


function render_api_siata() {
	wp_enqueue_style('siata-css');
	wp_enqueue_script('siata-js');
	$siata_pm25 = siata_obtener_pm25();

	$opciones = array( '<option class="lt" value="no_datos">No hay Datos</option>' );

	$estado = '';

	if ( $siata_pm25->datos ) {
		$opciones = [];
		foreach ( $siata_pm25->datos as $key => $datos ) {
			switch( $datos->categoria ) {
				case 'Sin datos en las últimas 24 horas':
					$css_class ='sin_datos';
					break;
				case 'Dañina para grupos sensibles':
					$css_class ='danina_gs';
					break;
				case 'Dañina a la salud':
					$css_class ='danina';
					break;
				case 'Muy dañina a la salud':
					$css_class ='muy_danina';
					break;
				case 'Moderada':
				case 'Buena': 
					$css_class = strtolower($datos->categoria);
					break;
				default:
					$css_class = 'no_aplica';
			}

			$nombre = explode('-', str_replace( 'Estación ', '', $datos->nombre ) );
			$opcion = sprintf(
				'<option class="lt %5$s" data-id="estacion_%1$s" data-estado="%2$s" value="%3$s">%4$s</option>',
				esc_attr( $datos->codigo ),
				esc_attr( $css_class ),
				esc_attr( $datos->valorICA ),
				esc_html( trim ( $nombre[1] ) . ' - ' . trim( $nombre[2] ) ),
				esc_attr( $css_class )
			);


			if ( $datos->codigo == 83 ) {
				array_unshift( $opciones, $opcion );
				$estado = esc_html( $datos->categoria );
				continue;
			}

			$opciones[] = $opcion;
		}
	}

	?>
	<!-- Clima Medellín -->
	<div id="ATemasDeCiudad" class="estado_tiempo_">
	  <div class="centradototal_">
	    <div class="grid_">
	      <img src="<?php bloginfo('template_directory'); ?>/img/termometro.svg" alt="">
	      <div class="estadot"><b>Estado del tiempo</b> - Clima Actual</div>
	      <div class="clima"><?php siata_obtener_temperatura(true); ?> ºC</div>
	    </div>
	    <div class="grid_">
	      <div class="texto_inf">
	        <span class="calidad_a">Calidad del <b>Aire:</b></span>
	      </div>
	      <div class="select_formulario">
	        <select name="state" class="ddList">
	          <?php echo implode("\n", $opciones); ?>
	        </select>
	      </div>
	    </div>
	    <div class="grid_">
	      <div class="situ_t siata_estado_<?php echo strtolower( $estado ); ?>" data-estado="<?php echo strtolower( $estado ); ?>">
	      	<b>PM <sub>2.5</sub></b> <i><ion-icon name="radio-button-on-outline"></ion-icon><span class="siata_estado_texto"><?php echo $estado; ?></span></i>
	      </div>
	    </div>
	  </div>
	</div>
	<?php
}

function siata_obtener_temperatura( $echo = false ) {
	$api_temp = get_transient( 'siata_temperatura' );
	if ( ! $api_temp ) {
		$api_temp = wp_remote_get(
			'http://siata.gov.co:8089/temperaturaMedellin/8af684e703d74e6cd0ed0d5338c7a401a1a5e15b/?format=json',
			array(
				'timeout' => 1,
			)
		);
		$api_temp = wp_remote_retrieve_body( $api_temp );

		$api_temp = json_decode( $api_temp );

		if ( $api_temp->datos && $api_temp->mensaje && $api_temp->mensaje == 'Consulta exitosa' ) { 
			// Almacenar en transiente usando formato JSON decodificado.
			set_transient( 'siata_temperatura', $api_temp, HOUR_IN_SECONDS );
		}
	}

	$temp = '?';

	if ( $api_temp->datos && $api_temp->datos->T ) {
		$temp = $api_temp->datos->T;
	}

	if ( $echo ) {
		esc_html_e( $temp );
		return;
	}

	return $temp;
}

function siata_obtener_pm25() {
	$api_pm25 = get_transient( 'siata_pm25' );

	if ( ! $api_pm25 ) {
		$api_pm25 = wp_remote_get(
			'http://siata.gov.co:8089/estacionesAirePM25/8af684e703d74e6cd0ed0d5338c7a401a1a5e15b/?format=json',
			array(
				'timeout' => 1,
			)
		);
		$api_pm25 = wp_remote_retrieve_body( $api_pm25 );

		$api_pm25 = json_decode( $api_pm25 );

		if ( $api_pm25->datos && $api_pm25->mensaje && $api_pm25->mensaje == 'Consulta exitosa' ) {
			// Almacenar en transiente usando formato JSON decodificado.
			set_transient( 'siata_pm25', $api_pm25, HOUR_IN_SECONDS );
		}
	}

	return $api_pm25;

}
