<?php 
ob_start();

/* Template Name: thanks Template */ ?>
<?php

get_header();

global $woocommerce;

$amount = WC()->session->get('myorder');
if(empty($amount)){
	$amount=0;
}

if(isset($_REQUEST['key'])){
   $key = base64_decode($_REQUEST['key']);
}
if(isset($_REQUEST['id'])){
    $order_id = $_REQUEST['id'];
}

 $order = wc_get_order( $order_id );
?>
<div style="margin-left:30px;">	
<?php
    echo"<h2 style='font-weight:bold;'>Thanks for Order. Your Order will process after payment.</h2>";
    echo"<h2 style='font-weight:bold;'>Please make the payment of ETH ".$amount."</h2>";
    echo '<p style="font-weight:700;">Etheriumn Payment Address</p>';
    echo '<p style="padding:5px;font-weight:700;">'.get_option('publishable_key').'</p>';

    ?>
	<p style="font-weight:400;">Awaiting Payment from You. please click on "I paid. Please Verify" after make a payment.</p>
	<p style="font-style:italic;font-size:13px;"><b>Note:</b> If you send any other Etheriumn payment, System will ignore you.<p>
    
	
	<div class="row">
		<div class="col-md-12">
			<div style="width:20%;float:left;">
			    <a href="javascript:void(0);" class="paybutton" onclick="metamask()"><?php echo '<img src="' . esc_url( plugins_url( '/img/meta.png', __FILE__ ) ) . '" > '; ?></a>
			</div>
			<div style="width:20%;float:left;">
			    <a href="javascript:void(0);"  class="coinbase" onclick="coinbase()"><?php echo '<img src="' . esc_url( plugins_url( '/img/coinbase.png', __FILE__ ) ) . '" > '; ?></a>
			</div>
			<div style="width:20%;float:left;">
			    <a href="javascript:void(0);" id="connect" onclick="connect()"><?php echo '<img src="' . esc_url( plugins_url( '/img/wallet.png', __FILE__ ) ) . '" > '; ?></a>
			</div>
			<div style="width:20%;float:left;">
			    <a href="javascript:void(0);" onclick="handleLogin(event)"><?php echo '<img src="' . esc_url( plugins_url( '/img/fortmatic.png', __FILE__ ) ) . '" > '; ?></a>
			</div>
			<div style="width:20%;float:left;">
			    <a href="javascript:void(0);" onclick="venly"><?php echo '<img src="' . esc_url( plugins_url( '/img/bitski.png', __FILE__ ) ) . '" > '; ?></a>
			</div>
		</div>
	</div>
	<div id="status"></div>
    <p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
    <!--<form method="post">
		  <input type="submit" name="cpaid" value="I paid. Please Verify" />
        <input type="submit" name="paid" value="Click Here if you have already sent Etheriumn." />
    </form> -->
</div>




<?php get_footer(); ?>