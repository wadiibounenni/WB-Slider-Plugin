<?php 

if( ! class_exists('WB_Slider_Shortcode')){
    class WB_Slider_Shortcode{
        public function __construct(){
            add_shortcode( 'wb_slider', array( $this, 'add_shortcode' ) );
        }

        public function add_shortcode( $atts = array(), $content = null, $tag = '' ){

            $atts = array_change_key_case( (array) $atts, CASE_LOWER );

            extract( shortcode_atts(
                array(
                    'id' => '',
                    'orderby' => 'date'
                ),
                $atts,
                $tag
            ));

            if( !empty( $id ) ){
                $id = array_map( 'absint', explode( ',', $id ) );
            }

            ob_start();
            require( WB_SLIDER_PATH . 'views/wb-slider_shortcode.php' );
            wp_enqueue_script( 'wb-slider-main-jq' );
            wp_enqueue_style( 'wb-slider-main-css' );
            wp_enqueue_style( 'wb-slider-style-css' );
            wb_slider_options();
            return ob_get_clean();
        }
    }
}