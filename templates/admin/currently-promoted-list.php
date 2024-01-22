<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Admin list of currently promoted products.
 *
 * @var array $products Array of currently promoted products.
 **/
?>
<table class="form-table">
	<tr>
		<th>
			<label><?php esc_html_e( 'Currently promoted', 'fh' ); ?></label>
		</th>
		<td>
			<ul style="margin: 0;">
				<?php foreach ( $products as $product ) : ?>
					<li><a href="<?php echo esc_url( get_edit_post_link( $product ) ); ?>"><?php echo esc_html( $product->post_title ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</td>
	</tr>
</table>