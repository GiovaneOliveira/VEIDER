<?
	require_once("../../class/veider_functions.inc");
	loading();
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.dba_connect.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Dados da sugestão</title>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$utils = new utils();
	$conn = new dba_connect();
	$view = (isset($_REQUEST['view']) && $_REQUEST['view'] == 1)? true : false;
?>
</head>
<body style="margin:10px;">
<?
	if($view) {
		$sql = "SELECT SUG.NMSUGGESTION, US.NMUSER, SUG.DTSUGGESTION, SUG.DSSUGGESTION, COMP.NMCOMPANY
				FROM VRSUGGESTION SUG, VRUSER US, VRCOMPANY COMP
				WHERE SUG.CDUSER = US.CDUSER
				AND SUG.CDCOMPANY = COMP.CDCOMPANY
				AND SUG.CDSUGGESTION = ".$_REQUEST['cdsuggestion'];
		$data = $conn->query($sql);
	} else {
		$company = $conn->query("SELECT NMCOMPANY FROM VRCOMPANY WHERE CDCOMPANY = ".$_REQUEST['cdcompany']);
		$user = $conn->query("SELECT NMUSER FROM VRUSER WHERE CDUSER = ".$_SESSION['CDUSER']);
		$data[0] = array("nmcompany"=>$company[0]['nmcompany'], "nmuser"=>$user[0]['nmuser']);
	}
	$conn->close();
	
	$utils->imageButton("Salvar", "btn_save", "btn_save", "save()", "save", ($view? false : true));
	$utils->beginDivBorder(true);
?>
	<form id="form" name="form" action="suggestion_action.php?type=1&cdcompany=<?echo $_REQUEST['cdcompany'];?>&cduser=<?echo $_SESSION['CDUSER']?>" method="post" target="_self">
		<table cellpadding="0" cellspacing="0" style="width:100%;">
			<tr>
				<td style="padding-top:10px;">
					<?$utils->inputText("Empresa", "nmcompany", "nmcompany", 100, "width:100%;", $data[0]['nmcompany'], false, false);?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;">
					<?$utils->inputText("Usuário", "nmuser", "nmuser", 100, "width:100%;", $data[0]['nmuser'], false, false);?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;">
					<?$utils->inputText("Sugestão", "nmsuggestion", "nmsuggestion", 100, "width:100%;", ($view? $data[0]['nmsuggestion'] : ""), ($view? false : true), ($view? false : true));?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;">
					<?$utils->inputTextArea("Descrição", "dssuggestion", "dssuggestion", "width:100%; height:235px;", ($view? $data[0]['dssuggestion'] : ""), ($view? false : true), ($view? false : true));?>
				</td>
			</tr>
		</table>
	</form>
<?$utils->endDivBorder();?>
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