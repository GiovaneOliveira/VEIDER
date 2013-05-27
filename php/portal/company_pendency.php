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
<input type="hidden" id="cdcompany" name="cdcompany">
<div id="dvGrid" name="dvGrid" class="dvToGrid">
<?
    $sql =  	"SELECT USR.FGBLOCK, COMP.CDCOMPANY, COMP.NMCOMPANY, USR.NMUSER, STA.NMSTATE, CIT.NMCITY, COMP.NRPHONE ".
				"FROM VRCOMPANY COMP, VRUSER USR, VRSTATE STA, VRCITY CIT ".
				"WHERE USR.CDUSER = COMP.CDADMIN ".
				"AND STA.CDSTATE = COMP.CDSTATE ".
				"AND CIT.CDCITY = COMP.CDCITY ";	
	$exec = $conn->query($sql);
	
	$list->setQueryFields($exec);
	$list->setFieldNames(array("FGBLOCK", "NMCOMPANY", "NMUSER", "NMSTATE", "NMCITY", "NRPHONE"));
	$list->setTitleNames(array("TIPO", "NOME", "ADMINISTRADOR", "ESTADO", "CIDADE", "FONE"));
	$list->setColWidth(array("1px", "200px", "200px", "130px", "75px", "100px"));
	$list->setColAlign(array("center", "left", "left", "left", "left", "left"));
	$list->setImgCols(array("FGBLOCK"=>"companyPendency"));
	$list->setHasToolbar(true);
	$list->addButton("Visualizar", "btn_view", "btn_view", "viewCompany()", "view", false);
	$list->addButton("Executar", "btn_execute", "btn_execute", "executePendency(1)", "execute", false);
	$list->addButton("Desativar", "btn_disable", "btn_disable", "executePendency(2)", "disable", false);
	$list->setClickFunction("enableBtns()");
	$list->setDblClickFunction("viewCompany()");
	$list->setHiddenObject("cdcompany");
	$list->setHiddenFields(array("cdcompany", "fgblock"));
	$list->printList("dvGrid");
?>
</div>
<iframe id="iframeAction" name="iframeAction" style="width:0px; height:0px; visibility:hidden; position:absolute;"></iframe>
<script type="text/javascript">
	function executePendency(type) {
		if(type == 1) {
			msg = "Desbloquear empresa?";
		} else {
			msg = "Deseja cancelar solicitação?";
		}
		
		if(confirm(msg)) {
			cdcompany = document.getElementById('cdcompany').value.split(";")[0];
			window.open("pendency_action.php?type="+type+"&cdcompany="+cdcompany, "iframeAction");
		}
	}
	
	function viewCompany() {
		cdcompany = document.getElementById("cdcompany").value.split(";")[0];
		window_open("../company/register_company_data.php?action=2&view=1&cdcompany="+cdcompany, 635, 470);
	}
	
	function enableBtns() {
		fgblock = document.getElementById("cdcompany").value.split(";")[1];
		
		if(fgblock == 2) {
			enableButton("btn_execute");
			enableButton("btn_disable");
		} else {
			disableButton("btn_execute");
			disableButton("btn_disable");
		}
		enableButton("btn_view");
	}
</script>
</body>
</html>