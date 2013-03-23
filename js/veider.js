var win = null;
function window_open(url, w, h){
	positionLeft = (screen.width)? (screen.width-w)/2 : 0;
	positionTop = (screen.height)? (screen.height-h)/2 : 0;
	params = 'height='+h+', width='+w+', top='+positionTop+', left='+positionLeft+', resizable=0, location=0, menubar=0, scrollbars=0';
	win = window.open(url, '_blank', params);
}

function divBorderHeight(minus){
	/*h = (window.innerHeight - minus)+"px";	
	
	document.getElementById('dvborder').style.height = h;
	if(document.getElementById('dvtoolbar'))
		document.getElementById('dvtoolbar').style.height = h;*/
}

function mouseBtn(id, classBtn, classObj) {
	document.getElementById(id).className = classBtn;
	document.getElementById('obj_'+id).className = classObj;
}