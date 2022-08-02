<?php
/**
 * Plugin Name: Admin Setup
 * Plugin URI: https://github.com/akozoubsky/admin-setup
 * Description: Setup WP Admin. 
 * Version: 0.0.2
 * Author: Alexandre Kozoubsky
 * Author URI: http://alexandrekozoubsky.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 * 
 * @package    AdminSetup
 * @version    0.0.1
 * @author     Alexandre Kozoubsky <alexandre@alexandrekozoubsky.com>
 * @copyright  Copyright (c) 2014 - 2015, Alexandre Kozoubsky
 * @link       https://github.com/akozoubsky/admin-setup
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Remove WordPress Icon from Admin Bar
 */
 
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

function remove_admin_bar_links() {
	 global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}

/**
 * Leave the Toolbar available in the Dashboard but hide it on all front facing pages.
 */

//add_filter('show_admin_bar', '__return_false');

/**
 * Admin footer modification.
 */

add_filter('admin_footer_text', 'adminsetup_remove_footer_admin');

function adminsetup_remove_footer_admin () {
    echo '<span id="footer-thankyou">Desenvolvido por <a href="http://www.alexandrekozoubsky.com" target="_blank">Alexandre Kozoubsky - http://www.alexandrekozoubsky.com</a></span>';
}

/**
 * Remove itens from admin menu.
 * @link http://codex.wordpress.org/Function_Reference/remove_menu_page 
 * Please be aware that this would not prevent a user from accessing these screens directly. 
 * Removing a menu does not replace the need to filter a user's permissions as appropriate. 
 */

add_action( 'admin_menu', 'adminsetup_remove_menu_pages' );

function adminsetup_remove_menu_pages() {
    
	if ( ! current_user_can( 'activate_plugins' ) ) {
	
		remove_menu_page('options-general.php');
		remove_menu_page('tools.php');
	}
      
}

/**
 * Remove widgets from the Admin Dashboard screen.
 * @link https://gist.github.com/chrisguitarguy/1377965
 */

add_action('wp_dashboard_setup', 'adminsetup_remove_dashboard_widgets' );

function adminsetup_remove_dashboard_widgets() {

	// Remove meta boxes from Wordpress dashboard for all users

	/**
	 * Removes the "Right Now" widget that tells you post/comment counts
	 * and what theme you're using.
	 */
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	
	/**
	 * Removes the recent comments widget
	 */
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	
	/**
	 * Removes the incoming links widget.
	 */
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	
	/**
	 * Removes the plugins widgets that displays the most popular,
	 * newest, and recently updated plugins
	 */
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	
	/**
	 * Removes the quick press widget that allows you post right from the dashboard
	 */
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	
	/**
	 * Removes the widget containing the list of recent drafts
	 */
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	
	/**
	 * Removes the "WordPress Blog" widget
	 */
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	
	/**
	 * Removes the "Other WordPress News" widget
	 */
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	
	/**
	 * Removes the "Site Health" widget
	 */
	remove_meta_box('dashboard_site_health', 'dashboard', 'normal');	

		
	if ( ! current_user_can( 'activate_plugins' ) ) {
	
		// Globalize the metaboxes array, this holds all the widgets for wp-admin
		global $wp_meta_boxes;
     
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['photocrati_admin_dashboard_widget']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_addthis']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['events_dashboard_window']);	
		unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']); //BBPress
		unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']); // Gravity Forms
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_quick_press']);  // Rascunho rápido
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);  // Atividade
		unset($wp_meta_boxes['dashboard']['normal']['core']['wp_dashboard_events_news']);  // Atividade			
		
		//remove_menu_page('index.php'); // Dashboard
		//remove_menu_page('edit.php'); // Posts
		//remove_menu_page('upload.php'); // Media
		remove_menu_page('link-manager.php'); // Links
		//remove_menu_page('edit.php?post_type=page'); // Pages
		//remove_menu_page('edit-comments.php'); // Comments
		remove_menu_page('themes.php'); // Appearance
		//remove_menu_page('plugins.php'); // Plugins
		//remove_menu_page('users.php'); // Users
		remove_menu_page('tools.php'); // Tools
		remove_menu_page('options-general.php'); // Settings
		remove_menu_page('itsec'); // IThemes Security	
		remove_menu_page('duplicator'); // Duplicator
    
	}

	/* 
	if ( ! current_user_can( 'edit_tribe_event' ) ) {
		remove_menu_page('edit.php?post_type=tribe_events'); // Tribe Events - Calendar
	}
	*/
}
?>