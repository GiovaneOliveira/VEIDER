/*
*	Arquivo com fun��o para chamar um arquivo PHP atrav�s de JS
*
*	Utiliza��o:
*	No arquivo php que vai fazer a requisi��o, adicionar <?include_once("../js/rpc.js");?> no script
*	A chamada �:
*	RPC = new REQUEST("url.php?params", "../php/");
*	retorno = RPC.Response(null);
*
*/

REQUEST = function(url, path){
        
	path = (path == undefined) ? "" : path;
	
	if(window.XMLHttpRequest)
		this.object = new XMLHttpRequest();
	else if(window.ActiveXObject)
		this.object = new ActiveXObject("Microsoft.XMLHTTP");
		
	this.url = path+url;
	this.method = 'GET';
	
	return this;
};

REQUEST.prototype.Response = function(send){
	
	this.object.open(this.method,this.url,false);
	this.object.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); 
	this.object.send(send);
	
	return this.object.responseText;
};
