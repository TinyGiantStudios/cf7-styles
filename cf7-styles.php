<?php
/*
Plugin Name: Contact Form 7 Designer
Version: 1.0
Plugin URI: http://tinygiantstudios.co.uk
Author: Tiny Giant Studios
Author URI: http://www.tinygiantstudios.co.uk
Description: Contact Form 7 Designer is an add-on for Contact Form 7 that allows you to add custom designs for your contact form, without requiring any coding knowledge.


/*
 * Load Redux Framework
 */
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' );
}

require_once( dirname( __FILE__ ) . '/cf7-styles-config.php' );


/*
 * Load plugin js
 */
function cf7_styles_enqueue() {
	if (!(wp_script_is( 'jquery', 'enqueued' ))) {
		// jQuery is NOT enqueued, let's load it from Google
		wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', '', '1.10.2');
		wp_enqueue_script( 'jquery' );
	}

	wp_register_script('cf7_styles_scripts', plugins_url('/includes/js/cf7-styles.js', __FILE__), array('jquery'));
	wp_enqueue_script( 'cf7_styles_scripts' );
}

add_action( 'wp_enqueue_scripts', 'cf7_styles_enqueue' );

?>