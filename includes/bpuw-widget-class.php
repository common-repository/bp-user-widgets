<?php


global $bpuw_video_width;

class BP_User_Widgets extends WP_Widget {



	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'bp_user_widgets',
			'description' => sanitize_text_field(__( 'Adds user sortable and selectable widgets to BP user pages', 'bp-user-widgets' ) ),
		);
		parent::__construct( 'bp_user_widgets', sanitize_text_field( __( 'BP User Widgets', 'bp-user-widgets' ) ), $widget_ops );
		global $bpuw_video_width;
	}


	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		$logged_in_user_id = bp_loggedin_user_id();
		$displayed_user_id = bp_displayed_user_id();
		$title_text = sanitize_text_field( __( 'Title:', 'bp-user-widgets' ) );
		$video_widgets = bpuw_get_widgets( 'video' );
		$text_widgets = bpuw_get_widgets( 'text' );
		$follow_widgets = bpuw_get_widgets( 'follow' );
		$wordpress_widgets = bpuw_get_widgets( 'wordpress' );
		$buddypress_widgets = bpuw_get_widgets( 'buddypress' );
		$displayed = 0;
		$presets = get_option( 'bpuw_presets' );
		
		if ( bp_is_user_profile() || bp_is_user_activity() || bp_is_user() ) {
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] && $logged_in_user_id == $displayed_user_id ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			}
			

			$widget_data = bpuw_get_widget_data( $displayed_user_id );
			
			echo '<ul id="sortable-uw">';
			
			For ( $n = 1; $n <= 13; $n++ ) {
				foreach ( $widget_data as $widget ) {
					
					if ( $widget['position'] == $n ) {
						if ( ( in_array( $widget['name'], $wordpress_widgets ) && ! isset( $instance['disable_wordpress'] ) ) || ( in_array( $widget['name'], $video_widgets ) && ! $instance['disable_videos'] ) ||  ( in_array( $widget['name'], $text_widgets ) && ! $instance['disable_text'] ) || ( in_array( $widget['name'], $follow_widgets ) && ! $instance['disable_follow'] && function_exists( 'bp_follow_start_following' ) ) || ( $widget['name'] == 'groups' && ! $instance['disable_buddypress'] && bp_is_active( 'groups' ) ) || ( $widget['name'] == 'friends' && ! $instance['disable_buddypress'] && bp_is_active( 'friends' ) ) ) {
							
							// Create widget structure
							echo '<li id="bpuw_' . $widget['name'] . '" data-name="' . $widget['name'] . '" data-position="' . $widget['position'] . '" data-index="' . $widget['index'] . '" style="display: ' . $widget['visibility'] . '; text-align: left;" class="bpuw_li_class "><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>';
							
							echo '<h3 style="text-align: center;" id="bpuw_desc_' . $widget['name'] . '">' . $widget['title'] . '</h3>';
							
							// Display widget content
							// Video Widget
							if ( in_array( $widget['name'], $video_widgets ) ) {
								echo '<div id="bpuw_display_' . $widget['name'] . '" >';
								if( $widget['link'] != '' ) {
									echo '<div class="bpuw-video-wrapper">';
									bpuw_get_video_content( $displayed_user_id, $widget['link'], $widget['name'], $instance['width'] );
									echo '</div>';
									$displayed = 1;
								}
								echo '</div>';
							}
							// Text Widget
							if ( in_array( $widget['name'], $text_widgets ) ) {
								echo '<div id="bpuw_display_' . $widget['name'] . '" class="bpuw-text-widget" data-name="' . $widget['name'] . '">';
								if( $widget['content'] != '' ) {
									echo do_shortcode( $widget['content'] );
									$displayed = 1;
								}
								echo '</div>';
							}
							// Followed Widget
							if ( $widget['name'] == 'followed' ) {
								echo '<div id="bpuw_display_' . $widget['name'] . '" class="bpuw-followed-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpuw_get_followers_output( $displayed_user_id, $widget['max_users'] );
									$displayed = 1;
								}
								echo '</div>';
							}
							// Following Widget
							if ( $widget['name'] == 'following' ) {
								echo '<div id="bpuw_display_' . $widget['name'] . '" class="bpuw-following-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpuw_get_following_output( $displayed_user_id, $widget['max_users'] );
									$displayed = 1;
								}
								echo '</div>';
							}
							// Friends Widget
							if ( $widget['name'] == 'friends' ) {
								echo '<div id="bpuw_display_' . $widget['name'] . '" class="bpuw-friends-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpuw_get_friends_output( $displayed_user_id, $widget['max_users'] );
									$displayed = 1;
								}
								echo '</div>';
							}
							// Groups Widget
							if ( $widget['name'] == 'groups' ) {
								echo '<div id="bpuw_display_' . $widget['name'] . '" class="bpuw-groups-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpuw_get_groups_output( $displayed_user_id, $widget['max_groups'], 10 );
									$displayed = 1;
								}
								echo '</div>';
							}
							
							// WordPress Widget
							if ( $widget['name'] == 'posts' ) {
								echo '<div id="bpuw_display_' . $widget['name'] . '" class="bpuw-posts-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpuw_get_posts_output( $displayed_user_id, $widget['max_posts'], $widget['img_size'] );
									$displayed = 1;
								}
								echo '</div>';
							}
							
							// Set up widget edit fields
							if ( $displayed_user_id == $logged_in_user_id ) {
								//Video Widgets
								if ( in_array( $widget['name'], $video_widgets ) ) {
									
									if ( ! empty($widget['link']) ) {
										
										echo '<small><input type="button" value="' . sanitize_text_field( __( 'Change Video', 'bp-user-widgets' ) ) . '" data-name="' . $widget['name'] . '" id="bpuw_add_' . $widget['name'] . '" style="display: none;" class="bpuw_add">
										
										<input type="button" value="' . sanitize_text_field( __( 'Clear Video', 'bp-user-widgets' ) ) . '" data-user="' . $displayed_user_id . '" data-name="' . $widget['name'] . '" id="bpuw_clear_' . $widget['name'] . '" style="display: none;" class="bpuw_clear_video_button"></small>';
									
									} else {
										
										echo '<small><input type="button" value="' . sanitize_text_field( __( 'Add a Video', 'bp-user-widgets' ) ) . '" data-name="' . $widget['name'] . '" id="bpuw_add_' . $widget['name'] . '" style="display: none;" class="bpuw_add"></small>';
									
									}
								}
								// Text Widgets
								if ( in_array( $widget['name'], $text_widgets ) ) {
									if ( ! empty($widget['content']) ) {
										echo '<small><input type="button" value="' . sanitize_text_field( __( 'Change Text', 'bp-user-widgets' ) ) . '" data-name="' . $widget['name'] . '" id="bpuw_add_' . $widget['name'] . '" style="display: none;" class="bpuw_add">

										<input type="button" value="' . sanitize_text_field( __( 'Clear Text', 'bp-user-widgets' ) ) . '" data-user="' . $displayed_user_id . '" data-name="' . $widget['name'] . '" id="bpuw_clear_' . $widget['name'] . '" style="display: none;" class="bpuw_clear_text_button"></small>';
									
									} else {
										
										echo '<small>
											<input type="button" value="' . sanitize_text_field( __( 'Add Text', 'bp-user-widgets' ) ) . '" data-name="' . $widget['name'] . '" id="bpuw_add_' . $widget['name'] . '" style="display: none;" class="bpuw_add">
											</small>';
									}
								}
								// Follow, WordPress and BP Widgets
								if ( in_array( $widget['name'], $wordpress_widgets ) || in_array( $widget['name'], $follow_widgets ) || in_array( $widget['name'], $buddypress_widgets ) ) {
									
									if ( $widget['visibility'] != 'none' ) {
										
										echo '<small><input type="button" value="' . sanitize_text_field( __( 'Change', 'bp-user-widgets' ) ) . '" data-name="' . $widget['name'] . '" id="bpuw_add_' . $widget['name'] . '" style="display: none;" class="bpuw_add">
										
										<input type="button" value="' . sanitize_text_field( __( 'Hide Widget', 'bp-user-widgets' ) ) . '" data-user="' . $displayed_user_id . '" data-name="' . $widget['name'] . '" id="bpuw_clear_' . $widget['name'] . '" style="display: none;" class="bpuw_clear_' . $widget['name'] . '_button"></small>';
									
									} else {
										
										echo '<small><input type="button" value="' . sanitize_text_field( __( 'Add Widget', 'bp-user-widgets' ) ) . '" data-name="' . $widget['name'] . '" id="bpuw_add_' . $widget['name'] . '" style="display: none;" class="bpuw_add"></small>';
									
									}
								}
								// Generic setting up edit form
								echo '<div id="bpuw_form_' . $widget['name'] . '" style="display: none;">
								<p style="text-align: left;">' . $title_text . '</p>
								<input type="text" placeholder="' . $title_text . '" id="bpuw_title_' . $widget['name'] . '" value="' . $widget['title'] . '">';
								// Widget type specific fields
								// Video Widget
								if ( in_array( $widget['name'], $video_widgets ) ) {
									echo '<input type="text" placeholder="' . sanitize_text_field( __( 'Paste Video URL here', 'bp-user-widgets' ) ) . '" id="bpuw_url_' . $widget['name'] . '" ';
									if ( ! empty( $widget['link'] ) ) {
										echo 'value="' . $widget['link'] . '"';
									}
									echo '>
									<span style="display: none;" for="bpuw_autoplay_' . $widget['name'] . '" ><input type="checkbox" value="' . $widget['autoplay'] . '" style="display: none;" id="bpuw_autoplay_' . $widget['name'] . '">' . sanitize_text_field(__( 'Autoplay', 'bp-user-widgets' ) ) . '</span>
									<input type="button" value="' . sanitize_text_field( __( 'Submit', 'bp-user-widgets' ) ) . '" class="bpuw_submit_video" id="bpuw_submit_' . $widget['name'] . '" data-user="' . $displayed_user_id . '" data-name="' . $widget['name'] . '" >
									</div>';
								}
								// Text Widget
								if ( in_array( $widget['name'], $text_widgets ) ) {
									echo '<div id="bpuw_content_input_' . $widget['name'] . '" >';

									$content = html_entity_decode($widget['content'] );
									$editor = 'bpuw_content_' . $widget['name'];
									$settings = array(
										'textarea_rows' => 4,
										'media_buttons' => true,
										'teeny'			=> false,
									);

									wp_editor( $content, $editor, $settings);

									
									echo '</div>
										<input type="button" value="' . sanitize_text_field( __( 'Submit', 'bp-user-widgets' ) ) . '" class="bpuw_submit_text" id="bpuw_submit_' . $widget['name'] . '" data-user="' . $displayed_user_id . '" data-name="' . $widget['name'] . '" >
									</div>';
								}
								// WordPress, Follow and BP Widgets
								if ( in_array( $widget['name'], $wordpress_widgets ) || in_array( $widget['name'], $follow_widgets ) || in_array( $widget['name'], $buddypress_widgets ) ) {
									// Follow and Friends widgets
									if ( in_array( $widget['name'], $follow_widgets ) || $widget['name'] == 'friends' ) {
										echo '<input type="text" style="width: 25%; display: inline-block;" placeholder="' . sanitize_text_field( __( 'Max users', 'bp-user-widgets' ) ) . '" id="bpuw_max_users_' . $widget['name'] . '" ';
										if ( ! empty( $widget['max_users'] ) ) {
											echo 'value="' . $widget['max_users'] . '"';
										}
										echo '><small><span style="display; inline-block; text-align: left;">' . sanitize_text_field( __( ' Max Users to show', 'bp-user-widgets' ) ) . '</span></small></br>';
									}
									if ( $widget['name'] == 'groups' ) {
										echo '<input type="text" style="width: 25%; display: inline-block;" placeholder="' . sanitize_text_field( __( 'Max groups', 'bp-user-widgets' ) ) . '" id="bpuw_max_groups_' . $widget['name'] . '" ';
										if ( ! empty( $widget['max_groups'] ) ) {
											echo 'value="' . $widget['max_groups'] . '"';
										}
										echo '><small><span style="display; inline-block;">' . sanitize_text_field( __( ' Max Groups to show', 'bp-user-widgets' ) ) . '</span></small></br>';
									}
									if ( $widget['name'] == 'posts' ) {
										echo '<input type="text" style="width: 25%; display: inline-block;" placeholder="' . sanitize_text_field( __( 'Max posts', 'bp-user-widgets' ) ) . '" id="bpuw_max_posts_' . $widget['name'] . '" ';
										if ( ! empty( $widget['max_posts'] ) ) {
											echo 'value="' . $widget['max_posts'] . '"';
										}
										echo '><small><span style="display; inline-block;">' . sanitize_text_field( __( ' Max Posts to show', 'bp-user-widgets' ) ) . '</span></small></br>';
										echo '<input type="text" style="width: 25%; display: inline-block;" placeholder="' . sanitize_text_field( __( 'Featured image size', 'bp-user-widgets' ) ) . '" id="bpuw_img_size_' . $widget['name'] . '" ';
										if ( ! empty( $widget['img_size'] ) ) {
											echo 'value="' . $widget['img_size'] . '"';
										}
										echo '><small><span style="display; inline-block;">' . sanitize_text_field( __( ' Featured Image Size', 'bp-user-widgets' ) ) . '</span></small></br>';
									}
									echo '<input type="button" value="' . sanitize_text_field( __( 'Submit', 'bp-user-widgets' ) ) . '" class="bpuw_submit_follow" id="bpuw_submit_' . $widget['name'] . '" data-user="' . $displayed_user_id . '" data-name="' . $widget['name'] . '" >
									</div>';
								}
								
								// Feedback field
								echo '<p id="bpuw_feedback_' . $widget['name'] . '" style="display: none;"></p>';
							
							}
							echo '</li>';
						}
					}
				}
			}
			echo '</ul>';
			if ( bp_displayed_user_id() == bp_loggedin_user_id() ) {
				echo '<small><input type="button" value="';

				if ( $displayed == 1 ) { 
					
					echo sanitize_text_field(__( 'Update Widgets', 'bp-user-widgets' ) );
				
				} else {
					
					echo sanitize_text_field(__( 'Add a Widget', 'bp-user-widgets' ) );
				
				}
				
				echo '" id="bpuw-add-widget" class="bppw-add-widget-button"></small>';

				if ( current_user_can( 'manage_options' ) ) {
					
					echo '<small><input type="button" value="';

					if ( isset( $presets ) && $presets != false ) { 
						
						echo sanitize_text_field(__( 'Clear Preset', 'bp-user-widgets' ) ) . '" name="clear';
					
					} else {
						
						echo sanitize_text_field(__( 'Save as Preset', 'bp-user-widgets' ) ) . '" name="save';
					
					}
					echo '" id="bpuw-update-preset" class="bpuw-update-presets-button"></small>';
				}
				
				
				echo '<small><input type="button" data-user="' . bp_displayed_user_id() . '" value="' . sanitize_text_field(__( 'Clear All', 'bp-user-widgets' ) ) . '" id="bpuw-reset-widget" class="bppw-reset-widget-button" style="display: none;"></small>
				
				<div id="bppw-widget-form" style="display: none;">
					<small><p id="bpuw_info">' . sanitize_text_field( __( 'Select an empty widget and input the required info' , 'bp-user-widgets' ) ) . '</p></small>
				</div>';
			
			}
			echo $args['after_widget'];
		}


	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Profile Widgets', 'bp-user-widgets' );
		$width = ! empty( $instance['width'] ) ? $instance['width'] : 700;
		$disable_videos = ! empty( $instance['disable_videos'] ) ? $instance['disable_videos'] : 0;
		$disable_text = ! empty( $instance['disable_text'] ) ? $instance['disable_text'] : 0;
		$disable_wordpress = ! empty( $instance['disable_wordpress'] ) ? $instance['disable_wordpress'] : 0;
		$disable_follow = ! empty( $instance['disable_follow'] ) ? $instance['disable_follow'] : 0;
		$disable_buddypress = ! empty( $instance['disable_buddypress'] ) ? $instance['disable_buddypress'] : 0;
		?>
		<p>
		<label for="<?php echo sanitize_text_field( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'bp-user-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo sanitize_text_field( $this->get_field_id( 'title' ) ); ?>" name="<?php echo sanitize_text_field( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo sanitize_text_field( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo sanitize_text_field( $this->get_field_id( 'width' ) ); ?>"><?php esc_attr_e( 'Width (px):', 'bp-user-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo sanitize_text_field( $this->get_field_id( 'width' ) ); ?>" name="<?php echo sanitize_text_field( $this->get_field_name( 'width' ) ); ?>" type="text" value="<?php echo sanitize_text_field( $width ); ?>">
		</p>
		<p>
		<label for="<?php echo sanitize_text_field( $this->get_field_id( 'disable_videos' ) ); ?>"><?php esc_attr_e( 'Disable Video/Audio Widgets:', 'bp-user-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo sanitize_text_field( $this->get_field_id( 'disable_videos' ) ); ?>" name="<?php echo sanitize_text_field( $this->get_field_name( 'disable_videos' ) ); ?>" type="checkbox" value="0" <?php if ( $disable_videos ): echo 'checked="checked"'; endif; ?>>
		</p>
		<p>
		<label for="<?php echo sanitize_text_field( $this->get_field_id( 'disable_text' ) ); ?>"><?php esc_attr_e( 'Disable Text Widgets:', 'bp-user-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo sanitize_text_field( $this->get_field_id( 'disable_text' ) ); ?>" name="<?php echo sanitize_text_field( $this->get_field_name( 'disable_text' ) ); ?>" type="checkbox" value="<?php echo sanitize_text_field( $disable_text ); ?>" <?php if ( $disable_text ): echo 'checked="checked"'; endif; ?>>
		</p>
		<p>
		<label for="<?php echo sanitize_text_field( $this->get_field_id( 'disable_wordpress' ) ); ?>"><?php esc_attr_e( 'Disable WordPress Widgets:', 'bp-user-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo sanitize_text_field( $this->get_field_id( 'disable_wordpress' ) ); ?>" name="<?php echo sanitize_text_field( $this->get_field_name( 'disable_wordpress' ) ); ?>" type="checkbox" value="<?php echo sanitize_text_field( $disable_wordpress ); ?>" <?php if ( $disable_wordpress ): echo 'checked="checked"'; endif; ?>>
		</p>
		<p>
		<label for="<?php echo sanitize_text_field( $this->get_field_id( 'disable_follow' ) ); ?>"><?php esc_attr_e( 'Disable Follow Widgets:', 'bp-user-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo sanitize_text_field( $this->get_field_id( 'disable_follow' ) ); ?>" name="<?php echo sanitize_text_field( $this->get_field_name( 'disable_follow' ) ); ?>" type="checkbox" value="<?php echo sanitize_text_field( $disable_follow ); ?>" <?php if ( $disable_follow ): echo 'checked="checked"'; endif; ?>>
		</p>
		<p>
		<label for="<?php echo sanitize_text_field( $this->get_field_id( 'disable_buddypress' ) ); ?>"><?php esc_attr_e( 'Disable BuddyPress (My Friends, My Groups )  Widgets:', 'bp-user-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo sanitize_text_field( $this->get_field_id( 'disable_buddypress' ) ); ?>" name="<?php echo sanitize_text_field( $this->get_field_name( 'disable_buddypress' ) ); ?>" type="checkbox" value="<?php echo sanitize_text_field( $disable_buddypress ); ?>" <?php if ( $disable_buddypress ): echo 'checked="checked"'; endif; ?>>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['width'] = ( ! empty( $new_instance['width'] ) ) ? sanitize_text_field( $new_instance['width'] ) : 700;
		$bpuw_video_width = update_option('bpuw_widget_options' , $instance['width'] );
		$instance['disable_videos'] = ( isset( $new_instance['disable_videos'] ) ? 1 : 0 );
		$instance['disable_text'] = ( isset( $new_instance['disable_text'] ) ? 1 : 0 );
		$instance['disable_wordpress'] = ( isset( $new_instance['disable_wordpress'] ) ? 1 : 0 );
		$instance['disable_follow'] = ( isset( $new_instance['disable_follow'] ) ? 1 : 0 );
		$instance['disable_buddypress'] = ( isset( $new_instance['disable_buddypress'] ) ? 1 : 0 );

		return $instance;
	}
	

}