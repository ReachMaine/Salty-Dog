<?php
/**
 *	Template part: Header mobile 
 *
 *	template for mobile devices - logo, main menu etc.
 */
/* 
* 29May15 zig - put addess under logo for description instead of site-description.
*/ 
global $of_cypress, $woo_is_active, $border_decor;
?>

<div class="grid-container clearfix">

	<div id="site-title" class="grid-100">
				
		<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> | <?php bloginfo( 'description' );?>" rel="home">
		
		
		<h1>
		
			<?php 
			$logo = $of_cypress['site_logo'];
			$logo_on =  !empty ( $of_cypress['logo_desc']['logo_on'] );
			$desc_on =  !empty ( $of_cypress['logo_desc']['desc_on'] );
			if ( $logo_on &&  $logo  ) {
				/* 
				if( function_exists('getimagesize') ) {
				
					list($img_W, $img_H) = getimagesize( $logo );
					$logo_src	= 'src="' . fImg::resize(  $logo , $img_W, $img_H, true  ) .'"';
					
				}else{
					$logo_src	= 'src="'. $logo .'"';
				}
				*/
				$logo_src	= 'src="'. $logo .'"';
			?>
				<img <?php echo $logo_src; ?> title="<?php bloginfo( 'name' ); ?> | <?php bloginfo( 'description' );?>"  alt="<?php bloginfo( 'name' ); ?>" />
			
			<?php } else { ?>
			
				<span><?php bloginfo( 'name' ); ?></span>
				
			<?php } ?>
		
		</h1>
		
		</a>
		
		<?php if ( $desc_on ) { ?>
			<?php /* <div id="site-description"><?php bloginfo( 'description' ); ?></div> */ ?>
			<div id="site-description">173 Main Street<br>Prospect Harbor, Maine<br><a src="tel:2079637575">207-963-7575</a></div>
		<?php } ?>
		
	</div>

	<div class="mobile-sticky">
	
	
	<div class="menu-toggler"><a href="#" title="<?php echo __('Toggle menu','cypress') ;?>" class="button iconized-button"><span class="fs" data-icon="&#xe05a;"></span></a></div>

	<div class="mobile-dropdown">
	
		<?php
		if( isset( $of_cypress['mobile_header_blocks']['enabled'] ) ) {
		
			$headblocks = $of_cypress['mobile_header_blocks']['enabled'];
			
			foreach ( $headblocks as $block ) {
			
				$block_array_check =  strpos( $block, "|");
				// if are saved as resizable
				if( $block_array_check ) {
				
					$bl =  explode("|", $block ); // $bl[0] - block name, $bl[1] - block width
					
					switch ( $bl[0] ) {
					
						case 'Border block' :
						
						echo '<div class="menu-border '.$border_decor.'"></div>';
						
						break;
						//////////////////////////////////////////
						case 'Shopping cart' :
						
						/**
						 *	IF WOOCOMMERCE is ACTIVATED
						 *
						 */
						if ( $woo_is_active ) {
						
							global $woocommerce;
							
							echo '<div style="position:relative;">';
							
							$cart_count = $woocommerce->cart->cart_contents_count;
							$cart_link = get_permalink( woocommerce_get_page_id( 'cart' ));
							echo $cart_count ? '<a href="'. $cart_link .'" class="header-cart">' : '<div class="header-cart">';
							?>
								<div class="fs" aria-hidden="true" data-icon="&#x56;"></div>
								
								<span class="cart-contents">
								<?php 
								echo sprintf(_n('<span class="count">%d</span>', '<span class="count">%d</span>', $woocommerce->cart->cart_contents_count, 'cypress'), $woocommerce->cart->cart_contents_count);?>
								<?php echo $woocommerce->cart->get_cart_total(); ?>
								</span>
								<div class="clearfix"></div>

							<?php echo $cart_count ? '</a>' : '</div>';
						
							echo '</div>';
						
						} // endif $woo_is_active
						
						break;
						//////////////////////////////////////////
						case 'Menu one' :
						case 'Menu mobile' :
						?>
						<nav id="main-nav-wrapper" class="grid-100">
							
							<?php 
							$walker = new My_Walker;
							wp_nav_menu( array( 
									'theme_location'	=> 'main-mobile',
									//'menu'			=> 'Main menu',
									'walker'			=> $walker,
									'link_before'		=>'',
									'link_after'		=>'',
									'menu_id'			=> 'main-nav',
									'menu_class'		=> 'navigation ',
									'container'			=> false
									) 
								);
							?>
							
						</nav>
						<div class="clearfix"></div>
						
						
						<?php 
						break;
						//////////////////////////////////////////
						case 'Simple search' :
						
							get_template_part('searchform','menu');
						
						break;
						//////////////////////////////////////////
						
						case 'Social block' :
						?>
						<div id="social" class="social grid-100">

						<?php
						$target = $of_cypress['soc_rss'] ? ' target="_blank" ' : '';
						
						echo ( $of_cypress['soc_rss'] ? '<div><a href="'.get_bloginfo('url').'/feed" title="RSS" class="fs" aria-hidden="true" data-icon="&#xe112;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_facebook'] ? '<div><a href="'.$of_cypress['soc_facebook'].'" title="Facebook" class="fs" aria-hidden="true" data-icon="&#xe10d;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_twitter'] ? '<div><a href="'.$of_cypress['soc_twitter'].'" title="Twitter" class="fs" aria-hidden="true" data-icon="&#xe111;"'.$target.'></a></div>' : '' );			echo ( $of_cypress['soc_linkedin'] ? '<div><a href="'.$of_cypress['soc_linkedin'].'" title="LinkedIn" class="fs" aria-hidden="true" data-icon="&#xe141;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_gplus'] ? '<div><a href="'.$of_cypress['soc_gplus'].'" title="Google plus" class="fs" aria-hidden="true" data-icon="&#xe109;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_youtube'] ? '<div><a href="'.$of_cypress['soc_youtube'].'" title="You Tube" class="fs" aria-hidden="true" data-icon="&#xe115;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_flickr'] ? '<div><a href="'.$of_cypress['soc_flickr'].'" title="Flickr" class="fs" aria-hidden="true" data-icon="&#xe11e;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_vimeo'] ? '<div><a href="'.$of_cypress['soc_vimeo'].'" title="Vimeo" class="fs" aria-hidden="true" data-icon="&#xe118;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_pinterest'] ? '<div><a href="'.$of_cypress['soc_pinterest'].'" title="Pinterest" class="fs" aria-hidden="true" data-icon="&#xe148;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_dribbble'] ? '<div><a href="'.$of_cypress['soc_dribbble'].'" title="Dribbble" class="fs" aria-hidden="true" data-icon="&#xe123;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_forrst'] ? '<div><a href="'.$of_cypress['soc_forrst'].'" title="Forrst" class="fs" aria-hidden="true" data-icon="&#xe125;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_instagram'] ? '<div><a href="'.$of_cypress['soc_instagram'].'" title="Instagram" class="fs" aria-hidden="true" data-icon="&#xe10e;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_github'] ? '<div><a href="'.$of_cypress['soc_github'].'" title="Github" class="fs" aria-hidden="true" data-icon="&#xe12c;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_picassa'] ? '<div><a href="'.$of_cypress['soc_picassa'].'" title="Picassa" class="fs" aria-hidden="true" data-icon="&#xe11f;"'.$target.'></a></div>' : '' );
						echo ( $of_cypress['soc_skype'] ? '<div><a href="'.$of_cypress['soc_skype'].'" title="Skype" class="fs" aria-hidden="true" data-icon="&#xe13f;"'.$target.'></a></div>' : '' );
						?>
						</div>
						<?php
						
						break;
						//////////////////////////////////////////
						case 'Products search' :
						
						$woo_is_active ? as_get_product_search_form() : null;
						
						break;
						//////////////////////////////////////////
						case 'Widgets block' :
						
						if ( is_active_sidebar( 'sidebar-header' ) ) {
						
							dynamic_sidebar( 'sidebar-header' ); 
							
						}
						
						break;
						//////////////////////////////////////////
						case 'Widgets block 2' :
						
						if ( is_active_sidebar( 'sidebar-header-2' ) ) {
							
							dynamic_sidebar( 'sidebar-header-2' ); 
							
						}
						
						break;
						//////////////////////////////////////////
						case 'Widgets block 3' :
						
						if ( is_active_sidebar( 'sidebar-header-3' ) ) {
							
							dynamic_sidebar( 'sidebar-header-3' ); 
							
						}
						
						break;
						}
				}
			}
		
		}
		?>
	</div>
	
	</div>
	
	
</div>