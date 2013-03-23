<? 
	require_once("../class/class.utils.inc");
	require_once("../class/veider_functions.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Cadastro de usuário</title>
<?
	$utils = new utils();
?>
</head>
<body style="margin:10px;" bgcolor="#333333">
<?
	$utils->imageButton("Registrar", "btnregister", "btnregister", "verifySubmit();", "../image/button_icon/save.gif");
	$utils->beginDivBorder(true);
?>
	<form action="register_user_action.php" method="post" enctype="multipart/form-data" target="_self" id="form" name="form" >
		<table style="width:100%">
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Nome *", "nmuser", "nmuser", "width:510px;");?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Login *", "idlogin", "idlogin", "width:510px;");?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputText("Senha *", "idpassword", "idpassword", "width:245px;", true);?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputText("Confirme sua senha *", "idpassword_confirm", "idpassword_confirm", "width:245px;", true);?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputText("Email *", "idmail", "idmail", "width:245px;");?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputText("Telefone *", "nrphone", "nrphone", "width:245px;");?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputCombobox("Estado *", "nmstate", "nmstate", "width:250px;", array("Estado"));?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputCombobox("Cidade *", "nmcity", "nmcity", "width:250px;", array("Cidade"));?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Endereço *", "dsadress", "dsadress", "width:510px;");?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;" colspan="2">
					<?$utils->inputFile("Foto", "flphoto", "flphoto", "width: 70%", "verifyImage()");?>
				</td>
			</tr>
		</table>
		
		<div id="divteste" style="position:absolute; right:30px; bottom:30px; width:100px; height:100px; border-color:black; border-width:1px; border-style:solid">
			<img id="img1" name="img1" width="100px" height="100px" src="../temp/img_null.png" />
		</div>
	</form>
<? $utils->endDivBorder(); ?>

<script type="text/javascript">
	<?$utils->writeJS();?>
	<?verifyFormatImg("flphoto","img1");?>
	<?verifyRequired(array("nmuser","idlogin","idpassword","idpassword_confirm","idmail","nrphone","nmstate","nmcity","dsadress"),"form");?>
	<?include_once("../js/rpc.js");?>
	
	document.getElementById('idlogin').setAttribute('onblur','verifyLogin()');
	document.getElementById('idpassword').setAttribute('onblur','verifyPass()');
	document.getElementById('idpassword_confirm').setAttribute('onblur','verifyPass()');
	
	function verifyLogin()
	{
		RPC = new REQUEST("veider_request.php?type=1&idlogin="+document.getElementById('idlogin').value, "../php/");
		retorno = RPC.Response(null);
		
		if(retorno == 1)
		{
			alert('Este Login já está registrado');
			document.getElementById('idlogin').value = '';
		}
	}
	
	function verifyPass()
	{
		if(document.getElementById('idpassword').value != '' && document.getElementById('idpassword_confirm').value != '' && document.getElementById('idpassword').value != document.getElementById('idpassword_confirm').value)
		{
			alert("Senha confirmada incorretamente");
			document.getElementById('idpassword_confirm').value = '';
		}
	}
	
	divBorderHeight(30);
</script>
</body>
</html>