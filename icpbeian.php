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

   /*
  * this function loads my plugin translation files
  */
  function smart_seo_load_translation_files() {
    $ret = load_plugin_textdomain('icpbeian', false, dirname( plugin_basename( __FILE__ ) ) ."/languages");
   }
   
   //add action to load my plugin files
   add_action('plugins_loaded', 'smart_seo_load_translation_files');

   /**
 * Activate the plugin.
 */
function pluginprefix_activate() { 
  __("China WebSite Beian","icpbeian");
  __("ICPBEIAN","icpbeian");
}
add_action( 'init', 'wpdocs_add_custom_shortcode' );
function wpdocs_add_custom_shortcode() {
  add_shortcode( 'icpbeian', 'icpbeian_func' );
}
function icpbeian_func( $atts ) {
  $beianName = $atts['name'];
  if (empty( $atts ) || empty( $atts['name'])){
    $beianName = get_option( 'icpbeianID');
  }
  return "<a id='beianflag' class='beianflag' href='https://beian.miit.gov.cn/'>{$beianName}</a>";
}
register_activation_hook( __FILE__, 'pluginprefix_activate' );

add_action('admin_init', 'register_icpbeianID');

function register_icpbeianID(){
  register_setting( 'general', 'icpbeianID' );
  // My Example Fields
  add_settings_field(  
    'icpbeianID',                      
    __('ICP Number','icpbeian'),               
    'icpbeianID_textbox_callback',   
    'general',                     
    'default',
    array(
      'label_for' => 'icpbeianID'
    ) 
  );
}


// My Shared Callback
function icpbeianID_textbox_callback() { 
  $options = get_option('icpbeianID'); 

  echo '<input type="text" id="icpbeianID" name="icpbeianID" value="' . $options . '"/>'.__('ShortCode','icpbeian').':[icpbeian name="粤"],[icpbeian]';

}


function pluginprefix_deactivate() { 
  unregister_setting( 'general', 'icpbeianID' );
  remove_shortcode( 'icpbeian' );
}
register_deactivation_hook( __FILE__,'pluginprefix_deactivate');