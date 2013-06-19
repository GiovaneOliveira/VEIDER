<? 
	require_once("../../class/veider_functions.inc");
	loading();
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
		$cduser = "";
		$nmuser = "";
		$idlogin = "";
		$idpassword = "";
		$idpassword_confirm = "";
		$idmail = "";
		$nrphone = "";
		$cdstate = "";
		$cdcity = "";
		$dsadress = "";
		$img_register ="img_null.png";
	}
	else if($_REQUEST['action'] == 2)
	{
		$cduser = $_REQUEST['cduser'];
		$ex = $conn->query("SELECT * FROM VRUSER WHERE CDUSER =".$_REQUEST['cduser']);
		
		$nmuser = $ex[0]['nmuser'];
		$idlogin = $ex[0]['idlogin'];
		$idpassword = decrypt($ex[0]['idmail'], $ex[0]['idpassword']);
		$idpassword_confirm = decrypt($ex[0]['idlogin'], $ex[0]['idpassword']);
		$idmail = $ex[0]['idmail'];
		$nrphone = $ex[0]['nrphone'];
		$cdstate = $ex[0]['cdstate'];
		$cdcity = $ex[0]['cdcity'];
		$dsadress = $ex[0]['dsadress'];
		$img_register = $ex[0]['flphoto'];
	}
	
	if(isset($_REQUEST['view']) && $_REQUEST['view'] == 1)
		$enabled = false;
	else
		$enabled = true;
	
	$utils->imageButton("Registrar", "btnregister", "btnregister", "save()", "save", $enabled);
	$utils->beginDivBorder(true);
?>
	<form action="register_user_action.php?action=<?echo $_REQUEST['action']?>.&cduser=<?echo $cduser;?>" method="post" enctype="multipart/form-data" target="_self" id="form" name="form" >
		<table style="width:100%">
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Nome", "nmuser", "nmuser", 100,"width:510px;", $nmuser, true, $enabled);?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Login", "idlogin", "idlogin", 100, "width:510px;", $idlogin, true, $enabled, false, array("onblur"=>"verifyField(this.id, 'login')"));?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputText("Senha", "idpassword", "idpassword", 50, "width:245px;", $idpassword, true, $enabled, true, array("onblur"=>"verifyPass()"));?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputText("Confirme sua senha", "idpassword_confirm", "idpassword_confirm", 50, "width:245px;", $idpassword_confirm, true, $enabled, true, array("onblur"=>"verifyPass()"));?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputText("Email", "idmail", "idmail", 100, "width:245px;", $idmail, true, $enabled, false, array("onblur"=>"verifyField(this.id, 'e-mail')"));?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputText("Telefone", "nrphone", "nrphone", 10, "width:245px;", $nrphone, true, $enabled);?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputStateCombo("width:245px;", $cdstate, $enabled);?>
				</td>
				<td style="padding-left:10px; width:50%; padding-top:10px;">
					<?$utils->inputCityCombo("width:245px;", $cdcity, $enabled);?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Endereço", "dsadress", "dsadress", 100, "width:510px;", $dsadress, true, $enabled);?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;" colspan="2">
					<?$utils->inputFile("Foto", "flphoto", "flphoto", "width: 70%", "verifyImage()", $enabled);?>
				</td>
			</tr>
		</table>
		<? $utils->inputDivImg("img_register", "img_register", 100, 100,"position:absolute; right:30px; bottom:30px; border-color:black; border-width:1px; border-style:solid",$img_register);?>
	</form>
<? $utils->endDivBorder(); ?>

<script type="text/javascript">
	<?
        verifyFormatImg("flphoto", "img_register");
		include_once("../../js/rpc.js");
        $utils->writeJS();
    ?>
	
	function verifyField(field, msg)
	{
		var action = <? echo $_REQUEST['action']; ?>;
		var value = document.getElementById(field).value;
		var field = field.toUpperCase();
		var table = "VRUSER";
		var whereField = "CDUSER";
		
		RPC = new REQUEST("portal/veider_request.php?type=1&action="+action+"&value="+value+"&field="+field+"&table="+table);
		retorno = RPC.Response(null);
		
		if(retorno == 1) {
			alert("Este "+msg+" já está registrado");
			document.getElementById(field).value = "";
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
		if(required(document.getElementById("form"))) { // Retorna true se todos os campos requeridos estiverem preenchidos
			showLoading();
			document.getElementById("form").submit();
		}
	}
	
	divBorderHeight(30);
</script>
</body>
</html>