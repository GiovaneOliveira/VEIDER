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
    $sql =  "SELECT CDCOMPANY, NMCOMPANY, NMCITY, NMSTATE, NRPHONE, DSADRESS, FLLOGO ".
                "FROM VRCOMPANY WHERE 1=1 ";
	
	if(isset($_REQUEST['nmcompany']) && $_REQUEST['nmcompany'] != "")
		$sql .= "AND ".$conn->protectStr("NMCOMPANY", $_REQUEST['nmcompany']);
	
	if(isset($_REQUEST['nmcity']) && $_REQUEST['nmcity'] != "")
		$sql .= "AND ".$conn->protectStr("NMCITY", $_REQUEST['nmcity']);
	
	if(isset($_REQUEST['nmstate']) && $_REQUEST['nmstate'] != "")
		$sql .= "AND ".$conn->protectStr("NMSTATE", $_REQUEST['nmstate']);
	
	if(isset($_REQUEST['dsadress']) && $_REQUEST['dsadress'] != "")
		$sql .= " AND ".$conn->protectStr("DSADRESS", $_REQUEST['dsadress']);
	
	if(isset($_REQUEST['nmcompany'])) {
		$exec = $conn->query($sql);
		
		$list->setQueryFields($exec);
		$list->setFieldNames(array("NMCOMPANY", "NMCITY", "NMSTATE", "NRPHONE", "DSADRESS"));
		$list->setTitleNames(array("NOME", "CIDADE", "ESTADO", "FONE", "ENDEREÇO"));
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
	function reloadFrames() {
		cdcompany = document.getElementById('cdcompany').value;
		
		// Menu
		parent.refreshSrc("left", "../company/company_menu.php?cdcompany="+cdcompany);
		// Notícias
		parent.refreshSrc("right", "../notice/notice_list.php?cdcompany="+cdcompany);
		// Central
		parent.refreshSrc("middle", "../portal/company_list.php");
		// Cabeçalho
		parent.refreshSrc("top", "../portal/header.php?cdcompany="+cdcompany);
	}
</script>
</body>
</html>