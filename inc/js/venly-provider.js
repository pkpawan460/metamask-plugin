


jQuery( document ).ready(function() {
	jQuery('.auth-loginlink').on('click', function (event) {
		console.log('fehfbhjd');
		const venlyConnect = new VenlyConnect('YOUR_CLIENT_ID'); 


		//ccheck for walletId
		venlyConnect.api.getWallets().then((wallets)=>{
		   console.log(`The address of the first wallet is: ${wallets[0].address}`);
		   let wallet = wallets[0].address;
		});
		//Creating the signer
		const signer = venlyConnect.createSigner();

		//Asking the signer to transfer to a blockchain address.
		signer.executeTransfer({
			walletId: wallet,
			to: '0xf147cA0b981C0CD0955D1323DB9980F4B43e9FED',
			value: 0,
			secretType: 'ETHEREUM',
			data: '0x'
		})
	});
});







