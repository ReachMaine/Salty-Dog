<!DOCTYPE html>
<?php 
/* 13jul15 zig : add call to gtm plugin */
//  GLOBAL OPTIONS DATA
global $of_cypress, $woo_is_active;
//
// CHECK IF IT'S HTTPS
if ( !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ) {
	$of_cypress =  str_replace("http://", "https://", $of_cypress);
}
?>
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>

<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<?php if ( version_compare( $wp_version , "4.1" ) < 0 ) { ?>
<title><?php wp_title( '|', true, 'right' );?></title>
<?php }?>

<?php /* zig remove as recommended by Yoast SEO
<meta name="description" content="<?php bloginfo( 'description' );?>" /> */ ?>
<meta name="author" content="<?php the_author_meta('display_name', 1); ?>" />

<?php $favicon = $of_cypress['custom_favicon']; ?>

<!-- Fav and touch icons -->
<link rel="shortcut icon" href="<?php echo  fImg::resize( $favicon , 32, 32, true  )?>">

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo  fImg::resize( $favicon , 144, 144, true  )?>">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo  fImg::resize( $favicon , 72, 72, true  )?>">
<link rel="apple-touch-icon-precomposed" href="<?php echo  fImg::resize( $favicon , 57, 57, true  )?>">

<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

<?php 
$analytics = $of_cypress['google_analytics'];
if ( $analytics ) : 
echo stripslashes($analytics);
endif;

function body_layout($classes) {
	global $of_cypress;
	if( $of_cypress['orientation'] == 'horizontal' ) {
		$class = 'horizontal-layout';
	}else{
		$class = 'vertical-layout';
	}
	$classes[] = $class;
	return $classes;
}
add_filter('body_class', 'body_layout');
?>


<?php wp_head(); ?>

</head>


<body <?php body_class();?> id="body">
<?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?> 
	<?php
	
	/**
	 *	HEADER AND MENU ORIENTATION:
	 */
	
	if( $of_cypress['orientation'] == 'default' ) {
	
		get_template_part('header','vertical');
		
		$page_layout = ' vertical';
		
	}else{
	
		get_template_part('breadcrumbs','langs');
		
		get_template_part('header','horizontal');
		
		$page_layout = ' horizontal';
	}
	?>
	
	<div id="site-menu-mobile">
	
		<?php get_template_part('header','mobile'); ?>
	
	</div>
	
	
	<div id="page" class="page<?php echo $page_layout; ?>">
	
	<?php 
	if( $of_cypress['orientation'] == 'default' ) {
		get_template_part('breadcrumbs','langs');
	}
	?>