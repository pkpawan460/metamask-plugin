
async function bitski() {
	const bitski = new Bitski.Bitski('0xc17517cc86325d5e6f3374c7d2df59c356c2f6fa', 'http://localhost/wordpress/thanks-order');
	
	const provider = bitski.getProvider();
	const web3 = new Web3(provider);
	// public calls are always available
	const network = await web3.eth.getBlockNumber();

	// connect via oauth to use the wallet (call this from a click handler)
	await bitski.signIn();

	// now you can get accounts
	const accounts = await web3.eth.getAccounts();

	// and submit transactions for the user to approve
	const txn = await web3.eth.sendTransaction({
	  from: accounts[0],
	  to: '',
	  value: web3.utils.toWei('1')
	}); 
}



function checkAuthStatus() {
  //Check if we are logged in
  if (bitski.authStatus === AuthenticationStatus.NotConnected) {
    //create the connect button
    const containerElement = document.querySelector('#bitski-button');
    const connectButton = bitski.getConnectButton({ container: containerElement });
    connectButton.callback = (error, user) => {
      if (error) {
        // Handle errors
        return;
      }
      //Logged in!
      connectButton.remove();
      continueToApp();
    };
    // Optionally handle cancellation
    connectButton.onCancel = () => {
      // Will be called when the user clicks sign in, but dismisses popup
    };
  } else {
    //already logged in
    continueToApp();
  }
}



