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
<input type="hidden" id="cdnotice" name="cdnotice">
<div id="dvlistnotices" name="dvlistnotices" style="background-color:#F5F5F5; border-radius:15px; width:100%; height:100%; overflow:hidden; border: 1px groove #333333;">
<?
    $sql =  "SELECT CDNOTICE, NMNOTICE, DTNOTICE FROM VRNOTICE ORDER BY DTNOTICE DESC";
	
	$exec = $conn->query($sql);
	
	$list->setQueryFields($exec);
	$list->setFieldNames(array("NMNOTICE", "DTNOTICE"));
	$list->setTitleNames(array("NOTÍCIA", "DATA"));
	$list->setColWidth(array("200px", "100px"));
	$list->setColAlign(array("left", "right"));
	$list->setDateCols(array("DTNOTICE"));
	$list->setDblClickFunction("open_notice()");
	$list->setHiddenObject("cdnotice");
	$list->printList("dvlistnotices");
?>
</div>
<script type="text/javascript">
	function open_notice() {
		var cdnotice = document.getElementById('cdnotice').value;
		window_open("notice_data.php?cdnotice="+cdnotice+"&view=1", 550, 400);
	}
</script>
</body>
</html>