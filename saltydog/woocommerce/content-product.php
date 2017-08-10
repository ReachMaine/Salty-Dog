<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop,  $of_cypress, $yith_wcwl, $wp_query, $of_cypress;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) 
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', loop_columns() );

// Ensure visibility
if ( ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

$classes = array();
// Extra post classes

if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
 
// Cypress theme edit:
// get total products:
$total = $wp_query->found_posts;
// for unsemantic responsive grid:
if( $total == 1 ) {
	$oe = '100';
}elseif( $woocommerce_loop['columns'] % 2 == 0 ){ // more then 1 item and even
	$oe = '50';
}else{		// more then 1 item and odd
	$oe = '33';
};

//
// Cypress theme edit: set grid by columns number
$classes[] = 'grid-' . floor( 100 / $woocommerce_loop['columns'] ) ;
// Cypress theme edit: add grid css and flipping effect css (for jQuery)
$classes[] = 'item tablet-grid-'.$oe. ' mobile-grid-100 scroll';

?>
<li <?php post_class( $classes ); ?>>

	<div class="item-content">
	
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		
		<div class="item-img zimage">
		
		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
			
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>

		</div>
	
		<?php 
		
		$buttons = isset($of_cypress['catalog_buttons']) ? $of_cypress['catalog_buttons'] : null;
		
		if( $buttons && $buttons == 'quick_view' ) {
		
			echo '<div class="quick-view-holder"><a href="#qv-holder" class="button quick-view"   title="'. esc_attr(strip_tags(get_the_title())) .'" data-id="'.$id.'">'.__('Quick view','cypress').'</a>';
			
			do_action('as_wishlist_button');
			
			echo '</div>';
								
			if ( !wp_script_is( 'wc-add-to-cart-variation', 'enqueued' )) {
			
				wp_register_script( 'wc-add-to-cart-variation', WP_PLUGIN_DIR . '/woocommerce/assets/frontend/add-to-cart-variation.min.js');
				wp_enqueue_script( 'wc-add-to-cart-variation' );
				
			}		
		
		}else{
		
			do_action( 'woocommerce_after_shop_loop_item' );
		
		}
		
		?>
		
	</div><!-- .item-content -->
		
	<div class="item-text">
		
		<?php
			
			//do_action( 'woocommerce_after_shop_loop_item' ); 
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 
			do_action( 'woocommerce_after_shop_loop_item_title' );
			*/

			/* 
			// IF THERE IS YITH WOOCOMPARE PLUGIN ACTIVATED:
			if( defined( 'YITH_WOOCOMPARE' ) ) {
					
				echo '<div class="compare-holder"><span class="icon-file icon"></span>';
				echo '<div class="hover-box">';
				
				$as_compare = new YITH_Woocompare_Frontend; // class in woocommerce-theme-edits.php
					echo $as_compare->compare_button_sc( $atts = '' );
					
				echo '<div class="arrow-down"></div></div></div>';
				
			}
			*/	
			 
		?>
		<div class="clearfix"></div>
		
		</div>

	<?php ?>
	
	

</li>