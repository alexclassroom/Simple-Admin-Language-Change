<?php

/**
* File handling scripts and styles
*
* @package    WordPress
* @subpackage SALC
* @since 2.0.0
*/

namespace SALC;

/**
 * Add custom icon to the admin bar
 * https://wordpress.stackexchange.com/questions/172939/how-do-i-add-an-icon-to-a-new-admin-bar-item
 *
 * @return void
 */
function admin_css()
{
	echo '<style>
    #wpadminbar #wp-admin-bar-salc-current-language .ab-icon:before {
		content: "\f326";
		top: 3px;
	}
	</style>';
}
add_action('admin_head', __NAMESPACE__ . '\admin_css');

/**
 * Load admin script
 *
 * @param mixed $hook
 * @return void
 */
function admin_script($hook)
{
	// Check for permissions matching the user_locale
	if (! current_user_can('edit_posts') || ! current_user_can('edit_pages')) {
		return;
	}
	wp_enqueue_script('salc', plugin_dir_url( dirname(__FILE__)) . '/script.js', [], time());
	wp_localize_script('salc', 'props', [
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce("salc_change_user_locale"),
		'user_id' => get_current_user_id(),
	]);
}
add_action('admin_enqueue_scripts', __NAMESPACE__ . '\admin_script');