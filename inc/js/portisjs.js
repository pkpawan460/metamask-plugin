function portis(){
	const portis = new Portis("211b48db-e8cc-4b68-82ad-bf781727ea9e", "rinkeby");
	const web = new Web3(portis.provider);
    web.eth.getAccounts().then(accounts => {
        document.getElementById("content").innerHTML = `<p>Wallet Address: ${
    accounts[0]
  }</p>`;
    });
}

