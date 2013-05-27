<?
    require_once("../../class/class.tableList.inc");
    require_once("../../class/class.dba_connect.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
    $conn = new dba_connect();
    $list = new tableList();
?>
</head>
<body style="background-color:#333333; overflow:hidden;" >
<input type="hidden" id="cduser" name="cduser">
<div id="dvGrid" name="dvGrid" class="dvToGrid">
<?
    $sql =  	"SELECT US.FGBLOCK, US.CDUSER, US.NMUSER, STA.NMSTATE, CIT.NMCITY, US.DSADRESS, US.NRPHONE, US.ACTCODE, ".
				"CASE US.FGTYPE ".
				"	WHEN 1 ".
				"		THEN 'Usuário Padrão' ".
				"	ELSE ".
				"		'Administrador' ".
				"END AS FGTYPE ".
				"FROM VRUSER US, VRSTATE STA, VRCITY CIT ".
				"WHERE STA.CDSTATE = US.CDSTATE ".
				"AND CIT.CDCITY = US.CDCITY ".
				"AND US.FGTYPE <> 3 ".
				"ORDER BY US.NMUSER";
	$exec = $conn->query($sql);
	
	$list->setQueryFields($exec);
	$list->setFieldNames(array("FGBLOCK", "NMUSER", "FGTYPE", "NMSTATE", "NMCITY", "DSADRESS", "NRPHONE"));
	$list->setTitleNames(array("SITUAÇÃO", "NOME", "TIPO", "ESTADO", "CIDADE", "ENDEREÇO", "FONE"));
	$list->setColWidth(array("10px", "200px", "100px", "200px", "200px", "200px", "100px"));
	$list->setColAlign(array("center", "left", "left", "left", "left", "left", "left"));
	$list->setImgCols(array("FGBLOCK"=>"userBlock"));
	$list->setHasToolbar(true);
	$list->addButton("Visualizar", "btn_view", "btn_view", "viewUser()", "view", false);
	$list->addButton("Desbloquear", "btn_execute", "btn_execute", "executePendency(3)", "execute", false);
	$list->addButton("Bloquear", "btn_disable", "btn_disable", "executePendency(4)", "disable", false);
	$list->setClickFunction("enableBtns()");
	$list->setDblClickFunction("viewUser()");
	$list->setHiddenObject("cduser");
	$list->setHiddenFields(array("cduser", "fgblock", "actcode"));
	$list->printList("dvGrid");
?>
</div>
<iframe id="iframeAction" name="iframeAction" style="width:0px; height:0px; visibility:hidden; position:absolute;"></iframe>
<script type="text/javascript">
	function executePendency(type) {
		if(type == 1)
			msg = "Desbloquear usuário?";
		else
			msg = "Bloquear usuário?";
		
		if(confirm(msg)) {
			cduser = document.getElementById('cduser').value.split(";")[0];
			window.open("pendency_action.php?type="+type+"&cduser="+cduser, "iframeAction");
		}
	}
	
	function viewUser() {
		cduser = document.getElementById("cduser").value.split(";")[0];
		window_open("../user/register_user_data.php?action=2&view=1&cduser="+cduser, 635, 470);
	}
	
	function enableBtns() {
		fgblock = document.getElementById("cduser").value.split(";")[1];
		actcode = document.getElementById("cduser").value.split(";")[2];
		
		if(fgblock != 1 && actcode == "") {
			disableButton("btn_execute");
			enableButton("btn_disable");
		} else {
			enableButton("btn_execute");
			disableButton("btn_disable");
		}
		
		enableButton("btn_view");
	}
</script>
</body>
</html>