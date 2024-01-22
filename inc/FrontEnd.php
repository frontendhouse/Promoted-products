<?php

namespace FH\PromotedProducts;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Init
 * This class initializes the plugin.
 **/
class FrontEnd {
	use PluginDetails;
	use GetPromotedProducts;

	/**
	 * Integrates with WordPress hooks and filters.
	 */
	public function hooks() {
		add_action( 'storefront_header', array( $this, 'promoted_products_widget' ), 70 );
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
	}

	/**
	 * Add promoted product section.
	 */
	public function promoted_products_widget() {
		$product = $this->get_product();
		if ( is_wp_error( $product ) ) {
			return;
		}
		$title         = get_option( 'pp_title' );
		$title         = ! empty( $title ) ? $title : __( 'Flash Sale!', 'fh' );
		$product_title = get_post_meta( $product->ID, '_pp_custom_title', true );
		$product_title = ! empty( $product_title ) ? $product_title : $product->post_title;
		$product_link  = get_permalink( $product );
		include $this->get_plugin_dir() . 'templates/frontend/promoted-product.php';
	}

	/**
	 * Add plugin style to the frontend.
	 */
	public function styles() {
		wp_enqueue_style( 'promoted-products', $this->get_plugin_dir_url() . 'assets/frontend/promoted-products.css', null, $this->get_plugin_version() );
		$text_color       = get_option( 'pp_text_color' );
		$text_color       = ! empty( $text_color ) ? $text_color : '#000000';
		$background_color = get_option( 'pp_background_color' );
		$background_color = ! empty( $background_color ) ? $background_color : '#fcf400';
		$custom_css       = "
		:root {
			--pp-text-color: {$text_color};
			--pp-background-color: {$background_color};
		}
		";
		wp_add_inline_style( 'promoted-products', $custom_css );
	}



}