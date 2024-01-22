<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           Promoted Products
 *
 * @wordpress-plugin
 * Plugin Name:       Promoted Products
 * Plugin URI:        http://example.com/devmaestro-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mateusz Major
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fh
 * Domain Path:       /languages
 * WC requires at least: 3.0.0
 * Requires at least: 5
 * Requires PHP:      7
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
// Autoload.
require_once __DIR__ . '/vendor/autoload.php';

use FH\PromotedProducts\Main;

$main = new Main();
$main->hooks();
