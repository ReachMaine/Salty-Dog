<?php
if( !isset($_GET['activated'])) {
header("Content-type: text/css; charset: UTF-8");
};
global $of_cypress;

$g_FontToggle 		= $of_cypress['google_typekit_toggle']; // applies to body and titles
$site_bg_toggle 	= $of_cypress['site_bg_toggle'];
$site_bg_default	= isset($of_cypress['site_bg_default']) ? $of_cypress['site_bg_default'] : null; //default tiles
$site_bg_uploaded	= $of_cypress['site_bg_uploaded']; // uploaded site bg images
$site_bg_repeat		= $of_cypress['site_bg_controls']['repeat'];
$site_bg_position	= $of_cypress['site_bg_controls']['position'];
$site_bg_attachment	= $of_cypress['site_bg_controls']['attachment'];
$site_bg_color		= $of_cypress['site_back_color'];
/**
 *	BODY styles
 *
 */
echo 'body { ';
	
	$g_FontBody = $of_cypress['google_body']['face'];
	$g_FontBodyWeight = $of_cypress['google_body']['weight'];
	$g_FontBodySize = $of_cypress['google_body']['size'];
	$g_FontBodyColor = $of_cypress['google_body']['color'];

	if( $g_FontToggle ) {
	
		echo isset( $g_FontBody ) ? 'font-family:'.$g_FontBody.', Helvetica, Arial, sans-serif;' : null;
		echo isset( $g_FontBodyWeight ) ? 'font-weight:'.$g_FontBodyWeight.';' : null;
		echo isset( $g_FontBodySize ) ? 'font-size:'.$g_FontBodySize.';' : null;
		echo isset( $g_FontBodyColor ) ? 'color:'.$g_FontBodyColor.';' : null;
	
	};
	
	if( $g_FontToggle == 'none' || $g_FontToggle == 'typekit' ) {
		
		echo 'font-family:'.$of_cypress['sys_body_font']['face'].', Helvetica, Arial, sans-serif;';
		
		echo ( $of_cypress['sys_body_font']['size'] ? 'font-size:' . $of_cypress['sys_body_font']['size'] . '; ' : '' );
		echo ( $of_cypress['sys_body_font']['height'] ? 'line-height:' . $of_cypress['sys_body_font']['height'] . ' !important; ' : '' );

		echo ( $of_cypress['sys_body_font']['style'] ? 'font-style:' . $of_cypress['sys_body_font']['style'] . '; ' : '' );
		echo ( $of_cypress['sys_body_font']['color'] ? 'color:' . $of_cypress['sys_body_font']['color'] . '; ' : '' ); 
		
	};
	
	if( $site_bg_toggle != 'none' ) {
	
		echo ($site_bg_toggle == 'default' && $site_bg_default ) ? 'background-image: url('. $site_bg_default .') ;' : null;
		echo ($site_bg_toggle == 'upload' && $site_bg_uploaded) ? 'background-image: url('. $site_bg_uploaded .') ;' : null;
		
		echo $site_bg_repeat	 ? 'background-repeat: '.$site_bg_repeat.';' : null;
		echo $site_bg_position	 ? 'background-position: '.$site_bg_position.';' : null;
		echo $site_bg_attachment ? 'background-attachment: '.$site_bg_attachment.';' : null;
		
	};
	
	echo $site_bg_color ? 'background-color: '.$site_bg_color.';' : null;
	
echo '}'; // end echo body
/**  end BODY styles */


/** DEPENDENCIES - OTHER SELECTORS WITH CSS's AS BODY ( overrides )*/
if( $g_FontToggle == 'google' ) {
	echo '#site-menu, .block-subtitle, .bottom-block-link a, .button, .onsale, .taxonomy-menu h4, button, input#s, input[type="button"], input[type="email"], input[type="reset"], input[type="submit"], input[type="text"], select, textarea, ul.post-portfolio-tax-menu li a {font-family: '.$g_FontBody.', Helvetica, Arial, sans-serif; }';
}



/**
 *	HEADINGS styles ( and MAIN MENU )
 *
 */
$g_FontHeadings = $of_cypress['google_headings']['face'];
$g_FontHeadingsWeight = $of_cypress['google_headings']['weight'];
$g_FontHeadingsColor = $of_cypress['google_headings']['color'];
	

if ( $g_FontToggle == 'google' ) {
	
	// only headings
	echo isset($g_FontHeadings) ? 'h1, h2, h3, h4, h5, h6 { font-family: "'.$g_FontHeadings.'", Helvetica, Arial, sans-serif; '. (isset($g_FontHeadingsWeight) ? 'font-weight:'.$g_FontHeadingsWeight.';' : '').' '.(isset($g_FontHeadingsColor) ? ' color: '. $g_FontHeadingsColor .';' : '').'}' : '';
	
	// others, but with same font
	echo isset( $g_FontHeadings ) ? '.billing_country_chzn, .chzn-drop, .navbar .nav, .price, footer  { font-family: "'.$g_FontHeadings.'", Helvetica, Arial, sans-serif;}' : '';
	
}else{

	echo 'h1, h2, h3, h4, h5, h6  { 
		font-family:'.$of_cypress['sys_heading_font']['face'].', Helvetica, Arial, sans-serif;'
		.( isset($of_cypress['sys_heading_font']['weight']) ? 'font-weight:'.$of_cypress['sys_heading_font']['weight'].';' : 'normal' ). ' ' 
		.( isset($of_cypress['sys_heading_font']['color']) ? 'color:'.$of_cypress['sys_heading_font']['color'].';' : '' ) . ' '
		.( isset($of_cypress['sys_heading_font']['style']) ? 'font-style:'.$of_cypress['sys_heading_font']['style'].';' : ''  ).
		' } ' ;
		
	echo '.billing_country_chzn, .chzn-drop, .navbar .nav, .price, footer  { 
		font-family:'.$of_cypress['sys_heading_font']['face'].', Helvetica, Arial, sans-serif; } ' ;
}
/* end HEADINGS styles  */



/**
 *	MAIN LINKS AND BUTTONS TEXT COLOR:
 *
 */
$links_buttons_color = $of_cypress['links_buttons_color'];	
$links_buttons_hover_color = $of_cypress['links_buttons_hover_color'];	

if( $links_buttons_color ) {
	echo 'a:link, a:visited, button, .button, .woocommerce .quantity .plus, .woocommerce .quantity .minus, .woocommerce #content .quantity .plus, .woocommerce #content .quantity .minus, .woocommerce-page .quantity .plus, .woocommerce-page .quantity .minus, .woocommerce-page #content .quantity .plus, .woocommerce-page #content .quantity .minus { color: '. $links_buttons_color .' }';
	// used also for active and current menu items BACKGROUND:
	//echo 'a.active, .current a { background-color:'. $links_buttons_color .'; }';

}
if( $links_buttons_hover_color ) {
	echo 'a:hover, button:hover, .button:hover, .woocommerce .quantity .plus:hover, .woocommerce .quantity .minus:hover, .woocommerce #content .quantity .plus:hover, .woocommerce #content .quantity .minus:hover, .woocommerce-page .quantity .plus:hover, .woocommerce-page .quantity .minus:hover, .woocommerce-page #content .quantity .plus:hover, .woocommerce-page #content .quantity .minus:hover { color: '. $links_buttons_hover_color .' }';
	// used also for active and current menu items FONT COLOR:
	//echo 'a.active, .current a { color:'. $links_buttons_hover_color .'; }';

}
/**
 *	BUTTONS BACKGROUND COLOR:
 *
 */
$buttons_bck_color			= $of_cypress['buttons_bck_color'];	
$buttons_hover_bck_color	= $of_cypress['buttons_hover_bck_color'];	

if( $buttons_bck_color ) {
	echo 'button, .button, .woocommerce .quantity .plus, .woocommerce .quantity .minus, .woocommerce #content .quantity .plus, .woocommerce #content .quantity .minus, .woocommerce-page .quantity .plus, .woocommerce-page .quantity .minus, .woocommerce-page #content .quantity .plus, .woocommerce-page #content .quantity .minus { background-color: rgba('. hex2rgb($buttons_bck_color) .', 0.8) }';

}
if( $buttons_hover_bck_color ) {
	echo 'button:hover, .button:hover, .woocommerce .quantity .plus:hover, .woocommerce .quantity .minus:hover, .woocommerce #content .quantity .plus:hover, .woocommerce #content .quantity .minus:hover, .woocommerce-page .quantity .plus:hover, .woocommerce-page .quantity .minus:hover, .woocommerce-page #content .quantity .plus:hover, .woocommerce-page #content .quantity .minus:hover { background-color: rgba('. hex2rgb($buttons_hover_bck_color) .', 0.8) !important }';

}



/**
 *	HEADER LINKS AND BUTTONS COLOR:
 *
 */
$header_font_color					= $of_cypress['header_font_color'];	
$header_links_buttons_color			= $of_cypress['header_links_buttons_color'];	
$header_links_buttons_hover_color	= $of_cypress['header_links_buttons_hover_color'];	
$header_back_color					= $of_cypress['header_back_color'];


if( $header_font_color ) {
	echo '#site-menu { color:'.$header_font_color.'; }';
	echo '#searchform-header input::-webkit-input-placeholder { color:'.$header_font_color.'; } #searchform-header input:-moz-placeholder { color:'.$header_font_color.'; } #searchform-header input::-moz-placeholder { color:'.$header_font_color.'; } #searchform-header input:-ms-input-placeholder { color:'.$header_font_color.'; }';
	// used for separation lines
	
}
// HEADER LINKS AND HOVERS :
if( $header_links_buttons_color ) {
	echo '#site-menu a, #main-nav-wrapper a, #secondary-nav a, .mega-clone a, .sub-clone a { color: '. $header_links_buttons_color .' }';
}
if( $header_links_buttons_hover_color ) {	
	echo 'footer a:hover, footer button:hover, footer .button:hover { color: '. $header_links_buttons_hover_color .' }';
}

// SIDE MENU / HEADER MENU BACKGROUND COLOR:
if( $header_back_color ) {
	echo '#site-menu.vertical, #site-menu.horizontal, #mini-cart-list, #site-menu-mobile, .header-cart, ul.navigation li ul { background-color:'.$header_back_color.';  }';
	
	echo '.mega-clone, .sub-clone, .sub-clone li .sub-menu ,.mobile-sticky.stuck { background-color: rgba('.hex2rgb($header_back_color).', 0.95);  }';
	echo '.menu-border:before { background-color:'. $header_back_color .'; }';
	
	echo '.active-mega span { border-right-color: '. $header_back_color .' }';
}


/**
 *	LOGO AND TITLE SETTINGS
 *
 *	- logo width (height s auto)
 *	- title font size and word-wrap: break-word toggle 
 *
 */
$logo_width		  = $of_cypress['logo_width'];
$logo_height	  = $of_cypress['logo_height'];
$title_size		  = $of_cypress['title_font_size'];
$title_break_word = $of_cypress['title_break_word'];
 
if( $logo_width  ) {
	if( $logo_width >= 300 ) {

		echo '#site-menu.vertical  { width: 320px; }';
		echo '.vertical #site-title h1 img  { width: 100%; }';
		echo '#page.vertical, footer.vertical { margin-left: 320px; }';

	}elseif ( $logo_width < 300 && $logo_width >= 250 ) {
		
		echo '#site-menu.vertical  { width: '. ( $logo_width + 20 ) .'px; }';
		echo '.vertical #site-title h1 img  { width: '. $logo_width .'px; }';
		echo '#page.vertical, footer.vertical { margin-left: '. ( $logo_width + 20 ) .'px; }';
		 
	}elseif ( $logo_width < 250 ) {
		echo '#site-menu.vertical  { width: 270px; }';
		echo '.vertical #site-title h1 img  { width: '. $logo_width .'px; }';
		echo '#page.vertical, footer.vertical { margin-left: 270px; }';
	}
}

if(	$logo_height ) {
	echo '.horizontal #site-title h1 img { max-height: '.$logo_height.'px }';
}

if( $title_size ) {
	echo '#site-title h1 { font-size: '.$title_size.'%; }';
}
if( $title_break_word ) {
	echo '#site-title h1 { word-wrap: break-word; }';
}



/**
 *	BODY BACKGROUND PROPERTIES:
 *
 */
$body_bg_toggle 	= $of_cypress['body_bg_toggle'];
$body_bg_default	= isset($of_cypress['body_bg_default']) ? $of_cypress['body_bg_default'] : null; //default tiles
$body_bg_uploaded	= $of_cypress['body_bg_uploaded']; // uploaded site bg images
$body_bg_repeat		= $of_cypress['body_bg_controls']['repeat'];
$body_bg_position	= $of_cypress['body_bg_controls']['position'];
$body_bg_attachment	= $of_cypress['body_bg_controls']['attachment'];
$body_bg_color		= $of_cypress['body_back_color'];

if( $body_bg_toggle != 'none' || $body_bg_color ) {

echo '#page {';

	if( $body_bg_toggle != 'none' ) {
		
		echo ($body_bg_toggle == 'default' && $body_bg_default ) ? 'background-image: url('. $body_bg_default .') ;' : null;
		echo ($body_bg_toggle == 'upload' && $body_bg_uploaded) ? 'background-image: url('. $body_bg_uploaded .') ;' : null;
		
		echo $body_bg_repeat	 ? 'background-repeat: '.$body_bg_repeat.';' : null;
		echo $body_bg_position	 ? 'background-position: '.$body_bg_position.';' : null;
		echo $body_bg_attachment ? 'background-attachment: '.$body_bg_attachment.';' : null;
		
	};

echo $body_bg_color ? 'background-color: '.$body_bg_color.';' : null;

echo '}';
	
};
// BODY BACK FOR ONEPAGER MENU BACK
if( $body_bg_color ) {
	echo '
	.aq_block_onepager_menu { background-color: rgba('.hex2rgb( $body_bg_color ).', 0.9);  }
	';
}



/**
 *	FOOTER LINKS AND BUTTONS COLOR:
 *
 */
$footer_font_color = $of_cypress['footer_font_color'];	
$footer_links_buttons_color = $of_cypress['footer_links_buttons_color'];	
$footer_links_buttons_hover_color = $of_cypress['footer_links_buttons_hover_color'];	
$footer_back_color = $of_cypress['footer_back_color'];
$footer_back_opacity = $of_cypress['footer_back_opacity'];	

$footer_bc_IE8 = str_replace('#','', $footer_back_color);

// links and hovers
if( $footer_links_buttons_color ) {
	echo 'footer a:link, footer a:visited, footer button, footer .button { color: '. $footer_links_buttons_color .' }';
}
if( $footer_links_buttons_hover_color ) {	
	echo 'footer a:hover, footer button:hover, footer .button:hover { color: '. $footer_links_buttons_hover_color .' }';
}
if( $footer_back_color ) {	
	
	echo 'footer { background-color: rgba('. hex2rgb($footer_back_color) .', '. $footer_back_opacity/100 .'); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#cc'.$footer_bc_IE8.'", endColorstr="#cc'.$footer_bc_IE8.'",GradientType=0 );  }';
}



/**
 *	BORDER STYLES
 *
 */
$border_width = $of_cypress['border_icon']['width'];
$border_style = $of_cypress['border_icon']['style'];
$border_color = $of_cypress['border_icon']['color'];

echo '
h1.block-title:after, h2.block-title:after, h3.block-title:after, h4.block-title:after, h5.block-title:after, h1.page-title:after, h1.archive-title:after, .single-product-block h2, article h2.post-title:after, .menu-border, .breadcrumbs-search-border, .footer-border, .article-border, .title-border, .block-title-border  {
	border-bottom-width: '.$border_width.'px;
	border-bottom-style: '.$border_style.';
	border-color: '.$border_color.';
	color: '.$border_color.';
}
';
echo '
.category-image .term   {
	border-bottom-width: '.$border_width.'px;
	border-bottom-style: '.$border_style.';
}
';


/* SIDE MENU / HEADER MENU BORDER SETTINGS */
echo '
#site-menu:after {
	border-width: '.$border_width.'px;
	border-style: '.$border_style.';
	border-color: '.$border_color.';
}
';
if( $of_cypress['no_border_sitemenu'] ) {
	echo '#site-menu:after {
		border: none;
	}';
};



/* border decoration and icons backgrounds*/
if( $body_bg_color ) {
	echo '.article-border:before, .block-title-border:before, .title-border:before, article .icon , .widget h4:before { background: '.$body_bg_color.';  }';
	echo '.title-border:before, article .icon  { border-color:  '.$body_bg_color.'; }';
}

if( $border_width ) {
	echo '.menu-border:before, .article-border:before, .block-title-border:before  { margin-bottom: -'. (floor($border_width / 2) + 1) .'px; }';
	
}


/**	BODY COLOR - to product filter widget area */
if( $body_bg_color ) {
	echo '.product-filters-wrap { background-color: rgba('.hex2rgb($body_bg_color).', 0.9);  }';
}



/**
 *	CUSTOM CSS
 *
 */
if( $of_cypress['header_custom_css'] && $of_cypress['orientation'] == 'horizontal' ) {
	echo $of_cypress['header_custom_css'];
}

if( $of_cypress['custom_css'] ) {
	echo $of_cypress['custom_css'];
}

?>