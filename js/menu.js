idItem = "";
function menuBG(id, type) {
	if(id != idItem){
		if(idItem != "" && type == 3){
			document.getElementById(idItem).style.backgroundColor = "#F5F5F5";
		}
		
		switch(type){
			case 1: document.getElementById(id).style.backgroundColor = "#DDDDDD"; break;
			case 2: document.getElementById(id).style.backgroundColor = "#F5F5F5"; break;
			case 3: 
				idItem = id;
				document.getElementById(idItem).style.backgroundColor = "#BBBBBB";
				break;
		}
	}
}