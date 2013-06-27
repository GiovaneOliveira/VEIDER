<?
	require_once("../../class/class.tableList.inc");
    require_once("../../class/class.dba_connect.inc");
	session_start();
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
<body>
<input type="hidden" id="cdcompany" name="cdcompany">
<div id="dvGrid" name="dvGrid" class="dvToGrid">
<?
    $sql = "SELECT COMP.CDCOMPANY, COMP.NMCOMPANY, STA.NMSTATE, CIT.NMCITY, COMP.NRPHONE, COMP.DSADRESS ".
			"FROM VRCOMPANY COMP, VRUSER US, VRSTATE STA, VRCITY CIT ".
			"WHERE COMP.CDSTATE = STA.CDSTATE AND US.CDUSER = COMP.CDADMIN AND COMP.CDCITY = CIT.CDCITY AND US.FGBLOCK = 0 ";
	
	if(isset($_REQUEST['nmcompany']) && $_REQUEST['nmcompany'] != "")
		$sql .= " AND ".$conn->protectStr("COMP.NMCOMPANY", $_REQUEST['nmcompany']);
	
	if(isset($_REQUEST['cdcity']) && $_REQUEST['cdcity'] != "" && $_REQUEST['cdcity'] > 0)
		$sql .= " AND COMP.CDCITY = ".$_REQUEST['cdcity'];
	
	if(isset($_REQUEST['cdstate']) && $_REQUEST['cdstate'] != "" && $_REQUEST['cdstate'] > 0)
		$sql .= " AND COMP.CDSTATE = ".$_REQUEST['cdstate'];
	
	if(isset($_REQUEST['dsadress']) && $_REQUEST['dsadress'] != "")
		$sql .= " AND ".$conn->protectStr("COMP.DSADRESS", $_REQUEST['dsadress']);
	
	$sql .= " ORDER BY COMP.NMCOMPANY ";
	
	if(isset($_REQUEST['nmcompany'])) {
		$exec = $conn->query($sql);
		
		$list->setQueryFields($exec);
		$list->setFieldNames(array("NMCOMPANY", "NMSTATE", "NMCITY", "NRPHONE", "DSADRESS"));
		$list->setTitleNames(array("NOME", "ESTADO", "CIDADE", "FONE", "ENDEREÇO"));
		$list->setColWidth(array("300px", "200px", "75px", "130px", "300px"));
		$list->setColAlign(array("left", "left", "center", "right", "left"));
		$list->setDblClickFunction("reloadFrames()");
		$list->setHiddenObject("cdcompany");
		$list->setHiddenFields(array("cdcompany"));
		$list->printList("dvGrid");
	}
	else {
		echo "
			<table style='width:100%; height:100%;' cellpadding='0' cellspacing='0'>
				<tr style='height:70%; vertical-align:bottom;'>
					<td align='center'>
						<img src='../../image/veider/veider_280.png'/>
					</td>
				</tr>
				<tr style='vertical-align:top;'>
					<td align='center'>
						<font style='color: #333333;font-family: Gill, Helvetica, sans-serif; font-size: 20px;font-weight: bold;'>Veider Sistema de Reservas</font>
					</td>
				</td>
			</table>
		";
	}
?>
</div>
<script type="text/javascript">
	var logged = <?echo (isset($_SESSION['FGTYPE']) && $_SESSION['FGTYPE'] > 0)? "true" : "false"; ?>;
	
	function reloadFrames() {
		if(logged) {
			cdcompany = document.getElementById('cdcompany').value;
			
			// Menu
			parent.refreshSrc("left", "../company/company_menu.php?cdcompany="+cdcompany);
			// Notícias
			parent.refreshSrc("right", "../notice/notice_list.php?cdcompany="+cdcompany);
			// Central
			parent.refreshSrc("middle", "../portal/company_list.php");
			// Cabeçalho
			parent.refreshSrc("top", "../portal/header.php?cdcompany="+cdcompany);
		} else {
			alert("É necessário estar autenticado para acessar esta página.");
		}
	}
</script>
</body>
</html>