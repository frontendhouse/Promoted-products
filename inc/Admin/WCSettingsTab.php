<?php

namespace FH\PromotedProducts\Admin;

use FH\PromotedProducts\PluginDetails;
use FH\PromotedProducts\GetPromotedProducts;

/**
 * Class Init
 * This class initializes the plugin.
 **/
class WCSettingsTab {
	use PluginDetails;
	use GetPromotedProducts;

	/**
	 * Integrates with WordPress hooks and filters.
	 */
	public function hooks() {
		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab' ), 21 );
		add_action( 'woocommerce_settings_promoted_products', array( $this, 'tab_content' ) );
		add_action( 'woocommerce_settings_save_promoted_products', array( $this, 'update_settings' ) );
	}

	/**
	 * Register new Promoted Products tab for WooCommerce settings tabs.
	 *
	 * @param array $tabs WC Settings tabs.
	 *
	 * @return array
	 */
	public function add_settings_tab( $tabs ) {
		$tabs['promoted_products'] = __( 'Promoted Products', 'fh' );
		return $tabs;
	}

	/**
	 * Promoted Products settings tab content.
	 */
	public function tab_content() {
		woocommerce_admin_fields( $this->settings() );
		$this->currently_promoted_products();
	}

	/**
	 * Save Promoted Products settings tab input fields values.
	 */
	public function update_settings() {
		woocommerce_update_options( $this->settings() );
	}

	/**
	 * Get array with plugin settings.
	 *
	 * @return array
	 */
	private function settings(): array {
		return array(
			'section_title'    => array(
				'name' => __( 'Promoted Products Settings', 'fh' ),
				'type' => 'title',
			),
			'title'            => array(
				'name'        => __( 'Title', 'fh' ),
				'type'        => 'text',
				'desc'        => __( 'Title is displayed over promoted products.', 'fh' ),
				'placeholder' => __( 'Flash Sale!', 'fh' ),
				'id'          => 'pp_title',
			),
			'background_color' => array(
				'type'        => 'color',
				'name'        => __( 'Background color', 'fh' ),
				'desc'        => __( 'Pick a background color for the promoted products.', 'fh' ),
				'placeholder' => '#fcf400',
				'id'          => 'pp_background_color',
			),
			'text_color'       => array(
				'type'        => 'color',
				'name'        => __( 'Text color', 'fh' ),
				'desc'        => __( 'Pick a text color for the promoted products.', 'fh' ),
				'placeholder' => '#000000',
				'id'          => 'pp_text_color',
			),
			'section_end'      => array(
				'type' => 'sectionend',
			),
		);
	}

	/**
	 * Display currently promoted products.
	 */
	private function currently_promoted_products() {
		$products = $this->get_products();
		if ( count( $products ) ) {
			include $this->get_plugin_dir() . 'templates/admin/currently-promoted-list.php';
		}
	}

}
