<?
	require_once("../../class/class.tableList.inc");
	require_once("../../class/class.dba_connect.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLI "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$list = new tableList();
	$conn = new dba_connect();
?>
</head>
<body>
<input type="hidden" id="cdobject" name="cdobject">
<div id="dvObjectGrid" id="dvObjectGrid" class="dvToGrid">
<?
	$sql = "SELECT ITEM.CDOBJECT, ITEM.CDCOMPANY,ITEM.NMOBJECT, ITEM.VLOBJECT , ITEM.FGCONDITION
				FROM VROBJECT ITEM, VRCOMPANY COMP
				WHERE ITEM.CDCOMPANY = COMP.CDCOMPANY
				AND ITEM.CDCOMPANY = ".$_REQUEST['cdcompany']."
				ORDER BY ITEM.NMOBJECT";
	$ex = $conn->query($sql);
	
	$list->setQueryFields($ex);
	$list->setFieldNames(array("NMOBJECT", "VLOBJECT",  "FGCONDITION"));
	$list->setTitleNames(array("NOME", "VALOR HORA (R$)", "CONDIÇÃO"));
	$list->setColWidth(array("800px", "100px", "100px"));
	$list->setColAlign(array("left", "right", "center"));
	$list->setImgCols(array("FGCONDITION"=>"objectCondition"));
	$list->setHasToolbar(true);
	if(isset($_SESSION['CDCOMPANY']) && $_SESSION['CDCOMPANY'] == $_REQUEST['cdcompany']) {
		$list->addButton("Novo", "btn_new", "btn_new", "objectActions(1)", "new", true);
		$list->addButton("Editar", "btn_edit", "btn_edit", "objectActions(2)", "edit", false);
		$list->setDblClickFunction("objectActions(2)");
	} else {
		$list->addButton("Visualizar", "btn_view", "btn_view", "objectActions(3)", "view", false);
		$list->setDblClickFunction("objectActions(3)");
	}
	$list->setClickFunction("enableDisable()");
	$list->setHiddenObject("cdobject");
	$list->setHiddenFields(array("cdobject"));
	$list->printList("dvObjectGrid");
?>
</div>
<script type="text/javascript">
	function objectActions(action)
	{
		cdobject = document.getElementById("cdobject").value;
		
		switch(action) {
			case 1: window_open("item_data.php?action="+action+"&cdcompany=<?= $_REQUEST['cdcompany']?>", 500, 125); break;
			case 2: window_open("item_data.php?action="+action+"&cdobject="+cdobject+"&cdcompany=<?= $_REQUEST['cdcompany']?>", 500, 125); break; // Abre tela "editar"
			case 3: window_open("item_data.php?action=2&view=1&cdobject="+cdobject+"&cdcompany=<?= $_REQUEST['cdcompany']?>", 500, 125); break; // Abre tela "visualizar"
		}
	}
	
	function enableDisable()
	{
		if(document.getElementById("cdobject") && document.getElementById("cdobject").value > 0) {
			if(document.getElementById("btn_edit"))
				enableButton("btn_edit");
			else if(document.getElementById("btn_view"))
				enableButton("btn_view");
		} else {
			if(document.getElementById("btn_edit"))
				disableButton("btn_edit");
			else if(document.getElementById("btn_view"))
				disableButton("btn_view");
		}
	}
</script>
</body>
</html>