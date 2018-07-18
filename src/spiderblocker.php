<?php

namespace Niteoweb\SpiderBlocker;

/**
 * Plugin Name: Spider Blocker
 * Description: Spider Blocker will block most common bots that consume bandwidth and slow down your server.
 * Version:     1.0.17
 * Runtime:     5.3+
 * Author:      Easy Blog Networks
 * Text Domain: spiderblocker
 * Author URI:  www.easyblognetworks.com
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Fetch the Apache version.
 *
 * @return string or false
 */

if ( ! function_exists( 'apache_get_version' ) ) {
	function apache_get_version() {
		if ( stristr( $_ENV['SERVER_SOFTWARE'], 'Apache' ) ) {
			return $_ENV['SERVER_SOFTWARE'];
		}
		if ( stristr( $_SERVER['SERVER_SOFTWARE'], 'Apache' ) ) {
			return $_SERVER['SERVER_SOFTWARE'];
		}
		return false;
	}
}

/**
 * Checks for PHP version and stop the plugin if the 
 * version is < 5.3.0.
 */

if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) {
	?>
	<div id="error-page">
		<p>
		<?php
		esc_html_e(
			'This plugin requires PHP 5.3.0 or higher. Please contact your hosting provider about upgrading your
			server software. Your PHP version is', 'spiderblocker'
		);
		?>
		<b><?php echo PHP_VERSION; ?></b></p>
	</div>
	<?php
	die();
}

// Initialize Plugin.
$niteo_spider_blocker = new SpiderBlocker();

add_action( 'upgrader_process_complete', array( &$niteo_spider_blocker, 'on_plugin_upgrade' ), 10, 2 );

// Activation Hook.
register_activation_hook( __FILE__, array( &$niteo_spider_blocker, 'activate_plugin' ) );

// Deactivation Hook.
register_deactivation_hook( __FILE__, array( &$niteo_spider_blocker, 'remove_block_rules' ) );