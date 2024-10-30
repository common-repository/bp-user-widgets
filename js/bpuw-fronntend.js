/*
* @package bp-user-widgets
*/

//

// Setup variables for button images
jQuery(document).ready(function($){

	//Make videos Responsive
	// Find all iframes
	var $iframes = jQuery( ".bpuw-video-wrapper iframe" );

	// Find &#x26; save the aspect ratio for all iframes
	$iframes.each(function () {
	  jQuery( this ).data( "ratio", this.height / this.width )
		// Remove the hardcoded width &#x26; height attributes
		.removeAttr( "width" )
		.removeAttr( "height" );
	});

	// Resize the iframes when the window is resized
	jQuery( window ).resize( function () {
	  $iframes.each( function() {
		// Get the parent container&#x27;s width
		var width = $( this ).parent().width();
		jQuery( this ).width( width )
		  .height( width * $( this ).data( "ratio" ) );
	  });
	// Resize to fix all iframes on page load.
	}).resize();

	// fix for responsive images in text editor 
	$('#bpphw_display_text_1 img').attr('width', '100%').attr('height', '');
	$('#bpphw_display_text_2 img').attr('width', '100%').attr('height', '');

	// fix for responsive images in text editor 
	$('#bpuw_display_text_1 img').attr('width', '100%').attr('height', '');
	$('#bpuw_display_text_2 img').attr('width', '100%').attr('height', '');

	// Set up the sortable widgets
	$( function() {
		$( "#sortable-uw" ).sortable({
			update: function( event, ui ) {
				$(this).children().each(function (index) {
					if ($(this).attr('data-position') != (index+1)) {
						$(this).attr('data-position', (index+1)).addClass('updated');
					}
				});
				var positions = [];
				$('.updated').each(function() {
					positions.push([$(this).attr('data-name'),$(this).attr('data-position')]);
					$(this).removeClass('updated');
				});
				$.ajax({
					url : ajax_object.ajaxurl,
					type : 'post',
					data : {
						positions : positions,
						security : ajax_object.check_nonce,
						action : "bpuw_moveable_widgets"
					},
					success : function(data) {
						if ( data == 1 ) {
						
						} else {
						
						}
						
					},
					error : function(data){
						console.log(data);
					}
				});
				
			}
		});
		$( "#sortable-uw" ).disableSelection();
	} );
	
	// Open up the edit widgets dialogue
	function openWidgets(e){

		var resetButton = document.getElementById( 'bpuw-reset-widget' );
		var widgetForm = document.getElementById( 'bppw-widget-form' );

		var video1 = document.getElementById( 'bpuw_video_1' );
		var video2 = document.getElementById( 'bpuw_video_2' );
		var video3 = document.getElementById( 'bpuw_video_3' );
		var video4 = document.getElementById( 'bpuw_video_4' );
		var video1Button = document.getElementById( 'bpuw_add_video_1' );
		var video2Button = document.getElementById( 'bpuw_add_video_2' );
		var video3Button = document.getElementById( 'bpuw_add_video_3' );
		var video4Button = document.getElementById( 'bpuw_add_video_4' );
		var video1ClearButton = document.getElementById( 'bpuw_clear_video_1' );
		var video2ClearButton = document.getElementById( 'bpuw_clear_video_2' );
		var video3ClearButton = document.getElementById( 'bpuw_clear_video_3' );
		var video4ClearButton = document.getElementById( 'bpuw_clear_video_4' );

		var text1 = document.getElementById( 'bpuw_text_1' );
		var text2 = document.getElementById( 'bpuw_text_2' );
		var text3 = document.getElementById( 'bpuw_text_3' );
		var text4 = document.getElementById( 'bpuw_text_4' );
		var text1Button = document.getElementById( 'bpuw_add_text_1' );
		var text2Button = document.getElementById( 'bpuw_add_text_2' );
		var text3Button = document.getElementById( 'bpuw_add_text_3' );
		var text4Button = document.getElementById( 'bpuw_add_text_4' );
		var text1ClearButton = document.getElementById( 'bpuw_clear_text_1' );
		var text2ClearButton = document.getElementById( 'bpuw_clear_text_2' );
		var text3ClearButton = document.getElementById( 'bpuw_clear_text_3' );
		var text4ClearButton = document.getElementById( 'bpuw_clear_text_4' );

		var video = document.getElementById( 'bpuw_video' );
		var postsButton = document.getElementById( 'bpuw_add_video' );
		var postsClearButton = document.getElementById( 'bpuw_clear_video' );

		var following = document.getElementById( 'bpuw_following' );
		var followingButton = document.getElementById( 'bpuw_add_following' );
		var followingClearButton = document.getElementById( 'bpuw_clear_following' );

		var followed = document.getElementById( 'bpuw_followed' );
		var followedButton = document.getElementById( 'bpuw_add_followed' );
		var followedClearButton = document.getElementById( 'bpuw_clear_followed' );

		var friends = document.getElementById( 'bpuw_friends' );
		var friendsButton = document.getElementById( 'bpuw_add_friends' );
		var friendsClearButton = document.getElementById( 'bpuw_clear_friends' );

		var groups = document.getElementById( 'bpuw_groups' );
		var groupsButton = document.getElementById( 'bpuw_add_groups' );
		var groupsClearButton = document.getElementById( 'bpuw_clear_groups' );

		var posts = document.getElementById( 'bpuw_posts' );
		var postsButton = document.getElementById( 'bpuw_add_posts' );
		var postsClearButton = document.getElementById( 'bpuw_clear_posts' );

		resetButton.style.display = 'block';
		this.style.display = 'none';
		
		if ( video1 != null ) {
			video1.style.display = 'block';
			video1Button.style.display = 'block';
		}
		if ( video1ClearButton != null ) {
			video1ClearButton.style.display = 'block';
		}
		if ( video2 != null ) {
			video2.style.display = 'block';
			video2Button.style.display = 'block';
		}
		if ( video2ClearButton != null ) {
			video2ClearButton.style.display = 'block';
		}
		if ( video3 != null ) {
			video3.style.display = 'block';
			video3Button.style.display = 'block';
		}
		if ( video3ClearButton != null ) {
			video3ClearButton.style.display = 'block';
		}
		if ( video4 != null ) {
			video4.style.display = 'block';
			video4Button.style.display = 'block';
		}
		if ( video4ClearButton != null ) {
			video4ClearButton.style.display = 'block';
		}
		
		if ( text1 != null ) {
			text1.style.display = 'block';
			text2.style.display = 'block';
			text3.style.display = 'block';
			text4.style.display = 'block';
			text1Button.style.display = 'block';
			text2Button.style.display = 'block';
			text3Button.style.display = 'block';
			text4Button.style.display = 'block';
		}
		if ( text1ClearButton != null ) {
			text1ClearButton.style.display = 'block';
		}
		if ( text2ClearButton != null ) {
			text2ClearButton.style.display = 'block';
		}
		if ( text3ClearButton != null ) {
			text3ClearButton.style.display = 'block';
		}
		if ( text4ClearButton != null ) {
			text4ClearButton.style.display = 'block';
		}
		
		if ( video1 != null ) {
			video1.style.display = 'block';
			video1Button.style.display = 'block';
		}
		if ( video1ClearButton != null ) {
			video1ClearButton.style.display = 'block';
		}
		if ( video2ClearButton != null ) {
			video2ClearButton.style.display = 'block';
		}
		if ( video3ClearButton != null ) {
			video3ClearButton.style.display = 'block';
		}
		if ( video4ClearButton != null ) {
			video4ClearButton.style.display = 'block';
		}

		if ( following != null ) {
			following.style.display = 'block';
			followed.style.display = 'block';
			followingButton.style.display = 'block';
			followedButton.style.display = 'block';
		}
		if ( followingClearButton != null ) {
			followingClearButton.style.display = 'block';
		}
		if ( followedClearButton != null ) {
			followedClearButton.style.display = 'block';
		}

		if ( friends != null ) {
			friends.style.display = 'block';
			friendsButton.style.display = 'block';
		}
		if ( friendsClearButton != null ) {
			friendsClearButton.style.display = 'block';
		}

		if ( groups != null ) {
			groups.style.display = 'block';
			groupsButton.style.display = 'block';
		}
		if ( groupsClearButton != null ) {
			groupsClearButton.style.display = 'block';
		}

		if ( posts != null ) {
			posts.style.display = 'block';
			postsButton.style.display = 'block';
		}
		if ( postsClearButton != null ) {
			postsClearButton.style.display = 'block';
		}

		widgetForm.style.display = 'block';
	}

	$('.bppw-add-widget-button').off().on('click', openWidgets);
	
	// function to reset the user widget data to defaults
	function resetWidget(e){

		var clicked = e.target;
		var userId = clicked.getAttribute( 'data-user');
		var feedback = document.getElementById( 'bpuw_info' );
		
		feedback.style.display = 'block';
		feedback.innerHTML = bpuw_translate.resetWidget;
		
		$.ajax({
			url : ajax_object.ajaxurl,
			type : 'post',
			data : {
				userId : userId,
				security : ajax_object.check_nonce,
				action : "bpuw_reset_widget"
			},
			success : function(data) {
				console.log(data);
				if ( data == 1 ) {
					feedback.innerHTML = bpuw_translate.successRefresh;
				} else {
					feedback.innerHTML = bpuw_translate.tryAgain;
				}
				
			},
			error : function(data){
				feedback.innerHTML = bpuw_translate.tryAgain;
			}
		});
			
	}

	$('.bppw-reset-widget-button').off().on('click', resetWidget);

	// Generic Widget Functions
	
	// Open add/edit form
	function openInputForm(e){

		var clicked = e.target;
		var name = clicked.getAttribute( 'data-name' );
		var inputForm = document.getElementById( 'bpuw_form_' + name );
		var ClearButton = document.getElementById( 'bpuw_clear_' + name );
		var title = document.getElementById( 'bpuw_desc_' + name );

		if ( inputForm.style.display == 'none' ) {
			inputForm.style.display = 'block';
//			ClearButton.style.display = 'block'
			clicked.value = bpuw_translate.cancel;
		} else {
			inputForm.style.display = 'none';
			if ( title.innerHTML == name ) {
				clicked.value = bpuw_translate.add;
			} else { 
				clicked.value = bpuw_translate.change;
			}
		}
		

	}


	$('.bpuw_add').off().on('click', openInputForm);

	// Clear widget function
	function clearWidget(e){

		var clicked = e.target;
		var userId = clicked.getAttribute( 'data-user');
		var name = clicked.getAttribute( 'data-name' );
		var feedback = document.getElementById( 'bpuw_feedback_' + name );
		var displayContent = document.getElementById('bpuw_display_' + name );
		var ClearButton = document.getElementById( 'bpuw_clear_' + name );
		var addButton = document.getElementById( 'bpuw_add_' + name );
		var title = document.getElementById( 'bpuw_desc_' + name );
		var inputForm = document.getElementById( 'bpuw_form_' + name );
		feedback.style.display = 'block';
		feedback.innerHTML = bpuw_translate.deleting;

		$.ajax({
			url : ajax_object.ajaxurl,
			type : 'post',
			data : {
				userId : userId,
				name : name,
				security : ajax_object.check_nonce,
				action : "bpuw_clear_widget"
			},
			success : function(data) {
				if ( data == 1 ) {
					feedback.innerHTML = bpuw_translate.success;
					displayContent.style.display = 'none';
					ClearButton.style.display = 'none'
					addButton.value = bpuw_translate.add;
					title.innerHTML = name;
					inputForm.style.display = 'none';
				} else {
					feedback.innerHTML = bpuw_translate.tryAgain;
				}
				
			},
			error : function(data){
				feedback.innerHTML = bpuw_translate.tryAgain;
			}
		});
			
	}

	$('.bpuw_clear_video_button').off().on('click', clearWidget);
	$('.bpuw_clear_text_button').off().on('click', clearWidget);
	$('.bpuw_clear_friends_button').off().on('click', clearWidget);
	$('.bpuw_clear_groups_button').off().on('click', clearWidget);
	$('.bpuw_clear_following_button').off().on('click', clearWidget);
	$('.bpuw_clear_followed_button').off().on('click', clearWidget);
	$('.bpuw_clear_posts_button').off().on('click', clearWidget);

	// Video Widget Functions

	//Add video URL
	function addVideoUrl(e){

		var clicked = e.target;
		var userId = clicked.getAttribute( 'data-user');
		var name = clicked.getAttribute( 'data-name' );
		var videoForm = document.getElementById( 'bpuw_form_' + name );
		var videoInputUrl = document.getElementById( 'bpuw_url_' + name );
		var videoTitle = document.getElementById( 'bpuw_title_' + name );
		var title = document.getElementById( 'bpuw_desc_' + name );
		var displayContent = document.getElementById('bpuw_display_' + name );
		var feedback = document.getElementById( 'bpuw_feedback_' + name );
		var autoplay = document.getElementById( 'bpuw_autoplay_' + name ).value;
		var addButton = document.getElementById( 'bpuw_add_' + name );
		feedback.style.display = 'block';

		if ( videoInputUrl.value != '' ) {

			feedback.innerHTML = bpuw_translate.addingVideo;
			
			$.ajax({
				url : ajax_object.ajaxurl,
				type : 'post',
				data : {
					userId : userId,
					name : name,
					videoURL : videoInputUrl.value,
					autoplay : autoplay,
					title : videoTitle.value,
					security : ajax_object.check_nonce,
					action : "bpuw_add_video"
				},
				success : function(data) {
					if ( data ) {
						videoForm.style.display = 'none';
						displayContent.style.display = 'block';
						displayContent.innerHTML = data;
						feedback.innerHTML = bpuw_translate.success;
						addButton.value = bpuw_translate.change;
						title.innerHTML = videoTitle.value;
						} else {
						feedback.innerHTML = bpuw_translate.tryAgain;
					}
					
				},
				error : function(data){
					feedback.innerHTML = bpuw_translate.tryAgain;
				}
			});
			
		} else {
			
			feedback.innerHTML = bpuw_translate.enterVideo;
			
		}
	}

	$('.bpuw_submit_video').off().on('click', addVideoUrl);
	

	// Text Widget Functions
	
	//Add text input
	function addText(e){

		var clicked = e.target;
		var userId = clicked.getAttribute( 'data-user');
		var name = clicked.getAttribute( 'data-name' );
		var textForm = document.getElementById( 'bpuw_form_' + name );
		var textContent =  tinymce.get('bpuw_content_' + name);
		var textTitle = document.getElementById( 'bpuw_title_' + name );
		var title = document.getElementById( 'bpuw_desc_' + name );
		var textInput = document.getElementById( 'bpuw_content_input_' + name );
		var displayContent = document.getElementById('bpuw_display_' + name );
		var feedback = document.getElementById( 'bpuw_feedback_' + name );
		var addButton = document.getElementById( 'bpuw_add_' + name );

		if ( textContent === null ) {
			textContent = document.getElementById( 'bpuw_content_' + name ).value;
		} else {
			textContent =  textContent.getContent();
		}
		feedback.style.display = 'block';

		if ( textContent.value != '' ) {
			feedback.innerHTML = bpuw_translate.addingText;
			$.ajax({
				url : ajax_object.ajaxurl,
				type : 'post',
				data : {
					userId : userId,
					name : name,
					content : textContent,
					title : textTitle.value,
					security : ajax_object.check_nonce,
					action : "bpuw_add_text"
				},
				success : function(data) {
					if ( data ) {
						textForm.style.display = 'none';
//						textInput.style.display = 'none';
						if ( displayContent != null ) {
							displayContent.innerHTML = data;
							addButton.value = bpuw_translate.change;
							title.innerHTML = textTitle.value;
							$('#bpuw_display_' + name + ' img').attr('width', '100%').attr('height', '');
							displayContent.style.display = 'block';
						}
						feedback.innerHTML = bpuw_translate.success;
					} else {
						feedback.innerHTML = bpuw_translate.tryAgain;
					}
					
				},
				error : function(data){
					feedback.innerHTML = bpuw_translate.tryAgain;
				}
			});
			
		} else {
			
			feedback.innerHTML = bpuw_translate.enterText;
			
		}
	}

	$('.bpuw_submit_text').off().on('click', addText);

	//Add follow and BuddyPress input
	function addFollow(e){

		var clicked = e.target;
		var userId = clicked.getAttribute( 'data-user');
		var name = clicked.getAttribute( 'data-name' );
		var followForm = document.getElementById( 'bpuw_form_' + name );
		var followUsers =  document.getElementById( 'bpuw_max_users_' + name );
		var followGroups =  document.getElementById( 'bpuw_max_groups_' + name );
		var followPosts =  document.getElementById( 'bpuw_max_posts_' + name );
		var followImgSize =  document.getElementById( 'bpuw_img_size_' + name );
		var followTitle = document.getElementById( 'bpuw_title_' + name );
		var title = document.getElementById( 'bpuw_desc_' + name );
		var displayContent = document.getElementById('bpuw_display_' + name );
		var feedback = document.getElementById( 'bpuw_feedback_' + name );
		var addButton = document.getElementById( 'bpuw_add_' + name );
		if ( followUsers != null ) {
			if ( isNaN( followUsers.value ) ) {
				max = 8;
			} else {
				max = followUsers.value;
			}
			imgSize = 150;
		} else if ( followGroups != null )  {
			if ( isNaN( followGroups.value ) ) {
				max = 4;
			} else {
				max = followGroups.value;
			}
			max = followGroups.value;
			imgSize = 150;
		} else if ( followPosts != null ) {
			max = followPosts.value;
			if ( isNaN( followImgSize.value ) ) {
				imgSize = 150;
			} else {
				imgSize = followImgSize.value;
			}
		}
		feedback.style.display = 'block';

		if ( name == "friends" ) {
			feedback.innerHTML = bpuw_translate.addingFriends;
		}
		if ( name == "groups" ) {
			feedback.innerHTML = bpuw_translate.addingGroups;
		}
		if ( name == "followed" ) {
			feedback.innerHTML = bpuw_translate.addingFollowers;
		}
		if ( name == "following" ) {
			feedback.innerHTML = bpuw_translate.addingFollowing;
		}
		if ( name == "posts" ) {
			feedback.innerHTML = bpuw_translate.addingPosts;
		}
		$.ajax({
			url : ajax_object.ajaxurl,
			type : 'post',
			data : {
				userId : userId,
				name : name,
				max : max,
				imgSize : imgSize,
				title : followTitle.value,
				security : ajax_object.check_nonce,
				action : "bpuw_add_follow"
			},
			success : function(data) {
				if ( data ) {
					followForm.style.display = 'none';
					// if ( name == 'groups' ) {
						// followGroups.style.display = 'none';
					// } else {
						// followUsers.style.display = 'none';
					// }
					if ( displayContent != null ) {
						displayContent.innerHTML = data;
						addButton.value = bpuw_translate.change;
						title.innerHTML = followTitle.value;
						displayContent.style.display = 'block';
					}
					feedback.innerHTML = bpuw_translate.success;
				} else {
					feedback.innerHTML = bpuw_translate.tryAgain;
				}
				
			},
			error : function(data){
				feedback.innerHTML = bpuw_translate.tryAgain;
			}
		});
		
	}

	$('.bpuw_submit_follow').off().on('click', addFollow);

	// Save/clear presets
	function updatePresets(e){

		var clicked = e.target;
		var feedback = document.getElementById( 'bpuw_info' );
		var feedbackForm = document.getElementById( 'bppw-widget-form' );
		feedbackForm.style.display = 'block';

		if ( clicked.name === 'clear' ) {
			feedback.innerHTML = bpuw_translate.clearingPreset;
			update = 'clear'
		} else {
			feedback.innerHTML = bpuw_translate.savingPreset;
			update = 'save';
		}
		$.ajax({
			url : ajax_object.ajaxurl,
			type : 'post',
			data : {
				update : update,
				security : ajax_object.check_nonce,
				action : "bpuw_update_presets"
			},
			success : function(data) {
				if ( data == 1 ) {
					feedback.innerHTML = bpuw_translate.success;
					if ( clicked.name === 'clear' ) {
						clicked.value = bpuw_translate.savePreset;
						clicked.name = 'save';
					} else {
						clicked.value = bpuw_translate.clearPreset;
						clicked.name = 'clear';
					}
				} else {
					feedback.innerHTML = bpuw_translate.tryAgain;
				}
				
			},
			error : function(data){
				feedback.innerHTML = bpuw_translate.tryAgain;
			}
		});
		
	}

	$( '#bpuw-update-preset' ).off().on( 'click', updatePresets );

	
});