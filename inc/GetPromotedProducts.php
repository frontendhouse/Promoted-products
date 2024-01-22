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
trait GetPromotedProducts {

	/**
	 * Get promoted product.
	 *
	 * @param int $limit No of products to query.
	 *
	 * @return array
	 */
	protected function get_products( $limit = -1 ) {
		$products = new \WP_Query(
			array(
				'post_type'      => 'product',
				'meta_key'       => '_pp_update',
				'meta_type'      => 'DATETIME',
				'orderby'        => 'meta_value',
				'order'          => 'DESC',
				'posts_per_page' => $limit,
				'meta_query'     => array(
					'relation' => 'OR',
					array(
						'relation' => 'AND',
						array(
							'key'     => '_pp_promoted',
							'value'   => 'yes',
							'compare' => '=',
						),
						array(
							'key'     => '_pp_expiration',
							'compare' => 'NOT EXISTS',
						),
					),
					array(
						'relation' => 'AND',
						array(
							'key'     => '_pp_promoted',
							'value'   => 'yes',
							'compare' => '=',
						),
						array(
							'key'     => '_pp_expiration_date',
							'value'   => wp_date( 'Y-m-d H:i:s' ),
							'type'    => 'DATETIME',
							'compare' => '>',
						),
					),
				),
			)
		);
		return $products->posts;
	}

	/**
	 * Get promoted product.
	 *
	 * @return \WP_Post|\WP_Error
	 */
	protected function get_product() {
		$product = $this->get_products( 1 );
		if ( $product ) {
			return $product[0];
		}
		return new \WP_Error( 'no product', 'There is no product to promote' );
	}

}
