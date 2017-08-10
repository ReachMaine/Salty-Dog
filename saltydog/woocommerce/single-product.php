<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
/* mods:
 *	18Jun15 zig - add next previous to product.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); 
global $under_header_class, $of_cypress;
//
$header_icons				= $of_cypress['header_icons'];
$layout						= $of_cypress['layout'];
$single_full_width			= $of_cypress['single_full_width'];
/**
 * DISCARDED:
 * woocommerce_before_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
//do_action('woocommerce_before_main_content'); // COPIED TO "breadcrumb-slogans.php" file
?>
<header class="page-header">

	<?php	
	$shop_title_bcktoggle	= $of_cypress['shop_title_bcktoggle']; // if bckimg is set to true
	$shop_title_backimg		= $of_cypress['shop_title_backimg']; // general blog bckimg
	
	if( $shop_title_bcktoggle ) {

		$attach_ID			= get_post_thumbnail_id(); // featured image
		$custom_head_image	= get_post_meta( get_the_ID(), 'as_custom_head_image', true); // custom head image
		$custom_head_format	= get_post_meta( get_the_ID(), 'as_custom_head_image_format', true);
		$custom_head_repeat	= get_post_meta( get_the_ID(), 'as_custom_head_image_repeat', true);
		$custom_head_size	= get_post_meta( get_the_ID(), 'as_custom_head_image_size', true);
		
		$img_format = $custom_head_format ? $custom_head_format : 'as-landscape';
		
		if( $custom_head_repeat || $custom_head_size ) {
			echo '<style>';
			echo $custom_head_repeat ?	'background-repeat:'.$custom_head_repeat.';' : '';
			echo $custom_head_size ?	'background-size:'.$custom_head_size.';' : '';
			echo '</style>';
		}
		
		if( $custom_head_image ) { // if custom head image
			
			$image = wp_get_attachment_image_src( $custom_head_image , $img_format );
			$image = $image[0];
			
		}elseif( $attach_ID ){ // else if featured product (post thumbnail)
			
			$image = wp_get_attachment_image_src( $attach_ID, 'as-landscape' );
			$image = $image[0];
		
		}else{ // else do the theme options image
		
			$image =  $shop_title_backimg;
			
		}// or, no image
	
		echo'<div class="header-background" style="background-image: url('.$image.');"></div>';
	}
	?>

	<div class="grid-container">
	
		<div class="grid-100">
		
		<?php do_action( 'as_single_product_summary' ); ?>
		
		</div>
	
	</div>
	
</header>

<div class="grid-container">
	
	<div class="grid-100"><span class="title-border<?php echo !$header_icons ? '-no-icon' : null; ?>"></span></div>
	
</div>			


<div class="grid-container">
	<?php echo eai_prev_next_product(); /* zig - show next previous links */ ?>
	<div id="primary" class="grid-<?php echo ( $layout =='full_width' || $single_full_width ) ? '100' : '75'; ?> <?php echo $layout ? $layout : null; ?> tablet-grid-100 mobile-grid-100" role="main">
	
	<?php while ( have_posts() ) : the_post(); ?>

		<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>

	<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>

	</div>
	
	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		if( !$single_full_width	) {
			do_action('woocommerce_sidebar');
		}
		?>

</div><!-- /.container -->

<?php get_footer('shop'); ?>