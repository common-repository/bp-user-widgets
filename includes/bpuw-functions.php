<?php

/*
BP User Widgets Functions

Text Domain: bp-user-widgets

*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// Load widget settings for user
function bpuw_get_widget_data( $displayed_user_id = '' ) {
	
	$widget_default_data = bpuw_get_defaults();
	
	if ( $displayed_user_id == '' ) {
	
		$displayed_user_id = bp_displayed_user_id();
		
	}
	
	$widget_data = get_user_meta( $displayed_user_id, 'bpuw_widget_data');

	// If first time access of the profile page, user settings need to be created
	if ( ! $widget_data ) {
		
		update_user_meta( $displayed_user_id, 'bpuw_widget_data', $widget_default_data );
		$widget_data = get_user_meta( $displayed_user_id, 'bpuw_widget_data');
		$widget_data = $widget_data[0];
		
	} else {
		
		$widget_data = array_merge ( $widget_default_data, $widget_data[0] );
		update_user_meta( $displayed_user_id, 'bpuw_widget_data', $widget_data );
		
	}
	
			
	
	return $widget_data;
	
}

// Establish global user defaults for user widgets
function bpuw_get_defaults() {
	
	$widget_default_data = Array (
		'video_1' => Array (
			'name' 			=> 'video_1',
			'title'			=> 'Video/Audio Player 1',
			'visibility'	=> 'none',
			'link'			=> '',
			'autoplay'		=> 0,
			'index' 		=> 1,
			'position' 		=> 1 ),
		'video_2' => Array (
			'name' 			=> 'video_2',
			'title'			=> 'Video/Audio Player 2',
			'visibility' 	=> 'none',
			'link'			=> '',
			'autoplay'		=> 0,
			'index' 		=> 2,
			'position' 		=> 2 ),
		'video_3' => Array (
			'name' 			=> 'video_3',
			'title'			=> 'Video/Audio Player 3',
			'visibility' 	=> 'none',
			'link'			=> '',
			'autoplay'		=> 0,
			'index' 		=> 3,
			'position' 		=> 3 ),
		'video_4' => Array (
			'name' 			=> 'video_4',
			'title'			=> 'Video/Audio Player 4',
			'visibility' 	=> 'none',
			'link'			=> '',
			'autoplay'		=> 0,
			'index' 		=> 4,
			'position' 		=> 4 ),
		'text_1' => Array (
			'name' 			=> 'text_1',
			'title'			=> 'Text Widget 1',
			'visibility' 	=> 'none',
			'content'		=> '',
			'index' 		=> 5,
			'position' 		=> 5 ),
		'text_2' => Array (
			'name' 			=> 'text_2',
			'title'			=> 'Text Widget 2',
			'visibility' 	=> 'none',
			'content'		=> '',
			'index' 		=> 6,
			'position' 		=> 6 ),
		'text_3' => Array (
			'name' 			=> 'text_3',
			'title'			=> 'Text Widget 3',
			'visibility' 	=> 'none',
			'content'		=> '',
			'index' 		=> 7,
			'position' 		=> 7 ),
		'text_4' => Array (
			'name' 			=> 'text_4',
			'title'			=> 'Text Widget 4',
			'visibility' 	=> 'none',
			'content'		=> '',
			'index' 		=> 8,
			'position' 		=> 8 ),
		'following' => Array (
			'name' 			=> 'following',
			'title'			=> 'Who I Follow',
			'visibility' 	=> 'none',
			'max_users'		=> 10,
			'index' 		=> 9,
			'position' 		=> 9 ),
		'followed' => Array (
			'name' 			=> 'followed',
			'title'			=> 'My Followers',
			'visibility' 	=> 'none',
			'max_users'		=> 10,
			'index' 		=> 10,
			'position' 		=> 10 ),
		'friends' => Array (
			'name' 			=> 'friends',
			'title'			=> 'My Friends',
			'visibility' 	=> 'none',
			'max_users'		=> 10,
			'index' 		=> 11,
			'position' 		=> 11 ),
		'groups' => Array (
			'name' 			=> 'groups',
			'title'			=> 'My Groups',
			'visibility' 	=> 'none',
			'max_groups'	=> 10,
			'index' 		=> 12,
			'position' 		=> 12 ),
		'posts' => Array (
			'name' 			=> 'posts',
			'title'			=> 'My Posts',
			'visibility' 	=> 'none',
			'max_posts'		=> 5,
			'img_size'		=> 150,
			'index' 		=> 13,
			'position' 		=> 13 )
	);

	$presets = get_option( 'bpuw_presets' );
	if ( isset( $presets ) && is_array( $presets ) ) {
		
		$presets = $presets[0];
		
	}
	
	if ( isset( $presets ) && is_array( $presets ) ) {
		
		return $presets;
		
	}

	
	return $widget_default_data;
	
}

function bpuw_get_widgets( $type ) {
	
	switch ( $type ) {
	
		case 'text' :
			$response = array( 'text_1', 'text_2', 'text_3', 'text_4' );
			break;

		case 'video' : 
			$response = array( 'video_1', 'video_2', 'video_3', 'video_4' );
			break;
		
		case 'follow' :
			$response = array ( 'followed', 'following' );
			break;
			
		case 'buddypress' :
			$response = array( 'friends', 'groups' );
			break;
			
		case 'wordpress' :
			$response = array( 'posts' );
			break;
	}
	
	return $response;
}

function bpuw_get_posts_output( $user_id, $max_posts, $img_size ) {
	
	$my_posts = get_posts( array( 
		'author' => $user_id, 
		'posts_per_page' => $max_posts
		) 
	);
	
	$showthumbnail = true;
	$width_image = $height_image = $img_size;
	
	if (count($my_posts) > 0) :
		?>
		<ul class="bpuw_my_posts">
		<?php foreach ( $my_posts as $my_post ) { ?>
			<li>
            <?php if($showthumbnail) : ?>
            <div class="author_left" style="width:<?php echo $width_image; ?>px;height:<?php echo $height_image; ?>px;">           
            <?php
			if( $showthumbnail ){
				if( has_post_thumbnail( $my_post->ID )){
				?>
                 <a href="<?php echo get_permalink( $my_post->ID ) ; ?>">
                <?php				
				echo get_the_post_thumbnail($my_post->ID, array($width_image,$height_image)); ?>				
                </a>
			<?php } }?>
            
            </div>
            <?php endif; ?>
            <div class="bpuw_my_posts_right">
            <a href="<?php echo get_permalink( $my_post->ID ) ; ?>">
            <?php			
            echo apply_filters( 'the_title', $my_post->post_title, $my_post->ID ); ?>
            </a>
            </div>
			</li>
		<?php } ?>
		</ul>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();		
		endif ;	
	
}

// Get oembed Iframe for videos
function bpuw_get_video_content( $user_id, $url, $name, $width )	{
	$width = (int)$width;
	$service = $multiplier = $height = $control = '';

	$user_settings = get_user_meta( $user_id, 'bpuw_widget_data' );
	$user_settings = $user_settings[0];
	$autoplay = $user_settings[$name]['autoplay'];

	// Determine the height from the width in the Widget options

	$multiplier = .75; 
	
	if ( !empty( $width ) && !empty( $multiplier ) ) {
		
		if ( !empty( $url ) ) {

			$host 		= parse_url( $url, PHP_URL_HOST );
			$exp		= explode( '.', $host );
			$service 	= ( count( $exp ) >= 3 ? $exp[1] : $exp[0] );
			
		 } // End of $url check
			
		$control 	= ( $service == 'youtube' || $service == 'youtu' ? 25 : 0 );
		$height 	= ( ( $width * $multiplier ) + $control );
	
	
	} // End of empty checks

	if ( empty( $url ) || empty( $service ) ) {

	} else {

		$oembed = bpuw_oembed_transient( $url, $service, $width, $height );

		if ( !$oembed && $service == 'facebook' ) {
		
			// Input Example: https://www.facebook.com/photo.php?v=10201027508430408

			$explode = explode( '=', $url );
			$videoID = end( $explode );


			?><iframe src="https://www.facebook.com/video/embed?video_id=<?php echo $videoID; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" frameborder="0"></iframe><?php
					
		} else if ( ( !$oembed && $service == 'youtube' ) || ( !$oembed && $service == 'youtu' ) ) {
		
			// Input Example: https://www.facebook.com/photo.php?v=10201027508430408

			$explode = explode( '=', $url );
			$videoID = end( $explode );


			?><iframe width='<?php echo $width; ?>' height='<?php echo $height; ?>' src='//www.youtube.com/embed/<?php echo $videoID; ?>?autoplay=<?php echo $autoplay; ?>&loop=0&rel=0' frameborder='0' allowfullscreen></iframe><?php
					
		} else {

			// Input Examples: 
			// 		http://www.youtube.com/watch?v=YYYJTlOYdm0
			// 		http://youtu.be/YYYJTlOYdm0
			// 		https://vimeo.com/37708663
			// 		http://www.flickr.com/photos/riotking/2550468661
			// 		http://blip.tv/juliansmithtv/julian-smith-lottery-6362952
			// 		http://www.dailymotion.com/video/xull3h_monster-roll_shortfilms
			// 		http://www.ustream.tv/channel/3777978
			// 		http://www.ustream.tv/recorded/32219761
			// 		http://www.funnyordie.com/videos/5764ccf637/daft-punk-andrew-the-pizza-guy?playlist=featured_videos
			// 		http://www.hulu.com/watch/486928
			// 		http://revision3.com/destructoid/bl2-dlc-leak-tiny-tinas-assault-on-dragon-keep
			// 		http://www.viddler.com/v/bdce8c7
			// 		http://qik.com/video/38782012
			// 		http://home.wistia.com/medias/e4a27b971d
			// 		http://wordpress.tv/2013/10/26/chris-wilcoxson-how-to-build-your-first-widget/
	
			echo $oembed;

		} // End of embed codes

	} // End of $url & $service check
	
}

function bpuw_oembed_transient( $url, $service = '', $width = '', $height = '' ) {

	//require_once( ABSPATH . WPINC . '/class-oembed.php' );

	if ( empty( $url ) ) { return FALSE; }

	$key 	= md5( $url );
	//$oembed = get_transient( 'bpuw_' . $key );

	if ( $url ) {

		$oembed = wp_oembed_get( $url, array( 'width' => $width, 'height' => $height ) );

		if ( !$oembed ) { return FALSE; }

		//set_transient( 'bpuw_' . $key, $oembed, HOUR_IN_SECONDS );

	}

	return $oembed;

} // End of oembed_transient()

// Get friends widget output
function bpuw_get_friends_output( $user_id, $max_users ) {

	if ( empty( $max_users ) ) {
		$max_users = 10;
	}
	if ( empty( $user_id ) ) {
		$user_id = bp_displayed_user_id();
	}
	// logged-in user isn't following anyone, so stop!
	if ( ! $friends = friends_get_friend_user_ids( $user_id ) ) {
		return false;
	}

	// show the users the logged-in user is following
	if ( bp_has_members( array(
		'user_id'         => $user_id,
		'type'            => 'active',
		'include'         => $friends,
		'max'             => $max_users,
		'populate_extras' => 1,
	) ) ) {

?>

		<div class="avatar-block">
			<?php while ( bp_members() ) : bp_the_member(); ?>
				<div class="item-avatar">
					<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name() ?>"><?php bp_member_avatar() ?></a>
				</div>
			<?php endwhile; ?>
		</div>

<?php
	}
}

// Get following widget output
function bpuw_get_following_output( $user_id, $max_users ) {

	if ( empty( $max_users ) ) {
		$max_users = 16;
	}
	if ( empty( $user_id ) ) {
		$user_id = bp_displayed_user_id();
	}
	// logged-in user isn't following anyone, so stop!
	if ( ! $following = bp_get_following_ids( array( 'user_id' => $user_id ) ) ) {
		return false;
	}

	// show the users the logged-in user is following
	if ( bp_has_members( array(
		'include'         => $following,
		'max'             => $max_users,
		'populate_extras' => false,
	) ) ) {

?>

		<div class="avatar-block">
			<?php while ( bp_members() ) : bp_the_member(); ?>
				<div class="item-avatar">
					<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name() ?>"><?php bp_member_avatar() ?></a>
				</div>
			<?php endwhile; ?>
		</div>

<?php
	}
}

// Get followers widget output
function bpuw_get_followers_output( $user_id, $max_users ) {

	if ( empty( $max_users ) ) {
		$max_users = 16;
	}
	
	if ( empty( $user_id ) ) {
		$user_id = bp_displayed_user_id();
	}
	// logged-in user isn't following anyone, so stop!
	if ( ! $followers = bp_get_follower_ids( array( 'user_id' => $user_id ) ) ) {
		return false;
	}

	// show the users the logged-in user is following
	if ( bp_has_members( array(
		'include'         => $followers,
		'max'             => $max_users,
		'populate_extras' => false,
	) ) ) {

?>

		<div class="avatar-block">
			<?php while ( bp_members() ) : bp_the_member(); ?>
				<div class="item-avatar">
					<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name() ?>"><?php bp_member_avatar() ?></a>
				</div>
			<?php endwhile; ?>
		</div>

<?php
	}
}

function bpuw_get_groups_output( $user_id, $max_groups, $per_page){

	if ( empty( $user_id ) ) {
		$user_id = bp_displayed_user_id();
	}

	if ( empty( $max_groups ) ) {
		$max_groups = 20;
	}
	
	$type = 'active';
	$limit = $max_groups;
	
	$group_args = array(
		'user_id'  => $user_id,
		'type'     => 'active',
		//'order'    => $instance['order'],
		'per_page' => $per_page,
		'max'      => $max_groups,
	);

	?>

	<?php if ( bp_has_groups( $group_args ) ) : ?>

		<div class="avatar-block">
			<?php while ( bp_groups() ) : bp_the_group(); ?>
				<div class="item-avatar">
					<a href="<?php bp_group_permalink() ?>"
						   title="<?php bp_group_name() ?>"><?php bp_group_avatar_thumb() ?></a>
				</div>
			<?php endwhile; ?>
		</div>

		<?php wp_nonce_field( 'groups_widget_groups_list', '_wpnonce-groups' ); ?>

		<input type="hidden" name="groups_widget_max" id="groups_widget_max" value="<?php echo esc_attr( $limit ); ?>"/>

	<?php else: ?>

		<div class="widget-error">

			<?php _e( 'There are no groups to display.', 'bp-extended-user-groups-widget' ) ?>

		</div>

	<?php endif;	
	
}

// Add Privacy functions
// Suggested content
function bpuw_add_privacy_policy_content() {
    if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
        return;
    }
 
    $content = sprintf(
        __( '<h3>Profile Widgets Data</h3>
		<p>When a user saves their text or video widgets, this may contain personal data so this data should be included in your privacy policy.</p>
		<p><b>Suggested Text: </b>When you add custom widgets to your profile, it\'s possible that this may include personal information. This site will store that information until you either clear the widgets or leave the site.</p>',
        'bp-user-widgets' )
    );
 
    wp_add_privacy_policy_content(
        'BP User Widgets Plugin',
        wp_kses_post( wpautop( $content, false ) )
    );
}
add_action( 'admin_init', 'bpuw_add_privacy_policy_content' );	


//Personal data exporter functions
function bpuw_exporter( $email_address, $page = 1 ) {

	$email_address = trim( $email_address );

	$user = get_user_by( 'email', $email_address );

	if ( ! $user ) {
		return array(
			'data' => array(),
			'done' => true,
		);
	}

	$widget_defaults = bpuw_get_defaults();
	
	$user_widgets = get_user_meta( $user->ID, 'bpuw_widget_data');
	$user_widgets = $user_widgets[0];
	$text_widgets = bpuw_get_widgets( 'text' );
	$video_widgets = bpuw_get_widgets( 'video' );
	
	
	if ( $user_widgets == $widget_defaults ) {
		return array(
			'data' => array(),
			'done' => true,
		);
	}

	$export_items = array();
	$index = 1;
 
	foreach ( (array) $user_widgets as $widget ) {
		if ( in_array( $widget['name'],$text_widgets ) || in_array( $widget['name'],$video_widgets ) ) {
			if ( $widget['visibility'] != 'none' ) {
				$item_id = $index;
				$index = $index + 1;
				$group_id = 'bp_user_widgets';
				$group_label = __( 'User Widgets' );
				if ( in_array( $widget['name'],$text_widgets ) ) {
					$content = $widget['content'];
				}
				if ( in_array( $widget['name'],$video_widgets ) ) {
					$content = $widget['link'];
				}
				$data = array(
					array(
						'name' => __( 'Widget Title' ),
						'value' => $widget['title']
					),
					array(
						'name' => __( 'Widget Content' ),
						'value' => $content
					)
				);
		 
				$export_items[] = array(
					'group_id' => $group_id,
					'group_label' => $group_label,
					'item_id' => $item_id,
					'data' => $data,
				);
			}
		}
    }

	if ( empty( $export_items ) ) {
		return array(
			'data' => array(),
			'done' => true,
		);
	}

	return array(
		'data' => $export_items,
		'done' => true,
	);
}

function register_bpuw_exporter( $exporters ) {
	$exporters['bp-user-widgets'] = array(
		'exporter_friendly_name' => __( 'BP User Widgets Plugin' ),
		'callback' => 'bpuw_exporter',
	);
	return $exporters;
}
 
add_filter(	'wp_privacy_personal_data_exporters', 'register_bpuw_exporter', 10 );


// Personal data eraser functions
function bpuw_eraser( $email_address, $page = 1 ) {

	$email_address = trim( $email_address );

	$user = get_user_by( 'email', $email_address );

	if ( ! $user ) {
		return array(
			'items_retained' => false,
			'messages' => array(),
			'done' => true,
		);
	}

	$done = delete_user_meta( $user->ID, 'bpuw_widget_data');

	return array( 'items_removed' => $items_removed,
		'items_retained' => false,
		'messages' => array(),
		'done' => $done,
	);
}

function register_bpuw_eraser( $erasers ) {
	$erasers['bp-user-widgets'] = array(
		'eraser_friendly_name' => __( 'BP User Widgets Plugin' ),
		'callback'             => 'bpuw_eraser',
    );
	return $erasers;
}
 
add_filter( 'wp_privacy_personal_data_erasers', 'register_bpuw_eraser', 10 );
?>