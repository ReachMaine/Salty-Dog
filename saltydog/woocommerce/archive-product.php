<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); 
global $under_header_class, $of_cypress,  $border_decor;
//
$header_icons				= $of_cypress['header_icons'];
$layout						= $of_cypress['layout'];
$products_full_width		= $of_cypress['products_full_width'];
//
?>

<?php
	/**
	 * woocommerce_before_main_content hook
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	
	do_action('woocommerce_before_main_content'); // COPIED TO "breadcrumbs.php" file in theme root
	*/ 
?>

<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

<header class="page-header<?php echo $under_header_class;?>">
	
	<?php	
	$shop_title_bcktoggle = $of_cypress['shop_title_bcktoggle'];
	$shop_title_backimg = $of_cypress['shop_title_backimg'];
	if( $shop_title_bcktoggle ) {
		
		if(  is_tax( 'product_cat' ) ){
			// $term - current taxonomy term id
			$term = get_term_by('slug', esc_attr( get_query_var('product_cat') ), 'product_cat');
			// woocommerce meta - thumbnail_id:
			$thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id' );
		}else{
			$thumbnail_id = '';
		}
		
		if( $thumbnail_id ) {
			// get image by attachment id:
			$image = wp_get_attachment_image_src( $thumbnail_id, 'as-landscape' );
			$image = $image[0];
		}else{
			$image =  $shop_title_backimg;
		}
		
		echo'<div class="header-background" style="background-image: url('.$image.');"></div>';
	}
	?>
	
	<div class="grid-container">
	
		<div class="grid-100">
		
			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
			
			<?php do_action( 'woocommerce_archive_description' ); ?>	
			
		</div><!-- .grid-container -->
		
	</div><!-- .grid-container -->

	

</header>


<div class="grid-container">
	
	<div class="grid-100"><span class="title-border<?php echo !$header_icons ? '-no-icon' : null; ?>"></span></div>
	
</div>			


<?php endif; ?>

<div class="grid-container zarchiveproduct">

	<div id="primary" class="grid-<?php echo ( $layout =='full_width' || $products_full_width ) ? '100' : '70'; ?> <?php echo $layout ? $layout : null; ?> tablet-grid-100 mobile-grid-100" role="main">
	
		<?php		
		
		if ( is_active_sidebar( 'product-filters-widgets' ) ) {
			
			echo '<div class="product-filters-wrap">';

			echo '<div class="product-filters">';
			
			echo '<span class="fs" data-icon="&#xe09c;"></span>';	
			
				dynamic_sidebar( 'product-filters-widgets' ); 
				
				dynamic_sidebar( 'layered-nav-filter-widgets' ); 
				
			
			echo '<div class="clearfix"></div></div>';
			
			echo '<h4 class="product-filters-title">'. __('Product filters','cypress') .'</h4>';
			
			echo '<div class="article-border '. $border_decor .'"></div>';
			
			echo '</div>'; // product-filters-wrap 
			
			echo '<div class="product-filters-clearer"></div>';
		
		}
		
		//META BOX FROM SHOP PAGE - insert meta content ( wyswyg ) before and/or after products:
		
		$before_catalog		= get_post_meta( wc_get_page_id('shop'), 'as_before_catalog', true);
		$after_catalog		= get_post_meta( wc_get_page_id('shop'), 'as_after_catalog', true);
		
		echo '<div class="before-catalog">'. do_shortcode($before_catalog) .'</div>';
		
		?>
		<div class="clearfix"></div>
		
		<?php if ( have_posts() ) : ?>

			<?php
			
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );

			?>
			
			<div class="clearfix"></div>
			
			<?php woocommerce_product_subcategories(array('before'=>'<h2 class="categories-title block-title ">'.__('Product categories','cypress').'</h2><div class="product-categories">', 'after'=>'<div class="clearfix"></div></div>', 'force_display'=> true)); ?>
				
			<?php woocommerce_product_loop_start(); ?>
				
			
			<?php while ( have_posts() ) : the_post(); ?>

				<?php woocommerce_get_template_part( 'content', 'product' ); ?>
					
			<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

		<?php
			/**
			 * woocommerce_after_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action('woocommerce_after_main_content');
			
			echo '<div class="after-catalog">'. do_shortcode($after_catalog) .'</div>';
			
		?>

	</div><!-- #primary -->
	
	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		
		if ( !$products_full_width ) { 
			do_action('woocommerce_sidebar');
		}
	?>

</div><!-- .grid-container -->

<?php get_footer('shop'); ?>