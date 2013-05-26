<? 
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Cadastro de usuário</title>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
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
		$ex = $conn->query("SELECT * FROM VRUSER WHERE CDUSER =".$_SESSION['CDUSER']);
	
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

	$utils->imageButton("Registrar", "btnregister", "btnregister", "save()", "save");
	$utils->beginDivBorder(true);
?>
	<form action="register_user_action.php?action=<?=$_REQUEST['action']?>" method="post" enctype="multipart/form-data" target="_self" id="form" name="form" >
		<table style="width:100%">
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Nome", "nmuser", "nmuser", 60,"width:510px;", $nmuser, true);?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Login", "idlogin", "idlogin", 15, "width:510px;", $idlogin, true, true, false, array("onblur"=>"verifyLogin()"));?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputText("Senha", "idpassword", "idpassword", 50, "width:245px;", $idpassword, true, true, true, array("onblur"=>"verifyPass()"));?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputText("Confirme sua senha", "idpassword_confirm", "idpassword_confirm", 50, "width:245px;", $idpassword_confirm, true, true, true, array("onblur"=>"verifyPass()"));?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputText("Email", "idmail", "idmail", 50, "width:245px;", $idmail, true, true, false, array("onblur"=>"verifyMail()"));?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputText("Telefone", "nrphone", "nrphone", 10, "width:245px;", $nrphone, true);?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputCombobox("Estado", "nmstate", "nmstate", "width:250px;", array("Estado"), "", $nmstate, true);?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputCombobox("Cidade", "nmcity", "nmcity", "width:250px;", array("Cidade"), "", $nmcity, true);?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Endereço", "dsadress", "dsadress", 50, "width:510px;", $dsadress, true);?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;" colspan="2">
					<?$utils->inputFile("Foto", "flphoto", "flphoto", "width: 70%", "verifyImage()");?>
				</td>
			</tr>
		</table>
		<? $utils->inputDivImg("img_register", "img_register", 100, 100,"position:absolute; right:30px; bottom:30px; border-color:black; border-width:1px; border-style:solid",$img_register);?>
	</form>
<? $utils->endDivBorder(); ?>

<script type="text/javascript">
	<?$utils->writeJS();?>
	<?verifyFormatImg("flphoto","img_register");?>
	<?include_once("../../js/rpc.js");?>
	
	function verifyLogin()
	{
		RPC = new REQUEST("portal/veider_request.php?type=1&action=<?=$_REQUEST['action']?>&idlogin="+document.getElementById('idlogin').value);
		retorno = RPC.Response(null);
		
		if(retorno == 1)
		{
			alert('Este Login já está registrado');
			document.getElementById('idlogin').value = '';
		}
	}
	
	function verifyMail()
	{
		RPC = new REQUEST("portal/veider_request.php?type=2&action=<?=$_REQUEST['action']?>&idmail="+document.getElementById('idmail').value);
		retorno = RPC.Response(null);
		
		if(retorno == 1)
		{
			alert('Este E-mail já está registrado');
			document.getElementById('idmail').value = '';
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
	
	function save(){
		if(required(document.getElementById("form"))) // Retorna true se todos os campos requeridos estiverem preenchidos
			document.getElementById("form").submit();
	}
	
	divBorderHeight(30);
</script>
</body>
</html>