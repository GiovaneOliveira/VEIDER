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