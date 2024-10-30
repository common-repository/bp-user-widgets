<?php

/*
Plugin Name: BP User Widgets
Plugin URI: https://buddyuser.com/plugin-bp-user-widgets
Description: BP User Widgets adds user customizable widgets to the BP User pages, allowing users to create photo, video, gallery widgets specific to their user pages. This plugin requires BuddyPress and for the theme to have at least one sidebar.
Version: 1.0.8
Text Domain: bp-user-widgets
Domain Path: /langs
Author: Venutius
Author URI: https://buddyuser.com
License: GPLv2

**************************************************************************

  Copyright (C) 2024 BuddyPress User

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General License for more details.

  You should have received a copy of the GNU General License
  along with this program.  If not, see <https://www.gnu.org/licenses/>.

**************************************************************************

*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bpuw_enqueue_scripts() {
	wp_register_script( 'bpuw-translation', plugins_url( 'js/bpuw-fronntend.js', __FILE__ ), array( 'jquery' ) );
	
	$translation_array = array(
		'video_1'				=> sanitize_text_field(__( 'Video/Audio 1', 'bp-user-widgets') ),
		'video_2'				=> sanitize_text_field(__( 'Video/Audio 2', 'bp-user-widgets') ),
		'video_3'				=> sanitize_text_field(__( 'Video/Audio 3', 'bp-user-widgets') ),
		'video_4'				=> sanitize_text_field(__( 'Video/Audio 4', 'bp-user-widgets') ),
		'text_1'				=> sanitize_text_field(__( 'Text 1', 'bp-user-widgets') ),
		'text_2'				=> sanitize_text_field(__( 'Text 2', 'bp-user-widgets') ),
		'text_3'				=> sanitize_text_field(__( 'Text 3', 'bp-user-widgets') ),
		'text_4'				=> sanitize_text_field(__( 'Text 4', 'bp-user-widgets') ),
		'followed'				=> sanitize_text_field(__( 'Followed', 'bp-user-widgets') ),
		'following'				=> sanitize_text_field(__( 'Following', 'bp-user-widgets') ),
		'friends'				=> sanitize_text_field(__( 'My Friends', 'bp-user-widgets') ),
		'groups'				=> sanitize_text_field(__( 'My Groups', 'bp-user-widgets') ),
		'resetWidget'			=> sanitize_text_field( __( 'Resetting to defaults...', 'bp-user-widgets' ) ),
		'submit'				=> sanitize_text_field( __( 'Submit', 'bp-user-widgets' ) ),
		'add'					=> sanitize_text_field( __( 'Add Widget', 'bp-user-widgets' ) ),
		'change' 				=> sanitize_text_field( __( 'Change', 'bp-user-widgets' ) ),
		'cancel'				=> sanitize_text_field( __( 'Cancel', 'bp-user-widgets' ) ),
		'success'				=> sanitize_text_field( __( 'Success!', 'bp-user-widgets' ) ),
		'successRefresh'		=> sanitize_text_field( __( 'Success! Please refresh the window to see.', 'bp-user-widgets' ) ),
		'tryAgain'				=> sanitize_text_field( __( 'Please try again...', 'bp-user-widgets' ) ),
		'enterVideo'			=> sanitize_text_field( __( 'Please paste a URL', 'bp-user-widgets' ) ),
		'addingVideo'			=> sanitize_text_field( __( 'Adding Video ...', 'bp-user-widgets' ) ),
		'addingFriends'			=> sanitize_text_field( __( 'Adding Friends ...', 'bp-user-widgets' ) ),
		'addingGroups'			=> sanitize_text_field( __( 'Adding Groups ...', 'bp-user-widgets' ) ),
		'addingPosts'			=> sanitize_text_field( __( 'Adding Posts ...', 'bp-user-widgets' ) ),
		'addingFollowing'		=> sanitize_text_field( __( 'Adding Following ...', 'bp-user-widgets' ) ),
		'addingFollowers'		=> sanitize_text_field( __( 'Adding Followers ...', 'bp-user-widgets' ) ),
		'addingVideo'			=> sanitize_text_field( __( 'Adding Video ...', 'bp-user-widgets' ) ),
		'deleting'				=> sanitize_text_field( __( 'Deleting...', 'bp-user-widgets' ) ),
		'clearPreset'			=> sanitize_text_field(__( 'Clear Preset', 'bp-user-widgets' ) ),
		'savePreset'			=> sanitize_text_field(__( 'Save as Preset', 'bp-user-widgets' ) ),
		'clearingPreset'		=> sanitize_text_field(__( 'Clearing Preset...', 'bp-user-widgets' ) ),
		'savingPreset'			=> sanitize_text_field(__( 'Saving as Preset...', 'bp-user-widgets' ) ),
		'addingText'			=> sanitize_text_field( __( 'Adding Text ...', 'bp-user-widgets' ) )
		);
	
	wp_localize_script( 'bpuw-translation', 'bpuw_translate', $translation_array );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-widget' );
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'jquery-ui-draggable' );
    wp_enqueue_script( 'jquery-ui-droppable' );
	wp_enqueue_script( 'bpuw-translation');

	wp_localize_script( 'bpuw-translation', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php'), 'check_nonce' => wp_create_nonce('bpuw-nonce') ) );
	wp_enqueue_style( 'bpuw_style', plugins_url( 'vendor/jquery/jquery-ui.css', __FILE__ ) );
	wp_enqueue_style( 'bpuw_style', plugin_dir_path( 'css/bpuw.css', __FILE__) );

}
add_action( 'wp_enqueue_scripts', 'bpuw_enqueue_scripts' );

// Localization
function bpuw_localization() {

load_plugin_textdomain('bp-user-widgets', false, dirname(plugin_basename( __FILE__ ) ).'/langs/' );

}
 
add_action('init', 'bpuw_localization');

// Load Ajax

include_once( plugin_dir_path(__FILE__) . '/includes/bpuw-ajax.php' );

// Load Widget Class

include_once( plugin_dir_path(__FILE__) . '/includes/bpuw-widget-class.php' );

// Load Functions

include_once( plugin_dir_path(__FILE__) . '/includes/bpuw-functions.php' );

// Register Widget

function wppwu_register_widget() {
	
	register_widget( 'BP_User_Widgets' );
	
}

add_action( 'widgets_init', 'wppwu_register_widget' );


?>