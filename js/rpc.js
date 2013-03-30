/*
*	Arquivo com função para chamar um arquivo PHP através de JS
*
*	Utilização:
*	No arquivo php que vai fazer a requisição, adicionar <?include_once("../../js/rpc.js");?> no script
*	A chamada é:
*	RPC = new REQUEST("url.php?params");
*	retorno = RPC.Response(null);
*
*/

REQUEST = function(url){
	if(window.XMLHttpRequest)
		this.object = new XMLHttpRequest();
	else if(window.ActiveXObject)
		this.object = new ActiveXObject("Microsoft.XMLHTTP");
		
	this.url = "../../php/"+url;
	this.method = 'GET';
	
	return this;
};

REQUEST.prototype.Response = function(send){
	
	this.object.open(this.method,this.url,false);
	this.object.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); 
	this.object.send(send);
	
	return this.object.responseText;
};
