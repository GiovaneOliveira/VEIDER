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
<body style="background-color:#333333; overflow:hidden;">
<input type="hidden" id="cdroom" name="cdroom">
<div id="dvRoomGrid" id="dvRoomGrid" class="dvToGrid">
<?
	$sql = "SELECT ROOM.CDROOM, ROOM.CDCOMPANY,ROOM.NMROOM, ROOM.DSROOM, ROOM.VLHOUR
				FROM VRROOM ROOM, VRCOMPANY COMP
				WHERE ROOM.CDCOMPANY = COMP.CDCOMPANY
				AND ROOM.CDCOMPANY = ".$_REQUEST['cdcompany']."
				ORDER BY ROOM.NMROOM";
	$ex = $conn->query($sql);
	
	$list->setQueryFields($ex);
	$list->setFieldNames(array("NMROOM", "DSROOM", "VLHOUR"));
	$list->setTitleNames(array("NOME", "ENDEREÇO", "VALOR DA RESERVA (R$)"));
	$list->setColWidth(array("400px", "400px", "200px"));
	$list->setColAlign(array("left", "left", "right"));
	$list->setHasToolbar(true);
	if(isset($_SESSION['CDCOMPANY']) && $_SESSION['CDCOMPANY'] == $_REQUEST['cdcompany']) {
		$list->addButton("Novo", "btn_new", "btn_new", "roomActions(1)", "new", true);
		$list->addButton("Editar", "btn_edit", "btn_edit", "roomActions(2)", "edit", false);
		$list->setDblClickFunction("roomActions(2)");
	} else {
		$list->addButton("Visualizar", "btn_view", "btn_view", "roomActions(3)", "view", false);
		$list->setDblClickFunction("roomActions(3)");
	}
	$list->setClickFunction("enableDisable()");
	$list->setHiddenObject("cdroom");
	$list->setHiddenFields(array("cdroom"));
	$list->printList("dvRoomGrid");
?>
</div>
<script type="text/javascript">
	function roomActions(action)
	{
		cdroom = document.getElementById("cdroom").value;
		
		switch(action) {
			case 1: window_open("room_data.php?action="+action+"&cdcompany=<?= $_REQUEST['cdcompany']?>", 800, 600); break;
			case 2: window_open("room_data.php?action="+action+"&cdroom="+cdroom+"&cdcompany=<?= $_REQUEST['cdcompany']?>", 800, 600); break; // Abre tela "editar"
			case 3: window_open("room_data.php?action=2&cdroom="+cdroom+"&view=1&cdcompany=<?= $_REQUEST['cdcompany']?>", 800, 600); break; // Abre tela "visualizar"
		}
	}
	
	function openCalendar()
	{
		alert("Abre calendário");
	}
	
	function enableDisable()
	{
		if(document.getElementById("cdroom") && document.getElementById("cdroom").value > 0) {
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