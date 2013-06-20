<? 
	require_once("../../class/veider_functions.inc");
	loading();
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.dba_connect.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Dados da notícia</title>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$utils = new utils();
	$conn = new dba_connect();
	$view = (isset($_REQUEST['view']) && $_REQUEST['view'] == 1)? true : false;
?>
</head>
<body style="margin:10px;" bgcolor="#333333">
<?
	if($view) {
		$sql = "SELECT NOTI.NMNOTICE, NOTI.DSNOTICE, COMP.NMCOMPANY, NOTI.CDCOMPANY
				FROM VRNOTICE NOTI, VRCOMPANY COMP WHERE NOTI.CDCOMPANY = COMP.CDCOMPANY
				AND NOTI.CDNOTICE = ".$_REQUEST['cdnotice'];
		$data = $conn->query($sql);
	}
	else {
		$data = $conn->query("SELECT NMCOMPANY FROM VRCOMPANY WHERE CDCOMPANY = ".$_REQUEST['cdcompany']);
	}
	
	$utils->imageButton("Salvar", "btn_save", "btn_save", "save()", "save", ($view? false : true));
	$utils->beginDivBorder(true);
?>
	<form action="notice_action.php?cdcompany=<?echo !$view? $_REQUEST['cdcompany'] : "" ?>" method="post" target="_self" id="form" name="form">
		<table style="width:100%">
			<tr>
				<td style="padding-top:10px;">
					<?$utils->inputText("Empresa", "nmcompany", "nmcompany", 100, "width:100%;", $data[0]['nmcompany'], false, false);?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;">
					<?$utils->inputText("Notícia", "nmnotice", "nmnotice", 100, "width:100%;", ($view? $data[0]['nmnotice'] : ""), ($view? false : true), ($view? false : true));?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;">
					<?$utils->inputTextArea("Descrição", "dsnotice", "dsnotice", "width:100%; height:235px;", ($view? $data[0]['dsnotice'] : ""), ($view? false : true), ($view? false : true));?>
				</td>
			</tr>
		</table>
	</form>
<? $utils->endDivBorder(); ?>

<script type="text/javascript">
	function save(){
		if(required(document.getElementById("form"))) { // Retorna true se todos os campos requeridos estiverem preenchidos
			showLoading();
			document.getElementById("form").submit();
		}
	}
	
	divBorderHeight(30);
</script>
</body>
</html>