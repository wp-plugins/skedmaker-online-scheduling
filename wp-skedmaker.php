<?php
/**
 * @package DB Explorer
 * @version 0.93
 */
/*
Plugin Name: Skedmaker
Plugin URI: http://www.skedmaker.com/?op=skedmaker&amp;
Description: Online Appointment Scheduling
Version: 0.93
Author URI: http://www.skedmaker.com/
*/

add_action('activated_plugin','save_error');
function save_error(){file_put_contents(plugin_dir_path( __FILE__ ) . '/error.html', ob_get_contents());}

function plugin_admin_add_page() {
	add_menu_page( 'Skedmaker Admin', 'Skedmaker', 'manage_options', plugin_dir_path( __FILE__ ) . 'admin_home.php', '', 'dashicons-calendar-alt', 81);
}
add_action('admin_menu', 'plugin_admin_add_page');


function my_enqueue($hook) {
  //-- for our special admin page
	if( 'skedmaker/admin_home.php' != $hook )
		return;

  wp_register_style('skedmaker', plugins_url('skedmaker-online-scheduling/_includes/sm-styles.php'));
  wp_enqueue_style('skedmaker');

}

//-- Start session if not already started
function register_session(){if( !session_id() )session_start();}
add_action('init','register_session');

add_action('admin_enqueue_scripts', 'my_enqueue');

//[wp-skedmaker]
function skedmaker_shortcode($atts){include_once(plugin_dir_path( __FILE__ ) . "index.php");}
add_shortcode( 'wp-skedmaker', 'skedmaker_shortcode' );
?>