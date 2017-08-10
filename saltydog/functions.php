<?php 
require_once(get_stylesheet_directory().'/custom/woocommerce.php');
require_once(get_stylesheet_directory().'/custom/language.php');
/**
 * Cypress theme functions and definitions for child theme
 * @package WordPress
 * @subpackage Cypress
 * @since Cypress 1.0
*/

function child_enqueue_css() {

	global $of_cypress;
	
	// first, register child's style.css
	// to override completely parent style.css - unregister parent style.css
	//
	wp_register_style('cypress-child-css', get_stylesheet_directory_uri().'/style.css'  );
	wp_enqueue_style('cypress-child-css' );	
	
	
	if( !is_admin() ) {
	
		/* deregister THEME OPTIONS GENERATED STYLES from PARENT theme*/
		wp_deregister_style('options-styles');
		wp_dequeue_style('options-styles');
		
		/* register theme options gen. STYLES for CHILD theme*/
		$dynamic_css_js = ( isset($of_cypress['dynamic_css_js']) && $of_cypress['dynamic_css_js'] ) ? 1 : 0;
		if( $dynamic_css_js ) {
		
			//DYNAMIC (AJAX) THEME OPTIONS CSS:
			wp_enqueue_style('options-child', admin_url('admin-ajax.php') . '?action=dynamic_css',array(), '1.0.0', 'all');
			
		}else{
			$theme_data		= wp_get_theme(); // get theme info
			$theme_slug		= sanitize_title( $theme_data ); // make Cypress child to be cypress-child
			
			$uploads		= wp_upload_dir();
			$as_upload_dir	= trailingslashit($uploads['basedir']) . $theme_slug . '-options'; // DIRECTORY to uploads
			$as_upload_url	= trailingslashit($uploads['baseurl']) . $theme_slug . '-options'; // URL to uploads
			
			$as_upload_dir_exists = is_dir( $as_upload_dir );
			
			/* THEME OPTIONS CSS */
			if( $as_upload_dir_exists ){
				
				wp_register_style('options-child', $as_upload_url . '/theme_options_styles.css', 'style');
				
			}else{
			
				wp_register_style('options-child', get_stylesheet_directory_uri() . '/admin_save_options/theme_options_styles.css', 'style');
			}
			
		}
		
		wp_enqueue_style( 'options-child');
	}
	/**
	 *	EXAMPLE OF DEREGISTERING OTHER PARENT AND REGISTERING CHILD CSS (uncomment)
	// 
	wp_dequeue_style('woocommerce-as' );
	wp_deregister_style('woocommerce-as' );
	
	wp_register_style('woocommerce-as-child', get_stylesheet_directory_uri().'/woocommerce/woocommerce.css'  );
	wp_enqueue_style('woocommerce-as-child' );
	*/
}
add_action('wp_print_styles', 'child_enqueue_css');
//
function child_enqueue_script() {

	global $of_cypress;
	
	if( !is_admin() ) {
	
		/*deregister theme options generated script from PARENT theme*/
		wp_deregister_script('options_js');
		wp_dequeue_script('options_js');
		
		
		### THEME OPTIONS CSS AND JAVACRIPTS
		$dynamic_css_js = ( isset($of_cypress['dynamic_css_js']) && $of_cypress['dynamic_css_js'] ) ? 1 : 0;
		if( $dynamic_css_js ) {
		
			//DYNAMIC (AJAX) THEME OPTIONS JAVASCRIPT:
			wp_enqueue_script('options_js_child', admin_url('admin-ajax.php') . '?action=dynamic_js',array(), '1.0.0', 'all');
			
		}else{
		
			$theme_data		= wp_get_theme(); // get theme info
			$theme_slug		= sanitize_title( $theme_data ); // make Cypress child to be cypress-child
			
			$uploads		= wp_upload_dir();
			$as_upload_dir	= trailingslashit($uploads['basedir']) . $theme_slug . '-options'; // DIRECTORY to uploads
			$as_upload_url	= trailingslashit($uploads['baseurl']) . $theme_slug . '-options'; // URL to uploads
			
			
			$as_upload_dir_exists = is_dir( $as_upload_dir );
		
			if( $as_upload_dir_exists ){
				
				wp_register_script('options_js_child', $as_upload_url . '/theme_options_js.js');
				wp_enqueue_script('options_js_child', $as_upload_url . '/theme_options_js.js', array('jQuery'), '1.0', true);
				
			}else{
			
				wp_register_script('options_js_child', get_stylesheet_directory_uri() . '/admin_save_options/theme_options_js.js');
				wp_enqueue_script('options_js_child', get_stylesheet_directory_uri().'/admin_save_options/theme_options_js.js', array('jQuery'), '1.0', true);	
				
			}
		}
		
		// Localize the script with our data.
		$translation_array = array( 
			'loading_qb' => __( 'Loading quick view','cypress' )

		);
		wp_localize_script( 'options_js_child', 'options_translate', $translation_array );
		
		
		
		/* CHILD THEME SCRIPTS EDIT */
		/*
		// in case of edits of js files, repeat the procedure from bellow (example with as_custom.js file):
		// - first deregister and dequeue parent script
		// - copy js file/s from parent "js" folder to child "js" folder 
		// - register and enqueue them to child theme
		//
		// to edit as_custom.js, uncomment the lines bellow:
		
		wp_deregister_script('as_custom');
		wp_dequeue_script('as_custom');
		wp_register_script('as_custom_child', get_stylesheet_directory_uri() .  '/js/as_custom.js', 'style');
		wp_enqueue_script('as_custom_child');
		*/
	}
}
add_action('wp_print_scripts', 'child_enqueue_script');

	/* add favicons for admin */
	add_action('login_head', 'add_favicon');
	add_action('admin_head', 'add_favicon');
	
	function add_favicon() {
		$favicon_url = get_stylesheet_directory_uri() . '/images/admin-favicon.png';
		echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
	}

/*****  change the login screen logo ****/
	function my_login_logo() { ?>
		<style type="text/css">
			body.login div#login h1 a {
				background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/SD-logo.png);
				padding-bottom: 30px;
				background-size: contain;
			}
		</style>
	<?php }
	add_action( 'login_enqueue_scripts', 'my_login_logo',8 );

	add_action('after_setup_theme', 'ea_setup');
	function ea_setup() {
		remove_action( 'woocommerce_before_shop_loop_item_title', 'cypress_loop_product_thumbnail', 20 );
	}

	/*****  end custom login screen logo ****/
?>