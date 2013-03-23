/*
*	Arquivo JS para criação da listagem dinâmica
*
*	Author	Giovane de Oliveira
*
*	NÃO MEXER!
*/
function dvList(){
	var dvList = document.createElement("div");
	dvList.setAttribute("id", "dvList");
	dvList.setAttribute("name", "dvList");
	dvList.setAttribute("width", divToOutput.clientWidth);
	dvList.setAttribute("height", divToOutput.clientHeight - 35);
	dvList.setAttribute("style", "max-height:"+(divToOutput.clientHeight - 35)+";min-height:"+(divToOutput.clientHeight - 35)+";min-width:"+(divToOutput.clientWidth-2));
	dvList.setAttribute("class", "dvList");
	divToOutput.appendChild(dvList);
}

function tableList(row){
	dvList = document.getElementById("dvList");
	
	var tableList = document.createElement("table");
	tableList.setAttribute("id", "tableList");
	tableList.setAttribute("name", "tableList");
	tableList.setAttribute("cellpadding", 0);
	tableList.setAttribute("cellspacing", 0);
	tableList.setAttribute("class", "tableList");
	dvList.appendChild(tableList);
	
	var tableTr = document.createElement("tr");
	tableTr.setAttribute("id", "tr_"+(row-1));
	tableTr.setAttribute("name", "tr_"+(row-1));
	tableTr.setAttribute("style", "position:absolute; top:0; width:100%;");
	tableList.appendChild(tableTr);
}

function newTitleTd(value, col, row, width){
	tableTr = document.getElementById("tr_"+(row-1));
	
	var newTd = document.createElement("td");
	newTd.setAttribute("id", "td_"+(row-1)+"_"+col);
	newTd.setAttribute("name", "td_"+(row-1)+"_"+col);
	newTd.setAttribute("width", width);
	newTd.setAttribute("class", "titleTd");
	tableTr.appendChild(newTd);
	
	var newFont = getFont(value, "font_"+(row-1)+"_"+col, "titleFont");
	newTd.appendChild(newFont);
}

function newRegTr(hidden, row){
	tableList = document.getElementById("tableList");
	
	var regTr = document.createElement("tr");
	regTr.setAttribute("id", "tr_"+row);
	regTr.setAttribute("name", "tr_"+row);
	regTr.setAttribute("class", "regTr");
	regTr.attachEvent("onmouseover", function(){ mouseReg("tr_"+row, 1); });
	regTr.attachEvent("onmouseout", function(){ mouseReg("tr_"+row, 2); });
	regTr.attachEvent("onclick", function(){ mouseReg("tr_"+row, 3); setHidden(hidden); });
	tableList.appendChild(regTr);
}

function newRegTd(value, col, row, width){
	regTr = document.getElementById('tr_'+row);
	
	var regTd = document.createElement("td");
	regTd.setAttribute("id", "td_"+row+"_"+col);
	regTd.setAttribute("name", "td_"+row+"_"+col);
	regTd.setAttribute("width", width);
	regTd.setAttribute("class", "regTd");
	regTr.appendChild(regTd);
	
	var newFont = getFont(value, "font_"+row+"_"+col, "regFont");
	regTd.appendChild(newFont);
}

function getFont(value, id, clas){
	var font = document.createElement("font");
	font.setAttribute("id", id);
	font.setAttribute("name", id);
	font.setAttribute("class", clas);
	
	var title = document.createTextNode(value);
	font.appendChild(title);
	
	return font;
}

function getFooter(total){
	var dvFooter = document.createElement("div");
	dvFooter.setAttribute("id", "dvFooter");
	dvFooter.setAttribute("name", "dvFooter");
	dvFooter.setAttribute("style", "width:"+divToOutput.client+"px;");
	dvFooter.setAttribute("class", "footer");
	divToOutput.appendChild(dvFooter);
	
	value = "Total de registros - ("+total+")";
	var textFooter = getFont(value, "footer", "footerFont");
	dvFooter.appendChild(textFooter);
}

var tr_id = "";
function mouseReg(id, type){
	if(id != tr_id){
		if(tr_id != "" && type == 3){
			document.getElementById(tr_id).style.backgroundColor = "#F5F5F5";
		}
		
		switch(type){
			case 1: document.getElementById(id).style.backgroundColor = "#E0E0E0"; break;
			case 2: document.getElementById(id).style.backgroundColor = "#F5F5F5"; break;
			case 3: 
				tr_id = id;
				document.getElementById(tr_id).style.backgroundColor = "#B0B0B0";
				break;
		}
	}
}

function setHidden(value){
	document.getElementById(hiddenField).value = value;
}