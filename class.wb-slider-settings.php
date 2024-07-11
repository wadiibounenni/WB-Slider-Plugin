<?php 

if( ! class_exists( 'WB_Slider_Settings' )){
    class WB_Slider_Settings{

        public static $options;

        public function __construct(){
            self::$options = get_option( 'wb_slider_options' );
            add_action( 'admin_init', array( $this, 'admin_init') );
        }

        public function admin_init(){
            
            register_setting( 'wb_slider_group', 'wb_slider_options', array( $this, 'wb_slider_validate' ) );

            add_settings_section(
                'wb_slider_main_section',
                esc_html__('How does it work?', 'wb-slider'),
                null,
                'wb_slider_page1'
            );

            add_settings_section(
                'wb_slider_second_section',
                esc_html__('Other Plugin Options', 'wb-slider' ),
                null,
                'wb_slider_page2'
            );

            add_settings_field(
                'wb_slider_shortcode',
                esc_html__('Shortcode', 'wb-slider' ),
                array( $this, 'wb_slider_shortcode_callback' ),
                'wb_slider_page1',
                'wb_slider_main_section'
            );

            add_settings_field(
                'wb_slider_title',
                esc_html__( 'Slider Title', 'wb-slider' ),
                array( $this, 'wb_slider_title_callback' ),
                'wb_slider_page2',
                'wb_slider_second_section',
                array(
                    'label_for' => 'wb_slider_title'
                )
            );

            add_settings_field(
                'wb_slider_bullets',
                esc_html__( 'Display Bullets', 'wb-slider' ),
                array( $this, 'wb_slider_bullets_callback' ),
                'wb_slider_page2',
                'wb_slider_second_section',
                array(
                    'label_for' => 'wb_slider_bullets'
                )
            );

            add_settings_field(
                'wb_slider_style',
                esc_html__( 'Slider Style', 'wb-slider' ),
                array( $this, 'wb_slider_style_callback' ),
                'wb_slider_page2',
                'wb_slider_second_section'
            );
        }

        public function wb_slider_shortcode_callback(){
            ?>
            <span><?php esc_html_e( 'Use the shortcode [wb_slider] to display the slider in any page/post/widget', 'wb-slider' ); ?></span>
            <?php
        }

        public function wb_slider_title_callback( $args ){
            ?>
                <input 
                type="text" 
                name="wb_slider_options[wb_slider_title]" 
                id="wb_slider_title"
                value="<?php echo isset( self::$options['wb_slider_title'] ) ? esc_attr( self::$options['wb_slider_title'] ) : ''; ?>"
                >
            <?php
        }
        
        public function wb_slider_bullets_callback( $args ){
            ?>
                <input 
                    type="checkbox"
                    name="wb_slider_options[wb_slider_bullets]"
                    id="wb_slider_bullets"
                    value="1"
                    <?php 
                        if( isset( self::$options['wb_slider_bullets'] ) ){
                            checked( "1", self::$options['wb_slider_bullets'], true );
                        }    
                    ?>
                />
                <label for="wb_slider_bullets"><?php esc_html_e( 'Whether to display bullets or not', 'wb-slider' ); ?></label>
                
            <?php
        }

        public function wb_slider_style_callback(){
            ?>
            <select 
                id="wb_slider_style" 
                name="wb_slider_options[wb_slider_style]">
                <option value="style-1" 
                    <?php isset( self::$options['wb_slider_style'] ) ? selected( 'style-1', self::$options['wb_slider_style'], true ) : ''; ?>>Style 1</option>
                <option value="style-2" 
                    <?php isset( self::$options['wb_slider_style'] ) ? selected( 'style-2', self::$options['wb_slider_style'], true ) : ''; ?>>Style 2</option>
            </select>
            <?php
        }

        public function wb_slider_validate( $input ){
            $new_input = array();
            foreach( $input as $key => $value ){
                switch ($key){
                    case 'wb_slider_title':
                        if( empty( $value )){
                            add_settings_error( 'wb_slider_options', 'wb_slider_message', esc_html__( 'The title field can not be left empty', 'wb-slider' ), 'error' );
                            $value =  esc_html__( 'Please, type some text', 'wb-slider' );
                        }
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                    default:
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                }
            }
            return $new_input;
        }

    }
}