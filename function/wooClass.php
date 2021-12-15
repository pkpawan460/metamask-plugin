<?php
add_action( 'plugins_loaded', 'init_etheriumn_class' );
function init_etheriumn_class() {
	
	class Etheriumn_Gateway extends WC_Payment_Gateway {


		function __construct() {

			
			$this->id = 'etheriumn_gateway'; // payment gateway plugin ID
			$this->icon = ''; // URL of the icon that will be displayed on checkout page near your gateway name
			$this->has_fields = false; // in case you need a custom credit card form
			$this->method_title = 'Etheriumn Gateway';
			$this->method_description = 'Pay with MetaMask,Coinbase Wallet, WalletConnect, Kaikas, Bitski, Venly, Dapper, Dapperreum, Torus, Portis, OperaTouch'; // will be displayed on the options page

			// gateways can support subscriptions, refunds, saved payment methods,
			// but in this tutorial we begin with simple payments
			$this->supports = array(
				'products'
			);

			// Method with all the options fields
			$this->init_form_fields();

			// Load the settings.
			$this->init_settings();
			
			$this->title = $this->get_option( 'title' );
			$this->description = $this->get_option( 'descriptions' );
			$this->enabled = $this->get_option( 'enabled' );
			$this->testmode = 'yes' === $this->get_option( 'testmode' );
			$this->publishable_key = $this->testmode ? $this->get_option( 'test_publishable_key' ) : $this->get_option( 'publishable_key' );


			// This action hook saves the settings
			add_action('woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options'));

		}

		
		
		// administration fields for Etheriumn Gateway
		public function init_form_fields() {
			
			$this->form_fields = array(
				'enabled' => array(
					'title'       => 'Enable/Disable',
					'label'       => 'Enable Etheriumn Gateway',
					'type'        => 'checkbox',
					'description' => '',
					'default'     => 'no'
				),
				'title' => array(
					'title'       => 'Title',
					'type'        => 'text',
					'description' => 'This controls the title which the user sees during checkout.',
					'default'     => 'Etheriumn Crypto Currency',
					'desc_tip'    => true,
				),
				'descriptions' => array(
					'title'       => 'Description',
					'type'        => 'textarea',
					'description' => 'This controls the description which the user sees during checkout.',
					'default'     => 'Pay with MetaMask,Coinbase Wallet,WalletConnect,Kaikas,Bitski,Venly,Dapper,Dapperreum,Torus,Portis,OperaTouch payment gateway.',
				),
				'testmode' => array(
					'title'       => 'Test mode',
					'label'       => 'Enable Test Mode',
					'type'        => 'checkbox',
					'description' => 'Place the payment gateway in test mode using test API keys.',
					'default'     => 'yes',
					'desc_tip'    => true,
				),
				'test_publishable_key' => array(
					'title'       => 'Test Payment Address',
					'type'        => 'text'
				),
				
				'publishable_key' => array(
					'title'       => 'Payment Address',
					'type'        => 'text'
				)
			);
		}
		
		
		public function payment_scripts() {

			// no reason to enqueue JavaScript if API keys are not set
			if ( empty( $this->private_key ) || empty( $this->publishable_key ) ) {
				return;
			}

			// do not work with card detailes without SSL unless your website is in a test mode
			if ( ! $this->testmode && ! is_ssl() ) {
				return;
			}
	
	 	}

		/*
 		 * Fields validation, more in Step 5
		 */
		public function validate_fields() {

		

		}

		// Submit payment and handle response
	public function process_payment( $order_id ) {
		global $woocommerce;

		// Get this Order's information so that we know
		// who to charge and how much
		$customer_order = new WC_Order( $order_id );
        
		// Are we testing right now or is it a real transaction
		$environment = ( $this->environment == "yes" ) ? 'TRUE' : 'FALSE';
		
		if(	$environment == TRUE){
		    
		    $order = wc_get_order( $order_id );

			WC()->session->set('myorder', $order->get_total());
			if($order){
			   $orderDetail = new WC_Order( $order_id );
				$orderDetail->update_status("wc-pending", 'Pending payment', TRUE);
			}
    		if ( $order->get_total() > 0 ) {
    			
    			$order->update_status( apply_filters( 'woocommerce_cod_process_payment_order_status', $order->has_downloadable_item() ? 'on-hold' : 'Pending payment', $order ), __( 'Pending payment.', 'woocommerce' ) );  
				
    		} else {
				
    		}
			return array(
    			'result'   => 'success',
    			'redirect' => get_bloginfo('url').'/thanks-order/?id='.$order_id.'&key='.base64_encode($this->get_return_url($order)),
    		);
		}
	}
	
	
	
	public function thankyou_page( $payment_id) {
        
        if( 'etheriumn_gateway' === $payment_id ){
    		echo '<p>Etheriumn Payment Address</p>';
             echo '<p style="padding:5px;border:1px solid #f2f2f2;">'.get_option('publishable_key').'</p>';
        }
	}
		/*
		 * In case you need a webhook, like PayPal IPN etc
		 */
		public function webhook() {

		
					
	 	}
		
		

	}
	

}