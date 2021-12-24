async function opentorus(){
	const torus = new Torus({
	  buttonPosition: "top-left", // default: bottom-left
	});
	await torus.init({
	  buildEnv: "production", // default: production
	  enableLogging: true, // default: false
	  network: {
		host: "kovan", // default: mainnet
		chainId: 42, // default: 1
		networkName: "Kovan Test Network", // default: Main Ethereum Network
	  },
	  showTorusButton: false, // default: true
	});
	await torus.login(); // await torus.ethereum.enable()
	const web3 = new Web3(torus.provider);
}




function getDapper(){
	
	window.open("https://www.meetdapper.com/?utm_source=opensea", "_blank");
}



async function getAuthereum(){
	const authereum = new Authereum('mainnet');
	const provider = authereum.getProvider();
	await authereum.login();
	const address = await authereum.getAccountAddress();
}