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
<body>
<input type="hidden" id="cdsuggestion" name="cdsuggestion">
<div id="dvGrid" name="dvGrid" class="dvToGrid">
<?
	$sql = "SELECT SUG.CDSUGGESTION, SUG.NMSUGGESTION, US.NMUSER, SUG.DTSUGGESTION
			FROM VRSUGGESTION SUG, VRUSER US
			WHERE SUG.CDUSER = US.CDUSER
			AND SUG.CDCOMPANY = ".$_REQUEST['cdcompany']."
			ORDER BY SUG.DTSUGGESTION DESC";
	$fields = $conn->query($sql);
	
	$list->setQueryFields($fields);
	$list->setFieldNames(array("NMSUGGESTION", "NMUSER", "DTSUGGESTION"));
	$list->setTitleNames(array("SUGESTÃO", "USUÁRIO", "DATA"));
	$list->setColWidth(array("40%", "40%", "20%"));
	$list->setColAlign(array("left", "left", "right"));
	$list->setDateCols(array("DTSUGGESTION"));
	$list->setClickFunction("enableBtn()");
	$list->setDblClickFunction("action(1)");
	$list->setHiddenObject("cdsuggestion");
	$list->setHiddenFields(array("cdsuggestion"));
	$list->setHasToolbar(true);
	$list->addButton("Visualizar", "btn_view", "btn_view", "action(1)", "view", false);
	$list->addButton("Excluir", "btn_delete", "btn_delete", "action(2)", "delete", false);
	$list->printList("dvGrid");
?>
</div>
<iframe id="iframeAction" name="iframeAction" style="width:0px; height:0px; visibility:hidden; position:absolute;"></iframe>
<script type="text/javascript">
	function action(type) {
		cdsuggestion = document.getElementById('cdsuggestion').value;
		
		switch(type) {
			case 1:
				window_open("suggestion_data.php?view=1&cdsuggestion="+cdsuggestion+"&cdcompany=<?echo $_REQUEST['cdcompany']?>", 550, 440);
				break;
			case 2:
				if(confirm("Deseja excluir esta sugestão?")) {
					window.open("suggestion_action.php?type=2&cdsuggestion="+cdsuggestion, "iframeAction"); break;
				}
				break;
		}
	}
	
	function enableBtn() {
		enableButton("btn_view");
		enableButton("btn_delete");
	}
</script>
</body>
</html>