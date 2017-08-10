<?php 
/* languages customizations 
*/
	if ( !function_exists('eai_change_theme_text') ){
		function eai_change_theme_text( $translated_text, $text, $domain ) {
			 /* if ( is_singular() ) { */
			    switch ( $translated_text ) {
			    	case 'Related Products': 
			    		$translated_text = "Related Images";
			  			break;
			  		case 'Search for products': 
			    		$translated_text = "Search for Images";
			  			break;
		            case 'Category:' :
		                $translated_text = "";
		                break;
		            case 'Product Description':
		            	$translated_text = "";
		            	break;
		            case 'Previous entry: ':
		            	$translated_text = "";
		            	break;
		            case 'Next entry: ':
		            	$translated_text = "";
		            	break;
		            	
		            /*case 'BLOG CATEGORIES':
		            	$translated_text = __( 'Found in',  $domain  );
		            	break;
		            case 'Share this post:':
		            	$translated_text = __('Share', ' $domain );
		            	break; */
		        }
		    /* } */

	    	return $translated_text;
		}
		add_filter( 'gettext', 'eai_change_theme_text', 20, 3 );
	}

?>