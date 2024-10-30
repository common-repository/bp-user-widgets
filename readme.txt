=== BP User Widgets ===
Contributors: Venutius
Tags: BuddyPress,profile,widget,BP,users, members 
Tested up to: 6.4.3
Stable tag: 1.0.8
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Donate Link: https://paypal.me/GeorgeChaplin
Plugin URI: www.wordpress.org/plugins/bp-user-widgets/

Add user editable widgets to profile pages with a widgets for text, video, buddypress friends and groups, as well as followed and followiing.

== Description ==

The ability to personalize a users own profile is an important part of a social network. This plugin is designed to deliver a key profile page personalization feature. 

It installs a widget that is only visible in the members profile pages that allows users to select up to four Text Widgets, four Video Widgets, My Posts, My Groups, My Friends, Who I'm following and Who I'm followed By. The widget order can be easily rearranged using a simple drag and drop interface.

The default install configuration is to have all of the widgets empty and hidden, however the site admin can save a widget configuration to be used as the default/preset setup for all users who have not configured their own widgets.

This plugin can be used for both BP Legacy and BP Nouveau themes, it is optimized for sidebars. Only one instance of the widget is supported.

Text Widgets - Provide a full featured TinyMCE text editor, if the use has video upload capability then the Media interface is also enabled.

Video Widget - Allow links from YouTube and other video hosting sites to be added.

WordPress Posts Widget - display the users latest post links and thumbnail.

The following features need BuddyPress to be active.

BuddyPress Groups - Adds a list of groups the user is a member of.

BuddyPress Friends - Adds a friends list.

The following features need BP Follow to be active.

Who I'm following  - Lists recently active members the user is following.

Who's Following Me - Lists recently active followers.

Another plugin that helps with profile personalization is BuddyDev's 
* <a href="https://buddydev.com/plugins/bp-custom-background-for-user-profile/">BP Custom Background for User Profile</a> 

== Installation ==

Option 1.

1. From the Admin>>Plugins>>Add New page, search for BP Profile Shortcodes Extra.
2. When you have located the plugin, click on "Install" and then "Activate".
3. Go to the Appearance/Widgets page and add the BP User Widget to the sidebar,
4. All users will be able to go to their profile pages an add their widgets!

With the zip file:

Option 2

1. Upzip the plugin into it's directory/file structure
2. Upload BP User Widgets structure to the /wp-content/plugins/ directory.
3. Activate the plugin through the Admin>>Plugins menu.
4. Go to the Appearance/Widgets page and add the BP User Widget to the sidebar,
5. All users will be able to go to their profile pages an add their widgets!

Option 3

1. Go to Admin>>Plugins>>Add New>>Upload page.
2. Select the zip file and choose upload.
3. Activate the plugin.
4. Go to the Appearance/Widgets page and add the BP User Widget to the sidebar,
5. All users will be able to go to their profile pages an add their widgets!
 

== Frequently Asked Questions ==

= 1.0.8 =

* 12/03/2024

* Fix: bp_displayed_user_id() function no longer seems to work, so have used an alternative function.

= 1.0.7 =

* 14/01/2021

* Fix: Corrected issue caused when no presets set.

= 1.0.6 =

* 11/04/2019

* New: Added French translation, thanks to Bruno Verrier.

== Changelog ==

= 1.0.5 =

* 05/04/2019

* Fix: Added jQuery as dependency.

= 1.0.4 = 

* 27/02/2019

* Fix: corrected undefined offset error in WP_Widget.

= 1.0.3 =

* 21/02/2019

* Fix: Made videos responsive.

= 1.0.2 =

* 18/02/2019

* Fix: corrected error when the text widget is used in text mode.
* Fix: Corrected widgets title style to h2.

= 1.0.1 =

* 16/02/2019

* Fix: Corrected textdomain function call.

= 1.0.0 = 

* 14/02/2018

* Clear Widgets Notification
* Widget Name Switch
* Add Widget button hide after selection
* Add Friends/Groups response Text
* Add Friends/Groups success text
* Widget Title Styling 

== Screenshots ==

1. screenshot-1.png Widget Admin Controls
2. screenshot-2.png Widget front end display
3. screenshot-3.png Widget User Controls

== Upgrade Notice ==

