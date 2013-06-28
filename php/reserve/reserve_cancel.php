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
<input type="hidden" id="cdreserve" name="cdreserve">
<div id="dvGrid" name="dvGrid" class="dvToGrid">
<?
	$sql = "SELECT CASE RES.FGSITUATION
							WHEN 1
								THEN 'Aberta'
							WHEN 2
								THEN 'Cancelada'
							ELSE
								'Encerrada'
						END AS FGSITUATIONNAME,
			DATEDIFF(DAY, RES.DTREQUEST, GETDATE()) AS DIFDATE,
			RES.CDRESERVE, RES.FGSITUATION, US.NMUSER, RO.NMROOM, RES.VLRESERVE, RES.DTREQUEST, RES.DTREGISTER
			FROM VRRESERVE RES, VRUSER US, VRROOM RO
			WHERE US.CDUSER = RES.CDUSER
			AND RO.CDROOM = RES.CDROOM
			AND RO.CDCOMPANY = ".$_REQUEST['cdcompany'].
			((isset($_REQUEST['cduser']) && $_REQUEST['cduser'] != "")? " AND RES.CDUSER = ".$_REQUEST['cduser'] : "")."
			ORDER BY RES.DTREQUEST DESC";
	$fields = $conn->query($sql);
	
	$list->setQueryFields($fields);
	$list->setFieldNames(array("FGSITUATIONNAME", "NMUSER", "NMROOM", "VLRESERVE", "DTREQUEST", "DTREGISTER"));
	$list->setTitleNames(array("SITUAÇÃO", "USUÁRIO", "ESPAÇO", "VALOR (R$)", "DATA RESERVADA", "REGISTRADO EM"));
	$list->setColWidth(array("200px", "200px", "200px", "100px", "100px", "100px"));
	$list->setColAlign(array("left", "left", "left", "right", "right", "right"));
	$list->setDateCols(array("DTREQUEST", "DTREGISTER"));
	$list->setClickFunction("enableBtn()");
	$list->setDblClickFunction("action(1)");
	$list->setHiddenObject("cdreserve");
	$list->setHiddenFields(array("cdreserve", "fgsituation", "difdate"));
	$list->setHasToolbar(true);
	if(!isset($_REQUEST['cduser']))
		$list->addButton("Encerrar", "btn_execute", "btn_execute", "action(1)", "execute", false);
	$list->addButton("Cancelar", "btn_cancel", "btn_cancel", "action(2)", "disable", false);
	$list->printList("dvGrid");
?>
</div>
<iframe id="iframeAction" name="iframeAction" style="width:0px; height:0px; visibility:hidden; position:absolute;"></iframe>
<script type="text/javascript">
	function action(type) {
		cdreserve = document.getElementById('cdreserve').value.split(";")[0];
		
		switch(type) {
			case 1:
				window_open("reserve_cancel_data.php?type=3&cdreserve="+cdreserve, 600, 300);
				break;
			case 2:
				window_open("reserve_cancel_data.php?type=2&cdreserve="+cdreserve, 600, 300);
				break;
		}
	}
	
	function enableBtn() {
		if(document.getElementById("cdreserve").value.split(";")[1] == 1) {
			if(document.getElementById("cdreserve").value.split(";")[2] > 0)
				if(document.getElementById("btn_execute"))
					enableButton("btn_execute");
			else
				if(document.getElementById("btn_execute"))
					disableButton("btn_execute");
			enableButton("btn_cancel");
		} else {
			disableButton("btn_cancel");
			if(document.getElementById("btn_execute"))
				disableButton("btn_execute");
		}
	}
</script>
</body>
</html>