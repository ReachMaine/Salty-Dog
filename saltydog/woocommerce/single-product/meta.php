<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
/* 
	28May15 zig - dont display the "Categories:" text.
	29May15 zig - dont display "Tags" text
	17Jun15 zig - dont display tags at all
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span>.</span>

	<?php endif; ?>

	
	<?php echo $product->get_categories( ', ', '<span class="posted_in"><span class="icon-folder meta-icon"></span>  ', '.</span>' ); ?>

	<?php /* echo $product->get_tags( ', ', '<span class="tagged_as"><span class="icon-tags meta-icon"></span> ', '.</span>' ); */ ?>
	

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>