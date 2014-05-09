<?php
/**
 * Plugin Name: TinyMCE Post Dropdown
 * Description: A plugin to add a custom button and dropdown with posts to TinyMCE
 * Plugin URI:  https://github.com/zero4281/tinymce-post-dropdown
 * Version:     0.0.1
 * Author:      Joshua Rising
 * Author URI:  https://github.com/zero4281/
 * License:     MIT
 */
 
function TMCEPD_dropdown_css() {
	wp_enqueue_style('TMCEPD_dropdown_css', plugins_url('/style.css', __FILE__));
}

add_action('admin_enqueue_scripts', 'TMCEPD_dropdown_css');

add_action( 'admin_head', 'TMCEPD_dropdown_add_tinymce' );
function TMCEPD_dropdown_add_tinymce() {
    global $typenow;
    
    // only on Post Type: post and page
    if( ! in_array( $typenow, array( 'page' ) ) )
        return;

    add_filter( 'mce_external_plugins', 'TMCEPD_dropdown_add_tinymce_plugin' );
    // Add to line 1 form WP TinyMCE
    add_filter( 'mce_buttons', 'TMCEPD_dropdown_add_tinymce_button' );
}

// inlcude the js for tinymce
function TMCEPD_dropdown_add_tinymce_plugin( $plugin_array ) {
    $plugin_array['TMCEPD_dropdown_button'] = plugins_url( '/TinyMCE-post-dropdown.js', __FILE__ );
	 // Print all plugin js path
    //var_dump( $plugin_array );
    return $plugin_array;
}

// Add the button key for address via JS
function TMCEPD_dropdown_add_tinymce_button( $buttons ) {

    array_push( $buttons, 'TMCEPD_dropdown_shortcode_key' );
    // Print all buttons
    //var_dump( $buttons );
    //query posts and then send to javascript.
    $query = new WP_Query( 'post_type=post', 'nopaging=true' );
    $params = array();
    foreach($query->posts as $post) {
		$params[] = array('ID' => $post->ID, 'post_title' => $post->post_title);
    }
    wp_register_script('TMCEPD_dropdown_button', plugins_url( '/TinyMCE-post-functions.js', __FILE__ ));
    wp_enqueue_script('TMCEPD_dropdown_button');
    wp_localize_script( 'TMCEPD_dropdown_button', 'dropDownParams', $params );
    return $buttons;
}
/*
TMCEPD_URL_dropdown_key
*/
//function to output shortcode
function TMCEPD_dropdown_display($atts) {
	@extract($atts);
	$postnumber;
	
	//get post contents
	$query = new WP_Query( "p=$postnumber", 'post_type=post', 'nopaging=true' );
	
	$title = $query->post->post_title;
	$content = $query->post->post_content;
	
	$tempLink = "<h2>$title</h2><span>$content</span>";
	
	return $tempLink;
}

add_shortcode('tinypost', 'TMCEPD_dropdown_display');
?>
