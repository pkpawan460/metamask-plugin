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
	echo"<p>&nbsp;</p>";
    echo"<h2 style='font-weight:bold;'>Thanks for Order. Your Order will process after payment.</h2>";
    echo"<h2 style='font-weight:bold;'>Please make the payment of ETH ".$amount."</h2>";
    echo '<p style="font-weight:700;">Etheriumn Payment Address</p>';
    echo '<p style="padding:5px;font-weight:700;">'.get_option('publishable_key').'</p>';

    ?>
	<p style="font-weight:400;">Awaiting Payment from You. please click on "I paid. Please Verify" after make a payment.</p>
	<p style="font-style:italic;font-size:13px;"><b>Note:</b> If you send any other Etheriumn payment, System will ignore you.<p>
    
	
	<div class="row">
		<div class="col-md-12">
			<div class="colm">
			   
				<button class="btn btn-primary" onclick="metamask()">MetaMask</button>
			</div>
			<div class="colm">
			    <button class="btn btn-primary" onclick="coinbase()">Coinbase</button>
			</div>
			<div class="colm">
				<button class="btn btn-primary" onclick="connect()">WalletConnect</button>
			</div>
			<div class="colm">
			    <button class="btn btn-primary" onclick="handleLogin(event)">Fortmatic</button>
			</div>
			<div class="colm">
				 <button class="btn btn-primary" onclick="bitski()">Bitski</button>
			</div>
			
			<div class="colm">
			    <button class="btn btn-primary auth-loginlink">Venly</button>
			</div>
			
			<div class="colm">
			    <button class="btn btn-primary" onclick="portis()">Portis</button>
			</div>
			<div class="colm">
			    <button class="btn btn-primary" onclick="opentorus()">Torus</button>
			</div>
			<div class="colm">
			    <button class="btn btn-primary" onclick="getDapper()">Dapper</button>
			</div>
			
			<div class="colm">
			    <button class="btn btn-primary" onclick="getAuthereum()">Authereum</button>
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