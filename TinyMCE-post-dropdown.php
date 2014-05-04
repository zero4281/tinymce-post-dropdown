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
 
function TMCEBB_dropdown_css() {
	wp_enqueue_style('TMCEBB_dropdown_css', plugins_url('/style.css', __FILE__));
	wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js');
	wp_enqueue_script( 'jquery' );
}

add_action('admin_enqueue_scripts', 'TMCEBB_dropdown_css');
add_action('admin_enqueue_scripts', 'jquery');

add_action( 'admin_head', 'TMCEBB_dropdown_add_tinymce' );
function TMCEBB_dropdown_add_tinymce() {
    global $typenow;
    
    // only on Post Type: post and page
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;

    add_filter( 'mce_external_plugins', 'TMCEBB_dropdown_add_tinymce_plugin' );
    // Add to line 1 form WP TinyMCE
    add_filter( 'mce_buttons', 'TMCEBB_dropdown_add_tinymce_button' );
}

// inlcude the js for tinymce
function TMCEBB_dropdown_add_tinymce_plugin( $plugin_array ) {
    $plugin_array['TMCEBB_dropdown_button'] = plugins_url( '/TinyMCE-post-dropdown.js', __FILE__ );
	 // Print all plugin js path
    //var_dump( $plugin_array );
    return $plugin_array;
}

// Add the button key for address via JS
function TMCEBB_dropdown_add_tinymce_button( $buttons ) {

    array_push( $buttons, 'TMCEBB_dropdown_shortcode_key' );
    // Print all buttons
    //var_dump( $buttons );
    //query posts and then send to javascript.
    $query = new WP_Query( 'post_type=post', 'nopaging=true' );
    $params = array();
    foreach($query->posts as $post) {
		$params[] = array('ID' => $post->ID, 'post_title' => $post->post_title);
    }
    wp_register_script('TMCEBB_dropdown_button', plugins_url( '/TinyMCE-post-functions.js', __FILE__ ));
    wp_enqueue_script('TMCEBB_dropdown_button');
    wp_localize_script( 'TMCEBB_dropdown_button', 'dropDownParams', $params );
    return $buttons;
}
/*
TMCEBB_URL_dropdown_key
*/
//function to output shortcode
function TMCEBB_dropdown_display_link($atts) {
	@extract($atts);
	$postnumber;
	//get post
	$post = get_post($postnumber);
	//var_dump($post);
	$tempLink = "<h2>$post->post_title</h2><span>$post->post_content</span>";
	
	return $tempLink;
}

add_shortcode('dropdown', 'TMCEBB_dropdown_display_link');
?>