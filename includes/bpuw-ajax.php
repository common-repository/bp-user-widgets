<?php
/*
* @package bp-user-widgets
*/

if(!defined('ABSPATH')) {
	exit;
}


//AJAX add video
function bpuw_moveable_widgets() {
	
	wp_verify_nonce( $_POST['security'], 'bpuw-nonce');
	
	$widget_positions = $_POST['positions'];

	if ( ! is_array( $widget_positions ) || empty( $widget_positions ) ) {
		
		echo 'Input data incorrect';
		die();
		
	}

	$user_id = get_current_user_id();
	
	if ( bp_loggedin_user_id() != $user_id ) {
		
		echo esc_attr( __( 'Not correct user', 'bp-user-widgets' ) );
		die();
		
	}
	$old_widget_data = get_user_meta( $user_id, 'bpuw_widget_data' );
	$old_widget_data = $old_widget_data[0];
	$widgets = array( 'video_1', 'video_2', 'video_3', 'video_4', 'text_1', 'text_2', 'text_3', 'text_4', 'groups', 'friends', 'followed', 'following', 'posts,' );
	foreach ( $widget_positions as $widget ) {
		$widget_name = sanitize_text_field($widget[0]);
		$widget_position = sanitize_text_field($widget[1]);
		if ( in_array ( $widget_name, $widgets ) ) {
			$old_widget_data[$widget_name]['position'] = $widget_position;
		}
	}
	
	$update = update_user_meta( $user_id, 'bpuw_widget_data', $old_widget_data );
	
	if ( $update ) {
		
		echo 'Success';
	
	} else {
		
		echo 'Failed';
	
	}

	die();

}

add_action( 'wp_ajax_bpuw_moveable_widgets', 'bpuw_moveable_widgets');

function bpuw_reset_widget() {
	
	wp_verify_nonce( $_POST['security'], 'bpuw-nonce');
	
	$user_id = (int) sanitize_text_field($_POST['userId']);
	
	$widget_defaults = bpuw_get_defaults();

	if ( bp_loggedin_user_id() != $user_id ) {
		
		echo esc_attr( __( 'Not correct user', 'bp-user-widgets' ) );
		die();
		
	}
	
	if ( isset( $user_id ) && is_numeric( $user_id ) ) {
		
		update_user_meta( $user_id, 'bpuw_widget_data', $widget_defaults );
		$update = 1;
		
	} else {
		
		$update = 0;
		
	}

	echo $update;

	die();

}

add_action( 'wp_ajax_bpuw_reset_widget', 'bpuw_reset_widget');

// Clear widget
function bpuw_clear_widget() {
	
	wp_verify_nonce( $_POST['security'], 'bpuw-nonce');
	
	$user_id = (int) sanitize_text_field($_POST['userId']);
	$widget_name = sanitize_text_field($_POST['name']);
	
	$old_widget_data = get_user_meta( $user_id, 'bpuw_widget_data' );
	$old_widget_data = $old_widget_data[0];
	
	$defaults = bpuw_get_defaults();

	if ( bp_loggedin_user_id() != $user_id ) {
		
		return;
		die();
		
	}
	
	if ( isset( $user_id ) && is_numeric( $user_id ) && isset( $widget_name ) ) {
		$video_widgets = bpuw_get_widgets( 'video');
		$text_widgets = bpuw_get_widgets( 'text');
		$follow_widgets = bpuw_get_widgets( 'follow');
		$buddypress_widgets = bpuw_get_widgets( 'buddypress');
		$wordpress_widgets = bpuw_get_widgets( 'wordpress');
		if ( in_array ( $widget_name, $video_widgets ) ) {
			$old_widget_data[$widget_name]['autoplay'] = 0;
			$old_widget_data[$widget_name]['link'] = '';
			$old_widget_data[$widget_name]['title'] = $defaults[$widget_name]['title'];
			$old_widget_data[$widget_name]['visibility'] = 'none';
			$update = update_user_meta( $user_id, 'bpuw_widget_data', $old_widget_data );
		} else if ( in_array( $widget_name, $text_widgets ) ) {
			$old_widget_data[$widget_name]['content'] = '';
			$old_widget_data[$widget_name]['visibility'] = 'none';
			$old_widget_data[$widget_name]['title'] = $defaults[$widget_name]['title'];
			$update = update_user_meta( $user_id, 'bpuw_widget_data', $old_widget_data );
		} else if ( in_array( $widget_name, $follow_widgets ) ) {
			$old_widget_data[$widget_name]['visibility'] = 'none';
			$old_widget_data[$widget_name]['title'] = $defaults[$widget_name]['title'];
			$update = update_user_meta( $user_id, 'bpuw_widget_data', $old_widget_data );
		} else if ( in_array( $widget_name, $buddypress_widgets ) ) {
			$old_widget_data[$widget_name]['visibility'] = 'none';
			$old_widget_data[$widget_name]['title'] = $defaults[$widget_name]['title'];
			$update = update_user_meta( $user_id, 'bpuw_widget_data', $old_widget_data );
		} else if ( in_array( $widget_name, $wordpress_widgets ) ) {
			$old_widget_data[$widget_name]['visibility'] = 'none';
			$old_widget_data[$widget_name]['title'] = $defaults[$widget_name]['title'];
			$old_widget_data[$widget_name]['img_size'] = $defaults[$widget_name]['img_size'];
			$old_widget_data[$widget_name]['max_posts'] = $defaults[$widget_name]['max_posts'];
			$update = update_user_meta( $user_id, 'bpuw_widget_data', $old_widget_data );
		}
		
	} else {
		
		$update = 0;
		
	}

	echo $update;

	die();

}

add_action( 'wp_ajax_bpuw_clear_widget', 'bpuw_clear_widget');

//AJAX add video
function bpuw_add_video() {
	
	wp_verify_nonce( $_POST['security'], 'bpuw-nonce');
	
	global $bp, $bpuw_video_width;
	
	$user_id = sanitize_text_field($_POST['userId']);
	$widget_name = sanitize_text_field($_POST['name']);
	$video_url = esc_url_raw($_POST['videoURL']);
	$widget_title = sanitize_text_field($_POST['title']);
	
	if ( bp_loggedin_user_id() != $user_id ) {
		
		return;
		die();
		
	}
	
	$old_widget_data = get_user_meta( $user_id, 'bpuw_widget_data' );
	$old_widget_data = $old_widget_data[0];

	if ( isset( $user_id ) && is_numeric( $user_id ) && isset( $widget_name ) && isset( $video_url ) && bpuw_check_url( $video_url ) ) {
		
		$old_widget_data[$widget_name]['link'] = $video_url;
		$old_widget_data[$widget_name]['title'] = $widget_title;
		$old_widget_data[$widget_name]['visibility'] = 'block';
		$update = update_user_meta( $user_id, 'bpuw_widget_data', $old_widget_data );
		
	} else {
		
		$update = 0;
		
	}
	
	if ( $update ) {
		$width = get_option ( 'bpuw_widget_options' );
		$output = bpuw_get_video_content( $user_id, $video_url, $widget_name, $width );
	} else {
		$output = esc_attr( __( 'Video not saved', 'bp-user-widgets' ) );
	}

	echo $output;

	die();

}

add_action( 'wp_ajax_bpuw_add_video', 'bpuw_add_video');

//AJAX add text and make clickable
function bpuw_add_text() {
	
	wp_verify_nonce( $_POST['security'], 'bpuw-nonce');
	
	global $bp;
	
	$user_id = sanitize_text_field($_POST['userId']);
	$widget_name = sanitize_text_field($_POST['name']);
	$widget_title = sanitize_text_field($_POST['title']);
	$text_content = wp_filter_post_kses( $_POST['content'] );
	$text_content = nl2br( make_clickable( $text_content ) );
	$old_widget_data = get_user_meta( $user_id, 'bpuw_widget_data' );
	$old_widget_data = $old_widget_data[0];

	if ( bp_loggedin_user_id() != $user_id ) {
		
		return;
		die();
		
	}

	if ( isset( $user_id ) && is_numeric( $user_id ) && isset( $widget_name ) && isset( $text_content ) ) {
		
		$old_widget_data[$widget_name]['content'] = $text_content;
		$old_widget_data[$widget_name]['title'] = $widget_title;
		$old_widget_data[$widget_name]['visibility'] = 'block';
		$update = update_user_meta( $user_id, 'bpuw_widget_data', $old_widget_data );
		
	} else {
		
		$update = 0;
		
	}

	if ( $update ) {
		$output = do_shortcode( $text_content ); 
	} else {
		$output = '';
	}

	echo $output;

	die();

}

add_action( 'wp_ajax_bpuw_add_text', 'bpuw_add_text');

//AJAX add text and make clickable
function bpuw_add_follow() {
	
	wp_verify_nonce( $_POST['security'], 'bpuw-nonce');
	
	$user_id = sanitize_text_field($_POST['userId']);
	$widget_name = sanitize_text_field($_POST['name']);
	$widget_title = sanitize_text_field($_POST['title']);
	$max = sanitize_text_field( $_POST['max'] );
	$img_size = sanitize_text_field( $_POST['imgSize'] );

	if ( bp_loggedin_user_id() != $user_id ) {
		
		return;
		die();
		
	}

	$old_widget_data = get_user_meta( $user_id, 'bpuw_widget_data' );
	$old_widget_data = $old_widget_data[0];

	if ( isset( $user_id ) && is_numeric( $user_id ) && isset( $widget_name ) ) {
		
		if ( $widget_name == 'following' || $widget_name == 'followed' || $widget_name == 'friends' ) {
			$old_widget_data[$widget_name]['max_users'] = $max;
		} else if ( $widget_name == 'groups' ) {
			$old_widget_data[$widget_name]['max_groups'] = $max;
		} else if ( $widget_name == 'posts' ) {
			$old_widget_data[$widget_name]['max_posts'] = $max;
			$old_widget_data[$widget_name]['img_size'] = $img_size;
		}
		$old_widget_data[$widget_name]['title'] = $widget_title;
		$old_widget_data[$widget_name]['visibility'] = 'block';
		$update = update_user_meta( $user_id, 'bpuw_widget_data', $old_widget_data );
		
	} else {
		
		$update = 0;
		
	}

	if ( $update && $widget_name == 'following') {
		$output = bpuw_get_following_output( $user_id, $max ); 
	} else if ( $update && $widget_name == 'followed') {
		$output = bpuw_get_followers_output( $user_id, $max ); 
	} else if ( $update && $widget_name == 'friends') {
		$output = bpuw_get_friends_output( $user_id, $max ); 
	} else if ( $update && $widget_name == 'groups') {
		$output = bpuw_get_groups_output( $user_id, $max, 10 ); 
	} else if ( $update && $widget_name == 'posts') {
		$output = bpuw_get_posts_output( $user_id, $max, $img_size ); 
	} else {
		$output = 0;
	}

	echo $output;

	die();

}

add_action( 'wp_ajax_bpuw_add_follow', 'bpuw_add_follow');

// Clear text
function bpuw_clear_text() {
	
	wp_verify_nonce( $_POST['security'], 'bpuw-nonce');
	
	$user_id = (int) sanitize_text_field($_POST['userId']);
	$widget_name = sanitize_text_field($_POST['name']);
	
	$old_widget_data = get_user_meta( $user_id, 'bpuw_widget_data' );
	$old_widget_data = $old_widget_data[0];

	$defaults = bpuw_get_defaults();

	if ( bp_loggedin_user_id() != $user_id ) {
		
		return;
		die();
		
	}
	
	if ( isset( $user_id ) && is_numeric( $user_id ) && isset( $widget_name ) ) {
		
		$old_widget_data[$widget_name]['content'] = '';
		$old_widget_data[$widget_name]['visibility'] = 'none';
		$old_widget_data[$widget_name]['title'] = $defaults[$widget_name]['title'];
		$update = update_user_meta( $user_id, 'bpuw_widget_data', $old_widget_data );
		
	} else {
		
		$update = 0;
		
	}

	echo $update;

	die();

}

add_action( 'wp_ajax_bpuw_clear_text', 'bpuw_clear_widget');


//Check submitted URL for correct formatting
function bpuw_check_url( $url ) {
	
    $path = parse_url($url, PHP_URL_PATH);
    $encoded_path = array_map('urlencode', explode('/', $path));
    $url = str_replace($path, implode('/', $encoded_path), $url);

    return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
}

function bpuw_update_presets() {
	
	wp_verify_nonce( $_POST['security'], 'bpuw-nonce');
	$action = sanitize_text_field( $_POST['update'] );
	
	if ( isset( $action ) && $action === 'save' ) {
		if ( current_user_can( 'manage_options' ) ) {
			
			$user_id = bp_loggedin_user_id();
			$presets = get_user_meta( $user_id, 'bpuw_widget_data');
			update_option( 'bpuw_presets', $presets );
			echo 1;
			die();
		
		}
	
	} else if ( isset( $action ) && $action === 'clear' ) {
		
		if ( current_user_can( 'manage_options' ) ) {
			
			delete_option( 'bpuw_presets' );
			echo 1;
			die();
		
		}
	
	}
	
	echo 0;
	die();
	
}

add_action( 'wp_ajax_bpuw_update_presets', 'bpuw_update_presets');
