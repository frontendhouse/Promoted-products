<?php

namespace FH\PromotedProducts\Admin;

use FH\PromotedProducts\PluginDetails;

/**
 * Class Init
 * This class initializes the plugin.
 **/
class ProductDataTab {
	use PluginDetails;

	/**
	 * Integrates with WordPress hooks and filters.
	 */
	public function hooks() {
		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'promotion_settings' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'update_promotion_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'promotion_settings_script' ) );
	}

	/**
	 * Promotion setting fields visible in General tab.
	 */
	public function promotion_settings() {
		$hidden = ! get_post_meta( get_the_ID(), '_pp_promoted', true );
		woocommerce_wp_checkbox(
			array(
				'id'    => '_pp_promoted',
				'label' => __( 'Promote this product?', 'fh' ),
			)
		);
		woocommerce_wp_text_input(
			array(
				'type'          => 'text',
				'id'            => '_pp_custom_title',
				'label'         => __( 'Product Custom Title', 'fh' ),
				'description'   => __( 'Leave blank to use product title', 'fh' ),
				'wrapper_class' => $hidden ? 'hidden' : '',
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'            => '_pp_expiration',
				'label'         => __( 'Timed promotion', 'fh' ),
				'wrapper_class' => $hidden ? 'hidden' : '',
			)
		);
		woocommerce_wp_text_input(
			array(
				'type'              => 'datetime-local',
				'id'                => '_pp_expiration_date',
				'label'             => __( 'Promotion ends date', 'fh' ),
				'description'       => __( 'Set date and time when product promotion ends', 'fh' ),
				'wrapper_class'     => ! get_post_meta( get_the_ID(), '_pp_expiration', true ) || $hidden ? 'hidden' : '',
				'default'           => wp_date( 'Y-m-d\TH:i' ),
				'custom_attributes' => array(
					'step' => 1,
					'min'  => wp_date( 'Y-m-d\TH:i' ),
				),
			)
		);
	}

	/**
	 * Save or delete fields value to the product.
	 *
	 * @param int $post_id WP_Post id.
	 *
	 * @return void
	 */
	public function update_promotion_settings( $post_id ) {
		$product = wc_get_product( $post_id );
		// phpcs:disable WordPress.Security.NonceVerification.Missing
		if ( isset( $_POST['_pp_promoted'] ) ) {
			$product->update_meta_data( '_pp_promoted', sanitize_key( $_POST['_pp_promoted'] ) );
			$product->update_meta_data( '_pp_update', wp_date( 'Y-m-d H:i:s' ) );
			if ( ! empty( $_POST['_pp_custom_title'] ) ) {
				$product->update_meta_data( '_pp_custom_title', sanitize_text_field( wp_unslash( $_POST['_pp_custom_title'] ) ) );
			} else {
				$product->delete_meta_data( '_pp_custom_title' );
			}
			$product->update_meta_data( '_pp_expiration', sanitize_key( $_POST['_pp_expiration'] ) );
			if ( isset( $_POST['_pp_expiration'] ) && ! empty( $_POST['_pp_expiration_date'] ) ) {
				$expiration = sanitize_text_field( $_POST['_pp_expiration_date'] );
				$expiration = gmdate( 'Y-m-d H:i:s', strtotime( $expiration ) );
				$product->update_meta_data( '_pp_expiration_date', $expiration );
			} else {
				$product->delete_meta_data( '_pp_expiration' );
				$product->delete_meta_data( '_pp_expiration_date' );
			}
		} else {
			$product->delete_meta_data( '_pp_promoted' );
			$product->delete_meta_data( '_pp_update' );
			$product->delete_meta_data( '_pp_custom_title' );
			$product->delete_meta_data( '_pp_expiration' );
			$product->delete_meta_data( '_pp_expiration_date' );
		}
		$product->save();
	}

	/**
	 * Add script for hiding or revealing inputs.
	 *
	 * @param string $hook The current admin page.
	 *
	 * @return void
	 */
	public function promotion_settings_script( $hook ) {
		if ( 'post.php' === $hook ) {
			wp_enqueue_script( 'promoted_products', $this->get_plugin_dir_url() . 'assets/admin/product.js', array(), $this->get_plugin_version(), true );
		}
	}

}