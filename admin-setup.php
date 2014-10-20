<?php
/**
 * Plugin Name: Admin Setup
 * Plugin URI: https://github.com/akozoubsky/admin-setup
 * Description: Setup WP Admin. 
 * Version: 0.0.1
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
 */

/* Remove WordPress Icon from Admin Bar */

add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

function remove_admin_bar_links() {
	 global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}

/* leave the Toolbar available in the Dashboard but hide it on all front facing pages. */

add_filter('show_admin_bar', '__return_false');


/* Admin footer modification */

add_filter('admin_footer_text', 'remove_footer_admin');

function remove_footer_admin () {
    echo '<span id="footer-thankyou">Desenvolvido por <a href="http://www.alexandrekozoubsky.com" target="_blank">Alexandre Kozoubsky - http://www.alexandrekozoubsky.com</a></span>';
}

/* Remove itens from admin menu */

/* http://codex.wordpress.org/Function_Reference/remove_menu_page 
Please be aware that this would not prevent a user from accessing these screens directly. 
Removing a menu does not replace the need to filter a user's permissions as appropriate. 
*/

add_action( 'admin_menu', 'ak_remove_menu_pages' );

function ak_remove_menu_pages() {
    
	if ( ! current_user_can( 'activate_plugins' ) ) {
	
		remove_menu_page('options-general.php');
		remove_menu_page('tools.php');
	}
      
}

/* Remove admin meta boxes */

add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

// Remove meta boxes from Wordpress dashboard for all users

function remove_dashboard_widgets() {

	if ( ! current_user_can( 'activate_plugins' ) ) {
	
		// Globalize the metaboxes array, this holds all the widgets for wp-admin
		global $wp_meta_boxes;
     
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['photocrati_admin_dashboard_widget']); 
    
	}
	 
}
?>
