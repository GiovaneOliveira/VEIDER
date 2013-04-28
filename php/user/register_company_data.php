<? 
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Cadastro de administrador</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
		$admin_login = $_SESSION['user_login'];
		$admin_mail = $_SESSION['user_mail'];
		$nmcompany = "";
		$dsadress_company = "";
		$nrphone_company = "";
		$nrphone_company = "";
		$nmstate_company = "";
		$nmcity_company = "";
		$img_company ="img_null.png";
	}
	/*else if($_REQUEST['action'] == 2)
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
	}*/

	$utils->imageButton("Registrar", "btnregister", "btnregister", "save()", "save");
	$utils->beginDivBorder(true);
?>
	<form action="register_company_action.php?action=<?=$_REQUEST['action']?>" method="post" enctype="multipart/form-data" target="_self" id="form" name="form" >
		<table style="width:100%">
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Administrador", "admin_login", "admin_login", 60,"width:510px;", $admin_login, true, false);?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Empresa", "nmcompany", "nmcompany", 60,"width:510px;", $nmcompany, true, true, false, array("onblur"=>"verifyCompany()"));?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputText("Email", "admin_mail", "admin_mail", 50, "width:245px;", $admin_mail, true, false);?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputText("Telefone", "nrphone_company", "nrphone_company", 10, "width:245px;", $nrphone_company, true);?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputCombobox("Estado", "nmstate_company", "nmstate_company", "width:250px;", array("Estado"), "", $nmstate_company, true);?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputCombobox("Cidade", "nmcity_company", "nmcity_company", "width:250px;", array("Cidade"), "", $nmcity_company, true);?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Endereço", "dsadress_company", "dsadress_company", 50, "width:510px;", $dsadress_company, true);?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;" colspan="2">
					<?$utils->inputFile("Foto", "flphoto_company", "flphoto_company", "width: 100%", "verifyImage()");?>
				</td>
			</tr>
		</table>
		<? $utils->inputDivImg("img_company", "img_company", 500, 100,"position:absolute; right:30px; bottom:30px; border-color:black; border-width:1px; border-style:solid",$img_company);?>
	</form>
<? $utils->endDivBorder(); ?>

<script type="text/javascript">
	<?$utils->writeJS();?>
	<?verifyFormatImg("flphoto_company","img_company");?>
	<?include_once("../../js/rpc.js");?>
	
	function verifyLogin()
	{
		RPC = new REQUEST("portal/veider_request.php?type=4&action=<?=$_REQUEST['action']?>&nmcompany="+document.getElementById('nmcompany').value);
		retorno = RPC.Response(null);
		
		if(retorno == 1)
		{
			alert('Este Login já está registrado');
			document.getElementById('idlogin').value = '';
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