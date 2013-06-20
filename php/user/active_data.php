<? 
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tela de Ativação</title>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$utils = new utils();
	$conn = new dba_connect();
?>
</head>
<body style="margin:10px;" bgcolor="#333333">
<?
	$utils->imageButton("Ativar", "btnactive", "btnactive", "verifyCode()", "execute");
	$utils->beginDivBorder(true);
?>
	<form id="form" name="form" >
		<table style="width:100%">
			<tr>
				<td>
					<?$utils->inputText("Login", "login", "login", 100,"width:510px;");?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;">
					<?$utils->inputText("Chave", "actice_code", "actice_code", 60,"width:510px;");?>
				</td>
			</tr>
		</table>
	</form>
<? $utils->endDivBorder(); ?>

<script type="text/javascript">
	<?$utils->writeJS();?>
	<?include_once("../../js/rpc.js");?>
	
	function verifyCode()
	{
		RPC = new REQUEST("portal/veider_request.php?type=2&actice_code="+document.getElementById('actice_code').value+"&login="+document.getElementById('login').value);
		retorno = RPC.Response(null);
		
		if(retorno == 0)
		{
			alert('Chave invalida');
			document.getElementById('actice_code').value = '';
			document.getElementById('login').value = '';
		}
		else
		{
			alert('Ativação efetuada');
			window.close();
		}
	}
	
	divBorderHeight(30);
</script>
</body>
</html>