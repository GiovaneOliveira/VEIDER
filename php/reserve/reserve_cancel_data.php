<?
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?echo ($_REQUEST['type'] == 2)? "Cancelamento" : "Encerramento"; ?> de reserva</title>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$utils = new utils();
	$conn = new dba_connect();
	$enabled = (isset($_REQUEST['view']) && $_REQUEST['view'] == 1)? false : true;
?>
</head>
<body>
<?
	$sql = "SELECT RE.CDRESERVE, RE.DTREQUEST, RE.DSJUSTIFY, RO.NMROOM FROM VRRESERVE RE, VRROOM RO
			WHERE RE.CDROOM = RO.CDROOM AND CDRESERVE = ".$_REQUEST['cdreserve'];
	$fields = $conn->query($sql);
	
	$utils->imageButton("Salvar", "btn_save", "btn_save", "save()", "save", $enabled);
	$utils->beginDivBorder(true);
?>
<form id="form" name="form" action="reserve_cancel_action.php?type=<?echo $_REQUEST['type']?>&cdreserve=<?echo $_REQUEST['cdreserve']?>" method="post" target="_self">
	<table cellpadding="0" cellspacing="0" style="width:100%;">
		<tr>
			<td style="padding-top:10px;">
				<?$utils->inputText("Espaço","nmroom","nmroom",100,"width:408px;",$fields[0]['nmroom'],false,false);?>
			</td>
			<td style="padding-top:10px; padding-left:10px;">
				<?$utils->inputText("Data","dtrequest","dtrequest",100,"width:75px",formatDate($fields[0]['dtrequest']),false,false);?>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-top:10px;">
				<?$utils->inputTextArea("Justificativa", "dsjustify", "dsjustify", "width:100%; height:190px;", ($enabled? "" : $fields[0]['dsjustify']), ($_REQUEST['type'] == 3? false : $enabled), $enabled);?>
			</td>
		</tr>
	</table>
</form>
<?$utils->endDivBorder();?>
<script type="text/javascript">
	function save() {
		if(required(document.getElementById("form"))) {
			document.getElementById("form").submit();
		}
	}
	
	divBorderHeight(30);
</script>
</body>
</html>