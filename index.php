<?php
/*
Plugin Name: Ethereum Gateway
Plugin URI: http://kwannetwork.com/
Description: Probably the most advanced yet user friendly ethereum gateway plugin for woocommerce. The plugin allows you to make payment with metamask,coinbase,formatic and other. 
Author: Pawan Kumar
Version: 5.7.2
Author URI: http://myclass.net
*/

require_once('function/wooClass.php');
// Make sure WooCommerce is active
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;

if(defined("ETHEREUM")) {
    return;
}

global $wpdb;

add_action( 'wp_enqueue_scripts', 'my_plugin_assets' );
function my_plugin_assets() {
    wp_register_script( 'web3', 'https://cdnjs.cloudflare.com/ajax/libs/web3/1.6.1-rc.2/web3.min.js'  );
	wp_enqueue_script( 'web3' );
	wp_enqueue_script("gateway", esc_url( plugins_url( 'inc/js/gateway.js', __FILE__ ) ) ,array('jquery'), true);
	wp_enqueue_script("walletbrowser", 'https://cdn.jsdelivr.net/npm/@walletconnect/browser@1.0.0-beta.46/lib/index.min.js' );
	wp_enqueue_script("walletconnect", 'https://cdn.jsdelivr.net/npm/@walletconnect/qrcode-modal@1.0.0-beta.46/lib/index.min.js' );
	wp_enqueue_script("walletaxios", 'https://unpkg.com/axios/dist/axios.min.js' );
	wp_enqueue_script("formaticCdn", 'https://cdn.jsdelivr.net/npm/fortmatic@latest/dist/fortmatic.js' );
	wp_enqueue_script("wallet", esc_url( plugins_url( 'inc/js/wallet.js', __FILE__ ) ));
	wp_enqueue_script("fortmatic", esc_url( plugins_url( 'inc/js/formatic.js', __FILE__ ) ));
	
	//venly
	wp_enqueue_script("arkane", 'https://cdn.tutorialjinni.com/web3-arkane-provider/0.24.0-develop.3/web3-arkane-provider.js' );
	
	
	
}

//check the version of PHP
if(version_compare(PHP_VERSION, "5.2.0", "<")) {
    die("<b>Cannot activate:</b> ETHEREUM requires at least PHP 5.1.6, your PHP version is ".PHP_VERSION);
}

//define the constant 
define("ETHEREUM", "ethereum");

//Define the base url of plugin fiel
$basepath = dirname(__FILE__);


//Required classes included






function etheriumn_gateway_class( $methods ) {
    $methods[] = 'Etheriumn_Gateway'; 
    return $methods;
}
add_filter( 'woocommerce_payment_gateways', 'etheriumn_gateway_class' );




/**
 * Custom currency and currency symbol
 */
add_filter( 'woocommerce_currencies', 'add_etheriumn_currency' );

function add_etheriumn_currency( $currencies ) {
     $currencies['ETH'] = __( 'Etheriumn', 'woocommerce' );
     return $currencies;
}

add_filter('woocommerce_currency_symbol', 'add_etheriumn_symbol', 10, 2);

function add_etheriumn_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'ETH': $currency_symbol = 'ETH '; break;
     }
     return $currency_symbol;
}



//crate page 





add_action('init', 'get_page_title_for_slug'); 

function get_page_title_for_slug() {

     $page = get_page_by_path( 'thanks-order' , OBJECT );

     if ( isset($page) ){
        
     }
     else{
       	$wordpress_page = array(
        	  'post_title'    => 'Thanks Order',
        	  'post_slug'    => 'thanks-order',
        	  'post_content'  => '',
        	  'post_status'   => 'publish',
        	  'post_author'   => 1,
        	  'post_type' => 'page'
        	   );
        	 wp_insert_post( $wordpress_page ); 
     }
}


add_filter( 'page_template', 'wpa3396_page_template' );
function wpa3396_page_template( $page_template )
{
    if ( is_page( 'thanks-order' ) ) {
        $page_template = WP_PLUGIN_DIR . '/etheriumn/inc/thanks-template.php';
    }
    return $page_template;
}



/**
 * Add "Custom" template to page attirbute template section.
 */
function wpse_288589_add_template_to_select( $post_templates, $wp_theme, $post, $post_type ) {

    // Add custom template named template-custom.php to select dropdown 
    $post_templates['template-custom.php'] = __('Thanks Template');

    return $post_templates;
}

add_filter( 'theme_page_templates', 'wpse_288589_add_template_to_select', 10, 4 );


/**
 * Check if current page has our custom template. Try to load
 * template from theme directory and if not exist load it 
 * from root plugin directory.
 */
function wpse_288589_load_plugin_template( $template ) {

    if(  get_page_template_slug() === 'thanks-template.php' ) {

        if ( $theme_file = locate_template( array( 'thanks-template.php' ) ) ) {
            $template = $theme_file;
        } else {
            $template =  WP_PLUGIN_DIR . '/etheriumn/inc/thanks-template.php';
        }
    }

    if($template == '') {
        throw new \Exception('No template found');
    }

    return $template;
}

add_filter( 'template_include', 'wpse_288589_load_plugin_template' );


