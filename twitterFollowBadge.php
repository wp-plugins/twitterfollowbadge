<?php
/*
Plugin Name: twitterFollowBadge
Plugin URI: http://www.spiderpig.de
Description: This plugin adds the "Follow Us" button from <a href="http://www.go2web20.net/twitterFollowBadge/" target="_blank">go2web20.net</a> for twitter on the left/right of any page. I wrote this, because i was tired to add the code to each template's footer.
Author: Jan Schöppach
Version: 1.0.0
Author URI: http://www.jan-schoeppach.de/
*/
/*  Copyright 2009  Jan Schöppach  (email : dns013@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function addBadge() {
	echo("
	<!-- twitter follow badge by go2web20 -->
		<script src='http://files.go2web20.net/twitterbadge/1.0/badge.js' type='text/javascript'></script><script type='text/javascript' charset='utf-8'><!--
			tfb.account = '" . get_option("tfb_account") . "';
			tfb.label = '" . get_option("tfb_label") . "';
			tfb.color = '" . get_option("tfb_color") . "';
			tfb.side = '" . get_option("tfb_side") . "';
			tfb.top = " . get_option("tfb_top") . ";
			tfb.showbadge();
		--></script>
	<!-- end of twitter follow badge -->");
}



function tfb_menu() {
	add_options_page('twitterFollowBadge Options', 'twitterFollowBadge', 8, 'twitterFollowBadge', 'tfb_options_page');
}

function tfb_options_page() {
	echo '<div class="wrap">';
	echo '<h2>twitterFollowBadge ' . __('Options', 'tfb') . '</h2>';
	echo '<form method="post" action="options.php">';
  
	wp_nonce_field('update-options');
  
	echo '<table class="form-table" style="width: 500px;">';
	echo '<tr valign="top">';
	echo '<th scope="row">' . __('Twitter account', 'tfb') . '</th>';
	echo '<td><input type="text" name="tfb_account" value="' . get_option('tfb_account') . '" /></td>';
	echo '</tr>';
	echo '<th scope="row">' . __('Label', 'tfb') . '</th>';
	echo '<td><select name="tfb_label" size="1">';
	echo '<option value="follow-us"'; 
	if(get_option('tfb_label') == "follow-us")
		echo ' selected';
	echo '>Follow us</option>';
	
	echo '<option value="follow-me"'; 
	if(get_option('tfb_label') == "follow-me")
		echo ' selected';
	echo '>Follow me</option>';
	
	echo '<option value="follow"'; 
	if(get_option('tfb_label') == "follow")
		echo ' selected';
	echo '>Follow</option>';
	
	echo '<option value="my-twitter"'; 
	if(get_option('tfb_label') == "my-twitter")
		echo ' selected';
	echo '>my twitter</option>';
	echo '</select>';
	echo '</tr>';
	echo '<th scope="row">' . __('Color', 'tfb') . '</th>';
	echo '<td><input type="text" name="tfb_color" value="' . get_option('tfb_color') . '" /></td>';
	echo '</tr>';
	echo '<th scope="row">' . __('Side', 'tfb') . '</th>';
	echo '<td><input type="radio" name="tfb_side" value="l"'; 
	if(get_option('tfb_side') == "l")
		echo ' checked';
	echo '/> ' . __('Left', 'tfb') . '</td>';
	
	echo '<td><input type="radio" name="tfb_side" value="r"'; 
	if(get_option('tfb_side') == "r")
		echo ' checked';
	echo '/> ' . __('Right', 'tfb') . '</td>';
	echo '</tr>';
	echo '<th scope="row">' . __('From top', 'tfb') . '</th>';
	echo '<td><input type="text" name="tfb_top" value="' . get_option('tfb_top') . '" /> Pixels</td>';
	echo '</tr>';
	echo '</table>';
	echo '<p class="submit">';	
	echo '<input type="submit" class="button-primary" value="' . __('Save Changes') . '" />';
	echo '</p>';
  
	settings_fields('twitterFollowBadge');
  
	echo '</form>';
	echo '</div>';
}

function tfb_register_settings() {
	register_setting('twitterFollowBadge', 'tfb_account');
	register_setting('twitterFollowBadge', 'tfb_label');
	register_setting('twitterFollowBadge', 'tfb_color');
	register_setting('twitterFollowBadge', 'tfb_side');
	register_setting('twitterFollowBadge', 'tfb_top');
}

$plugin_dir = basename(dirname(__FILE__));
load_plugin_textdomain('tfb', 'wp-content/plugins/' . $plugin_dir, $plugin_dir);

add_option("tfb_account");
add_option("tfb_label", "follow-us");
add_option("tfb_color", "#35ccff");
add_option("tfb_side", "r");
add_option("tfb_top", "136");

add_action('wp_footer', 'addBadge');

if(is_admin()){
	add_action('admin_menu', 'tfb_menu');
	add_action('admin_init', 'tfb_register_settings');
}
?>