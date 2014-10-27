<?php
/**
 * @package DB Explorer
 * @version 0.1
 */
/*
Plugin Name: Skedmaker
Plugin URI: http://www.skedmaker.com/?op=skedmaker&amp;
Description: Online Appointment Scheduling
Version: 0.1
Author URI: http://www.skedmaker.com/
*/

add_action('activated_plugin','save_error');
function save_error(){file_put_contents(plugin_dir_path( __FILE__ ) . '/error.html', ob_get_contents());}

//http://codex.wordpress.org/Function_Reference/add_menu_page

function plugin_admin_add_page() {
	add_menu_page( 'Skedmaker Admin', 'Skedmaker', 'manage_options', 'skedmaker/admin_home.php', '', 'dashicons-calendar-alt', 81);
}
add_action('admin_menu', 'plugin_admin_add_page');


function my_enqueue($hook) {
  //-- for our special admin page
	if( 'skedmaker/admin_home.php' != $hook )
		return;

  wp_register_style('skedmaker', plugins_url('skedmaker/_includes/sm-styles.php'));
  wp_enqueue_style('skedmaker');

// wp_enqueue_script('pluginscript', plugins_url('skedmaker/includes/sm-javascript.php', __FILE__ ), array('jquery'));
}

//--- WP JQUERY
//function SM_inc_jquery() {wp_enqueue_script('jquery');}
//add_action('init', 'SM_inc_jquery');


//-- Start session if not already started
function register_session(){if( !session_id() )session_start();}
add_action('init','register_session');

add_action('admin_enqueue_scripts', 'my_enqueue');

//[skedmaker]
function skedmaker_shortcode($atts){include_once(plugin_dir_path( __FILE__ ) . "index.php");}
add_shortcode( 'skedmaker', 'skedmaker_shortcode' );
?>