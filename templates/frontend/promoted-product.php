<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Admin list of currently promoted products.
 *
 * @var string $title Widget title.
 * @var string $product_title Product title.
 * @var string $product_link Product url.
 **/
?>
<div class="promoted-products">
    <div class="promoted-products__wrapper col-full">
        <span class="promoted-products__title"><?php echo esc_html( $title ); ?></span>
        <a class="promoted-products__link" href="<?php echo esc_url( $product_link ); ?>"><?php echo esc_html( $product_title ); ?></a>
    </div>
</div>