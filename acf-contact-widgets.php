<?php
/*
Plugin Name: ACF Contact Widgets
Plugin URI: 
Description: Address, Phone Number, and Social Media Account widgets along with custom fields and a site-wide custom options page to edit them.
Version: 1.0
Author: Michael W. Delaney
Author URI: 
License: MIT
*/


/**
 * Define constants
 */

    define( 'ACFCONTACTWIDGETS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );



$widgets_includes = [
	'lib/acf-fields/contact-info.php',  // Placeholder info for "Contact Info"
	'lib/acf-fields/address.php',    	// Address fields
	'lib/widgets/widget-address.php',   // Address widget
	'lib/acf-fields/phones.php',    	// Phones fields
	'lib/widgets/widget-phones.php',    // Phones widget
	'lib/acf-fields/social.php',    	// Social fields
	'lib/widgets/widget-social.php',    // Social widget
];

foreach ($widgets_includes as $file) {
  if ( !$filepath = ACFCONTACTWIDGETS_PLUGIN_DIR . $file ) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);



/**
 * Register ACF options pages
 */
    if( function_exists('acf_add_options_page') ) {

        acf_add_options_page(array(
            'page_title' 	=> 'Contact Information Configuration',
            'menu_title'	=> 'Contact Info',
            'menu_slug' 	=> 'contact-config',
            'capability'	=> 'edit_posts',
            'redirect'		=> false
        ));

        acf_add_options_sub_page(array(
            'page_title' 	=> 'Contact Information',
            'menu_title' 	=> 'Address and Phone',
            'parent_slug' 	=> 'contact-config',
        ));

        acf_add_options_sub_page(array(
            'page_title' 	=> 'Social Accounts',
            'menu_title' 	=> 'Social',
            'parent_slug' 	=> 'contact-config',
        ));
    }
