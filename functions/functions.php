<?php

if( ! function_exists( 'wb_slider_options' )){
    function wb_slider_options(){
        $show_bullets = isset( WB_Slider_Settings::$options['wb_slider_bullets'] ) && WB_Slider_Settings::$options['wb_slider_bullets'] == 1 ? true : false;

        wp_enqueue_script( 'wb-slider-options-js', WB_SLIDER_URL . 'vendor/flexslider.js', array( 'jquery' ), WB_SLIDER_VERSION, true );
        wp_localize_script( 'wb-slider-options-js', 'SLIDER_OPTIONS', array(
            'controlNav' => $show_bullets
        ) );
    }
}
