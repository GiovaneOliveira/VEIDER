<? 
	require_once("../class/class.utils.inc");
	require_once("../class/class.dba_connect.inc");
	require_once("../class/veider_functions.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Cadastro de usuário</title>
<?
	$utils = new utils();
	$conn = new dba_connect();
?>
</head>
<body style="margin:10px;" bgcolor="#333333">
<?
	if($_REQUEST['action'] == 1)
	{
		$nmuser = "";
		$idlogin = "";
		$idpassword = "";
		$idpassword_confirm = "";
		$idmail = "";
		$nrphone = "";
		$nmstate = "";
		$nmcity = "";
		$dsadress = "";
		$img_register ="img_null.png";
	}
	else if($_REQUEST['action'] == 2)
	{
		$ex = $conn->query("SELECT * FROM VRUSER WHERE CDUSER =".$_SESSION['user_code']);
	
		$nmuser = $ex[0]['nmuser'];
		$idlogin = $ex[0]['idlogin'];
		$idpassword = $ex[0]['idpassword'];
		$idpassword_confirm = $ex[0]['idpassword'];
		$idmail = $ex[0]['idmail'];
		$nrphone = $ex[0]['nrphone'];
		$nmstate = $ex[0]['cdstate'];
		$nmcity = $ex[0]['cdcity'];
		$dsadress = $ex[0]['dsadress'];
		$img_register = $ex[0]['flphoto'];
	}

	$utils->imageButton("Registrar", "btnregister", "btnregister", "verifySubmit();", "../image/button_icon/save.gif");
	$utils->beginDivBorder(true);
?>
	<form action="register_user_action.php?action=<?=$_REQUEST['action']?>" method="post" enctype="multipart/form-data" target="_self" id="form" name="form" >
		<table style="width:100%">
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Nome *", "nmuser", "nmuser", 60,"width:510px;", false, $nmuser);?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Login *", "idlogin", "idlogin", 15, "width:510px;", false, $idlogin);?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputText("Senha *", "idpassword", "idpassword", 50, "width:245px;", true, $idpassword);?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputText("Confirme sua senha *", "idpassword_confirm", "idpassword_confirm", 50, "width:245px;", true, $idpassword_confirm);?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputText("Email *", "idmail", "idmail", 50, "width:245px;", false, $idmail);?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputText("Telefone *", "nrphone", "nrphone", 10, "width:245px;", false, $nrphone);?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputCombobox("Estado *", "nmstate", "nmstate", "width:250px;", array("Estado"), "", $nmstate);?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputCombobox("Cidade *", "nmcity", "nmcity", "width:250px;", array("Cidade"), "", $nmcity);?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Endereço *", "dsadress", "dsadress", 50, "width:510px;", false, $dsadress);?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;" colspan="2">
					<?$utils->inputFile("Foto", "flphoto", "flphoto", "width: 70%", "verifyImage()");?>
				</td>
			</tr>
		</table>
		<? $utils->inputDivImg("img_register", "img_register", "position:absolute; right:30px; bottom:30px; border-color:black; border-width:1px; border-style:solid",$img_register);?>
	</form>
<? $utils->endDivBorder(); ?>

<script type="text/javascript">
	<?$utils->writeJS();?>
	<?verifyFormatImg("flphoto","img_register");?>
	<?verifyRequired(array("nmuser","idlogin","idpassword","idpassword_confirm","idmail","nrphone","nmstate","nmcity","dsadress"),"form");?>
	<?include_once("../js/rpc.js");?>
	
	document.getElementById('idlogin').setAttribute('onblur','verifyLogin()');
	document.getElementById('idpassword').setAttribute('onblur','verifyPass()');
	document.getElementById('idpassword_confirm').setAttribute('onblur','verifyPass()');
	
	function verifyLogin()
	{
		RPC = new REQUEST("veider_request.php?type=1&action=<?=$_REQUEST['action']?>&idlogin="+document.getElementById('idlogin').value, "../php/");
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