<?php

namespace FH\PromotedProducts;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Plugin Info
 * This class contains all plugin info like version, paths, urls, etc.
 **/
trait PluginDetails {

	/**
	 * Absolute path of the main plugin file.
	 *
	 * @return string
	 */
	protected function get_plugin_file(): string {
		return WP_PLUGIN_DIR . '/promoted-products/promoted-products.php';
	}

	/**
	 * Parses the plugin contents to retrieve plugin’s metadata from promoted-products.php file.
	 *
	 * @return array
	 */
	protected function get_plugin_data(): array {
		if ( ! function_exists( 'get_plugin_data' ) ) :
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		endif;
		return get_plugin_data( $this->get_plugin_file() );
	}

	/**
	 * Gets plugin name from plugins metadata.
	 *
	 * @return string
	 */
	protected function get_plugin_name(): string {
		if ( isset( $this->get_plugin_data()['Name'] ) ) {
			return $this->get_plugin_data()['Name'];
		}
		return '';
	}


	/**
	 * Gets plugin version from plugins metadata.
	 *
	 * @return string
	 */
	protected function get_plugin_version(): string {
		if ( isset( $this->get_plugin_data()['Version'] ) ) {
			return $this->get_plugin_data()['Version'];
		}
		return '';
	}

	/**
	 * Gets plugin author from plugins metadata.
	 *
	 * @return string
	 */
	protected function get_plugin_author(): string {
		if ( isset( $this->get_plugin_data()['AuthorName'] ) ) {
			return $this->get_plugin_data()['AuthorName'];
		}
		return '';
	}


	/**
	 *  Gets extracted name of the plugin from its filename
	 *
	 * @return string
	 */
	protected function get_plugin_basename(): string {
		return plugin_basename( $this->get_plugin_file() );
	}

	/**
	 *  The filesystem path of the directory that contains the plugin.
	 *
	 * @return string
	 */
	protected function get_plugin_dir(): string {
		return plugin_dir_path( $this->get_plugin_file() );
	}

	/**
	 * Get the URL directory path (with trailing slash) for the plugin.
	 *
	 * @return string
	 */
	protected function get_plugin_dir_url(): string {
		return plugin_dir_url( $this->get_plugin_file() );
	}


	/**
	 *  Get plugin translation files dir path.
	 *
	 * @return string
	 */
	protected function get_plugin_language_dir(): string {
		if ( isset( $this->get_plugin_data()['DomainPath'] ) ) {
			return $this->get_plugin_dir() . str_replace( '/', '', $this->get_plugin_data()['DomainPath'] );
		}
		return '';
	}

	/**
	 * Get minimal WordPress version required by the plugin.
	 *
	 * @return float
	 */
	protected function get_plugin_required_wp(): float {
		if ( isset( $this->get_plugin_data()['RequiresWP'] ) ) {
			return (float) $this->get_plugin_data()['RequiresWP'];
		}
		return 0;
	}

	/**
	 * Get minimal PHP version required by the plugin.
	 *
	 * @return float
	 */
	protected function get_plugin_required_php(): float {
		if ( isset( $this->get_plugin_data()['RequiresPHP'] ) ) {
			return (float) $this->get_plugin_data()['RequiresPHP'];
		}
		return 0;
	}

}
