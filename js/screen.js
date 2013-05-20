/*
*	Arquivo utilizado para dividir tela em iframes
*
*	Author	Giovane de Oliveira
*
*	NÃO MEXER!
*/
function split_screen() {
	var iframeTop = document.createElement("iframe");
	iframeTop.setAttribute("id", "top");
	iframeTop.setAttribute("frameborder", 0);
	iframeTop.setAttribute("style", "overflow:hidden; top:0px; left:0px;");
	iframeTop.setAttribute("width", document.body.clientWidth - 550);
	iframeTop.setAttribute("height", 120);
	iframeTop.setAttribute("src", top);
	document.body.appendChild(iframeTop);
	
	var iframeLogin = document.createElement("iframe");
	iframeLogin.setAttribute("id", "login");
	iframeLogin.setAttribute("frameborder", 0);
	iframeLogin.setAttribute("style", "overflow:hidden; top:0px; right:0px;");
	iframeLogin.setAttribute("width", 550);
	iframeLogin.setAttribute("height", 120);
	iframeLogin.setAttribute("src", login);
	document.body.appendChild(iframeLogin);
	
	var iframeLeft = document.createElement("iframe");
	iframeLeft.setAttribute("id", "left");
	iframeLeft.setAttribute("frameborder", 0);
	iframeLeft.setAttribute("style", "overflow:hidden; top:120px; left:0px;");
	iframeLeft.setAttribute("width", document.body.clientWidth * 0.2);
	iframeLeft.setAttribute("height", document.body.clientHeight - 200);
	iframeLeft.setAttribute("src", left);
	document.body.appendChild(iframeLeft);
	
	var iframeMiddle = document.createElement("iframe");
	iframeMiddle.setAttribute("id", "middle");
	iframeMiddle.setAttribute("frameborder", 0);
	iframeMiddle.setAttribute("style", "overflow:hidden; top:120px; left:"+(document.body.clientWidth * 0.2));
	iframeMiddle.setAttribute("width", document.body.clientWidth * 0.6);
	iframeMiddle.setAttribute("height", document.body.clientHeight - 200);
	iframeMiddle.setAttribute("src", middle);
	document.body.appendChild(iframeMiddle);
	
	var iframeRight = document.createElement("iframe");
	iframeRight.setAttribute("id", "right");
	iframeRight.setAttribute("frameborder", 0);
	iframeRight.setAttribute("style", "overflow:hidden; top:120px; right:0px;");
	iframeRight.setAttribute("width", document.body.clientWidth * 0.2);
	iframeRight.setAttribute("height", document.body.clientHeight - 200);
	iframeRight.setAttribute("src", right);
	document.body.appendChild(iframeRight);
	
	var iframeBottom = document.createElement("iframe");
	iframeBottom.setAttribute("id", "bottom");
	iframeBottom.setAttribute("frameborder", 0);
	iframeBottom.setAttribute("style", "overflow:hidden; bottom:0px; left:0px;");
	iframeBottom.setAttribute("width", document.body.clientWidth);
	iframeBottom.setAttribute("height", 80);
	iframeBottom.setAttribute("src", bottom);
	document.body.appendChild(iframeBottom);
}

function refreshSrc(position, src) {
		try {
			document.getElementById(position).src = src;
		} catch (e) { alert("Frame não encontrada!"); }
}