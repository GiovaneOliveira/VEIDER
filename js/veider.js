var win = null;
function window_open(url, w, h){
	positionLeft = (screen.width)? (screen.width-w)/2 : 0;
	positionTop = (screen.height)? (screen.height-h)/2 : 0;
	params = 'height='+h+', width='+w+', top='+positionTop+', left='+positionLeft+', resizable=0, location=0, menubar=0, scrollbars=0';
	win = window.open(url, '_blank', params);
}

function divBorderHeight(minus){
	h = (window.innerHeight - minus)+"px";	
	
	document.getElementById('dvborder').style.height = h;
	if(document.getElementById('dvtoolbar'))
		document.getElementById('dvtoolbar').style.height = h;
}

function mouseBtn(id, classBtn, classObj) {
	if(!document.getElementById(id).disabled) {
		document.getElementById(id).className = "button"+classBtn;
		document.getElementById('obj_'+id).className = classObj;
	}
}

function required(form){
	for(i=0; i<form.length; i++)
	{
		var required = form[i].required;
		if(required == 1)
		{
			if(form[i].value == "")
			{
				alert("Há dados obrigatórios não informados.");
				form[i].focus();
				return false;
			}
		}
	}
	return true;
}

function disableButton(id){
	if(!document.getElementById(id).disabled) {
		child = document.getElementById(id).firstElementChild;
		obj = document.getElementById(id);
		obj.className = "buttonDisabled";
		obj.setAttribute("disabled", "disabled");
		
		if(child.src) {
			l = child.src.length-4;
			child.src = child.src.substr(0, l)+"_disabled.png";
			child.className = "imgButtonDisabled";
		} else {
			child.className = "fontButtonDisabled";
		}
	}
}

function enableButton(id){
	if(document.getElementById(id).disabled) {
		child = document.getElementById(id).firstElementChild;
		obj = document.getElementById(id);
		obj.className = "buttonNormal";
		obj.removeAttribute("disabled");
		
		if(child.src) {
			l = child.src.length-13;
			child.src = child.src.substr(0, l)+".png";
			child.className = "imgButton";
		} else {
			child.className = "fontButton";
		}
	}
}