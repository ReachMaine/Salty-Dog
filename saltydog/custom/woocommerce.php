<?php 
/* woocommerce customizations 
*/

// add link back to order in admin email 
add_action( 'woocommerce_email_after_order_table', 'add_link_back_to_order', 10, 2 );
function add_link_back_to_order( $order, $is_admin ) {

	// Only for admin emails
	if ( ! $is_admin ) {
		return;
	}

	// Open the section with a paragraph so it is separated from the other content
	$link = '<p>';

	// Add the anchor link with the admin path to the order page
	$link .= '<a href="'. admin_url( 'post.php?post=' . absint( $order->id ) . '&action=edit' ) .'" >';

	// Clickable text
	$link .= __( 'Click here to go to view the order', 'your_domain' );

	// Close the link
	$link .= '</a>';

	// Close the paragraph
	$link .= '</p>';

	// Return the link into the email
	echo $link;

}

// to remove sku from everywhere....
add_filter( 'wc_product_sku_enabled', '__return_false' );

/* replacing action from cypress with ours */

	//remove_action( 'woocommerce_before_shop_loop_item_title', 'cypress_loop_product_thumbnail', 20 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'eai_loop_product_thumbnail', 20 );
	//
	if ( ! function_exists( 'eai_loop_product_thumbnail' ) ) {

		function eai_loop_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
			
			global $post, $product, $yith_wcwl, $of_cypress;
			
			$products_settings = !empty($of_cypress['products_settings']) ? $of_cypress['products_settings'] : '';
			
			// get image format from theme options:
			$of_imgformat = $of_cypress['shop_image_format'];
			if( $of_imgformat == 'as-portrait' ||  $of_imgformat == 'as-landscape' ){
				$img_format = $of_imgformat;
			}else{
				$img_format = 'shop_catalog';
			}
			
			$title = '<a href="' . get_permalink(). '" title="'. esc_attr( $post->post_title ) .'"><h3>'. get_the_title(). '</h3></a>';
			
			
			echo '<div class="front">';
			
			function_exists('woocommerce_show_product_loop_sale_flash') ? woocommerce_show_product_loop_sale_flash() : '';
				
			echo as_image( $img_format ); 
			
			echo '</div>';
			
			echo '<div class="back z">';
			
				//echo '<div class="item-overlay"></div>';
				echo '<a href="' . get_permalink(). '" title="'. esc_attr( $post->post_title ) .'"> <div class="item-overlay"></div></a>';
				echo $title;
				
				function_exists('woocommerce_template_loop_rating') ? woocommerce_template_loop_rating() : '';
				
				do_action( 'woocommerce_after_shop_loop_item_title' );
			
				$attachment_ids = $product->get_gallery_attachment_ids();
				
		
				
				if ( !empty($attachment_ids) ) {
					$image_url	= wp_get_attachment_image_src( $attachment_ids[0], 'large'  );
					$img_url	= $image_url[0];
					$imgSizes	= all_image_sizes(); // as custom fuction
					$img_width	= $imgSizes[$img_format]['width'];
					$img_height = $imgSizes[$img_format]['height'];
					
					echo '<img src="'. fImg::resize( $img_url ,$img_width, $img_height, true  ) .'" alt="'. esc_attr($post->post_title) .'" class="back-image" />';
										
				}else{
					echo as_image( $img_format );
				}
		
				echo '<div class="back-buttons">';
					
					if( !isset($products_settings['disable_zoom_button']) ) {
						echo '<a href="'.as_get_full_img_url().'" class="button" data-rel="prettyPhoto" title="'. esc_attr($post->post_title) .'"><div class="fs" aria-hidden="true" data-icon="&#xe022;"></div></a>';
					}
					if( !isset($products_settings['disable_link_button']) ) {
						echo '<a href="'. get_permalink() .'" class="button" title="'. esc_attr($post->post_title) .'"><div class="fs" aria-hidden="true" data-icon="&#xe065;"></div></a>';
					}
					
				
				echo '</div>';
				
			echo '</div>';

		}
	}
// make the related posts only filter by category only  and not tags.
//New "Related Products" function for WooCommerce
function get_related_custom( $id, $limit = 5 ) {
    global $woocommerce;

    // Related products are found from category and tag
    $cats_array = array(0);

    // Get tags
    /* $terms = wp_get_post_terms($id, 'product_tag');
    foreach ( $terms as $term ) $tags_array[] = $term->term_id; */

    // Get categories 
    $terms = wp_get_post_terms($id, 'product_cat');
    foreach ( $terms as $term ) $cats_array[] = $term->term_id;

    // Don't bother if none are set
    if ( sizeof($cats_array)==1 ) return array();

    // Meta query
    $meta_query = array();
    $meta_query[] = $woocommerce->query->visibility_meta_query();
    $meta_query[] = $woocommerce->query->stock_status_meta_query();

    // Get the posts
    $related_posts = get_posts( apply_filters('woocommerce_product_related_posts', array(
        'orderby'        => 'rand',
        'posts_per_page' => $limit,
        'post_type'      => 'product',
        'fields'         => 'ids',
        'meta_query'     => $meta_query,
        'post__no_in' 	 => array($id),
        'tax_query'      => array(
            array(
                'taxonomy'     => 'product_cat',
                'field'        => 'id',
                'terms'        => $cats_array
            )
        )
    ) ) );
    $related_posts = array_diff( $related_posts, array( $id ));
    return $related_posts;
}
add_action('init','get_related_custom');

function eai_prev_next_product() { 
	
	$output = '<nav class="nav nav-single">';
		
		$prev_icon = '<div class="fs" aria-hidden="true" data-icon="&#xe169;"></div>';
		$next_icon = '<div class="fs" aria-hidden="true" data-icon="&#xe16c;"></div>';
		
		$prevPost	= get_previous_post(true, '', 'product_cat'); // next product within category
		$prevURL	= $prevPost ? get_permalink($prevPost->ID) : '';
		$prevTitle	= $prevPost ? $prevPost->post_title : '';
		$prevPrefix = __('Previous entry: ','cypress');
		$nextPost	= get_next_post(true, '', 'product_cat');
		$nextURL	= $nextPost ? get_permalink($nextPost->ID) : '';
		$nextTitle	= $nextPost ? $nextPost->post_title : '';
		$nextPrefix = __('Next entry: ','cypress');
		
		if( $prevPost ) {
			$output .= '<span class="nav-previous">';
			$output .= '<a href="'. $prevURL .'" rel="prev" title="'. esc_attr($prevTitle) .'" class="left">';
			$output .= $prev_icon;
			$output .= '<span class="hover-box">'. $prevPrefix . esc_html($prevTitle).'<div class="arrow-down"></div></span>';
			$output .= '</a></span>';
		} else {
			$output .= '<!-- no previous post -->';
		}
		
		if( $nextPost ) {
			$output .= '<span class="nav-next">';
			$output .= 		'<a href="'. $nextURL .'" rel="next" title="'. esc_attr($nextTitle). '" class="right">';
			$output .= 		$next_icon;
			$output .= '<span class="hover-box">'. $nextPrefix . esc_html($nextTitle).'<div class="arrow-down"></div></span>';
			$output .= '</a></span>';
		} else {
			$output .= '<!-- no next post -->';
		}
		
	$output .= '</nav><!-- .nav-single -->';
	
	return $output;
}
?>