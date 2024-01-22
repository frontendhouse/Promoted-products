<?php

namespace FH\PromotedProducts;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

use FH\PromotedProducts\Admin\ProductDataTab;
use FH\PromotedProducts\Admin\WCSettingsTab;

/**
 * Class Init
 * This class initializes the plugin.
 **/
class Main {
	use PluginDetails;

	/**
	 * Integrates with WordPress hooks and filters.
	 */
	public function hooks() {
		if ( is_admin() ) {
			$settings_tab = new WCSettingsTab();
			$settings_tab->hooks();
			$product_datatab = new ProductDataTab();
			$product_datatab->hooks();
		} else {
			$frontend = new FrontEnd();
			$frontend->hooks();
		}
	}

}