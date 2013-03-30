<?
    require_once("../../class/class.tableList.inc");
    require_once("../../class/class.dba_connect.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
    $conn = new dba_connect();
    $list = new tableList();
?>
</head>
<body style="background-color:#333333; overflow:hidden;" >
<input type="hidden" id="cdcompany" name="cdcompany">
<div id="dvGrid" name="dvGrid" style="background-color:#F5F5F5; border-radius:15px; width:100%; height:100%; overflow:hidden; border: 1px groove #333333;">
<?
    $sql =  "SELECT CDCOMPANY, NMCOMPANY, NMCITY, NMSTATE, NRPHONE, DSADRESS, FLLOGO ".
                "FROM VRCOMPANY WHERE 1=1 ";
	
	if(isset($_REQUEST['nmcompany']) && $_REQUEST['nmcompany'] != "")
		$sql .= "AND UPPER(NMCOMPANY) LIKE ('%".strtoupper($_REQUEST['nmcompany'])."%') ";
	
	if(isset($_REQUEST['nmcity']) && $_REQUEST['nmcity'] != "")
		$sql .= "AND UPPER(NMCITY) LIKE ('%".strtoupper($_REQUEST['nmcity'])."%') ";
	
	if(isset($_REQUEST['nmstate']) && $_REQUEST['nmstate'] != "")
		$sql .= "AND UPPER(NMSTATE) LIKE ('%".strtoupper($_REQUEST['nmstate'])."%') ";
	
	if(isset($_REQUEST['dsadress']) && $_REQUEST['dsadress'] != "")
		$sql .= " AND UPPER(DSADRESS) LIKE('%".strtoupper($_REQUEST['dsadress'])."%') ";
	
	if(isset($_REQUEST['nmcompany'])) {
		$exec = $conn->query($sql);
		
		$list->setQueryFields($exec);
		$list->setFieldNames(array("NMCOMPANY", "NMCITY", "NMSTATE", "NRPHONE", "DSADRESS"));
		$list->setTitleNames(array("NOME", "CIDADE", "ESTADO", "FONE", "ENDEREÇO"));
		$list->setColWidth(array("300px", "200px", "75px", "130px", "300px"));
		$list->setColAlign(array("left", "left", "center", "right", "left"));
		$list->setHiddenObject("cdcompany");
		$list->printList("dvGrid");
	}
?>
</div>
</body>
</html>