var tr_id = "";
function mouseReg(id, type){
	if(id != tr_id){
		if(tr_id != "" && type == 3){
			document.getElementById(tr_id).style.backgroundColor = "#F5F5F5";
		}
		
		switch(type){
			case 1: document.getElementById(id).style.backgroundColor = "#DDDDDD"; break;
			case 2: document.getElementById(id).style.backgroundColor = "#F5F5F5"; break;
			case 3: 
				tr_id = id;
				document.getElementById(tr_id).style.backgroundColor = "#BBBBBB";
				break;
		}
	}
}

function setHidden(value){
	document.getElementById(hiddenField).value = value;
}

var win = null;
function window_open(url, w, h){
	positionLeft = (screen.width)? (screen.width-w)/2 : 0;
	positionTop = (screen.height)? (screen.height-h)/2 : 0;
	params = 'height='+h+', width='+w+', top='+positionTop+', left='+positionLeft+', resizable=0, location=0, menubar=0, scrollbars=0';
	win = window.open(url, '_blank', params);
}