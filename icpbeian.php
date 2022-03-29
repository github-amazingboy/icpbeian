<?php
/**
 * Plugin Name:       ICPBEIAN
 * Plugin URI:        https://github.com/github-amazingboy/icpbeian
 * Description:       China WebSite Beian
 * Version:           1.00.0
 * Requires at least: 3.6
 * Requires PHP:      5.2
 * Author:            Amazing Zhang
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/github-amazingboy/icpbeian
 * Text Domain:       icpbeian
 * Domain Path:       /languages
 */
class ICPBeian{

    var $optionID = "icpbeianID";

    public static function load_translation_files() {
        $ret = load_plugin_textdomain('icpbeian', false, dirname( plugin_basename( __FILE__ ) ) ."/languages");
    }

    // __("China WebSite Beian","icpbeian");
    // __("ICPBEIAN","icpbeian");


    function pluginprefix_deactivate() { 
        unregister_setting( 'general', $this->optionID );
        remove_shortcode( 'icpbeian' );
    }

    function __construct(){
        //ICPBeian::load_translation_files();
        load_plugin_textdomain('icpbeian');
         register_deactivation_hook( __FILE__, array($this, 'pluginprefix_deactivate'));
         add_action('admin_init', array($this, 'register_icpbeianID'));
         add_action( 'init', array($this, 'add_icpbeian_shortcode' ));
    }


    function register_icpbeianID(){
        register_setting( 'general', $this->optionID );
        // My Example Fields
        add_settings_field(  
            $this->optionID,                      
            __('ICP Number','icpbeian'),               
            array($this, 'icpbeianID_textbox_callback'),   
            'general',                     
            'default',
            array(
              'label_for' => $this->optionID
            ) 
        );
    }

    function icpbeianID_textbox_callback() { 
        $options = get_option($this->optionID); 
        echo "<input type='text' id='{$this->optionID}' name='{$this->optionID}' value='{$options}'/>" . __('ShortCode','icpbeian') . ':[icpbeian name="粤"],[icpbeian]';
    }

    function add_icpbeian_shortcode() {
        add_shortcode( 'icpbeian', array($this, 'icpbeian_func')  );
    }

    function icpbeian_func( $atts ) {
        $beianName = $atts['name'];
        if (empty( $atts ) || empty( $atts['name'])){
          $beianName = get_option($this->optionID); 
        }
        return "<a id='beianflag' class='beianflag' href='https://beian.miit.gov.cn/'>{$beianName}</a>";
    }
}

add_action( 'init', function(){  $instance = new ICPBeian(); },5 );
