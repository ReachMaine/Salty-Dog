<?php
/**
 * The Template for displaying all single posts.
 *
 * @since Cypress 1.0
 */
get_header();
global $of_cypress;
$header_icons = $of_cypress['header_icons'];
$layout = $of_cypress['layout'];
//
// POST CUSTOM META
$hide_title			= get_post_meta( get_the_ID() ,'as_hide_title', true);
$hide_feat_img		= get_post_meta( get_the_ID() ,'as_hide_featured_image', true);
//if video post format:
$featured_or_thumb	= get_post_meta( get_the_ID(),'as_video_thumb', true);
?>


<header class="page-header">

	<?php	
	$single_blog_title_bcktoggle = $of_cypress['single_blog_title_bcktoggle']; // if bckimg is set to true
	$blog_title_backimg = $of_cypress['blog_title_backimg']; // general blog bckimg 
	// custom header image:
	$custom_head_image	= get_post_meta( get_the_ID(), 'as_custom_head_image', true); // custom head image
	$custom_head_format	= get_post_meta( get_the_ID(), 'as_custom_head_image_format', true);
	$custom_head_repeat	= get_post_meta( get_the_ID(), 'as_custom_head_image_repeat', true);
	$custom_head_size	= get_post_meta( get_the_ID(), 'as_custom_head_image_size', true);
	
	if( $single_blog_title_bcktoggle && !$hide_feat_img ) {
		
		if( get_post_format() == 'gallery' ) {
			// WP gallery ID's
			$wpgall_id = apply_filters('as_wpgallery_ids','ids_wp_gallery');
			//
			// image ID's from custom meta (AS GALLERY):
			$gall_img_array = get_post_meta( get_the_ID(),'as_gallery_images');
			$images_ids = array();
			if( isset( $gall_img_array ) ) {
				foreach ( $gall_img_array as $gall_img_id ){
					$images_ids[] = $gall_img_id; 
				}
			}
			if( !empty($wpgall_id) ) {
				$attach_ID = $wpgall_id[0]; // get first image from WP gallery
			}elseif( !empty($images_ids) ){
				$attach_ID = $images_ids[0]; // get first image from AS gallery
			}else{
				$attach_ID = '';
			}
		}elseif( $custom_head_image ){
		
			$attach_ID = $custom_head_image;
		
		}elseif( has_post_thumbnail()){
			
			$attach_ID = get_post_thumbnail_id();
		
		}else{
			$attach_ID = '';
		}
		
		
		
		if( $attach_ID ) { // if galleries or post thumbnails
		
			$image = wp_get_attachment_image_src( $attach_ID, 'as-landscape' );
			$image = $image[0];
			
		}elseif( get_post_format() == 'video' && $featured_or_thumb == 'host_thumb') { // if video host thumb
			
			$image =  video_thumbs();
		
		}else{ // else do the theme options image
			$image =  $blog_title_backimg;
		}// or, no image
			
		echo'<div class="header-background" style="background-image: url('.$image.');"></div>';
	}
	?>

	<div class="grid-container">
	
		<div class="grid-100">
		
		<h1 class="page-title"><?php the_title(); ?></h1>
	
		<?php
		global $wp_query;
		$thisID = $wp_query->post->ID;
		$tagline = get_post_meta( $thisID, 'as_tagline', true) ; 

		if( $tagline ) {
		?>
		<div class="tagline"><?php echo $tagline; ?></div>
		
		<?php };?>
		
		</div>
	
	</div>
	
</header>


<div class="grid-container">
	
	<div class="grid-100"><span class="title-border<?php echo !$header_icons ? '-no-icon' : null; ?>"></span></div>
	<?php echo as_prev_next_post();?>
</div>			

	
<div class="grid-container">


		
	<div id="primary" class="grid-<?php echo ($post_type == 'portfolio'|| $layout =='full_width' ) ? '100' : '75'; ?> <?php echo $layout ? $layout : null; ?> tablet-grid-100 mobile-grid-100" role="main">

		
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php comments_template( '', true ); ?>

		<?php endwhile; ?>


	</div><!-- #primary -->

	<?php 
	if( $post_type != 'portfolio' && $layout != 'full_width' ) {
		
		get_sidebar();
		
	}
	?>
		
</div><!-- /.grid-container -->
	
<?php get_footer(); ?>