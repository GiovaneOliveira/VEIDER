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
<title>Cadastro de empresa</title>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$utils = new utils();
	$conn = new dba_connect();
?>
</head>
<body style="margin:10px;" bgcolor="#333333">
<?
	if(isset($_REQUEST['cdcompany']) && !empty($_REQUEST['cdcompany'])) {
		$sql = "SELECT US.NMUSER, US.IDMAIL FROM VRUSER US, VRCOMPANY COMP WHERE US.CDUSER = COMP.CDADMIN AND COMP.CDCOMPANY = ".$_REQUEST['cdcompany'];
		$form = "&company=".$_REQUEST['cdcompany'];
	} else {
		$sql = "SELECT NMUSER, IDMAIL FROM VRUSER WHERE CDUSER = ".$_REQUEST['cduser'];
		$form = "&cduser=".$_REQUEST['cduser'];
	}
	$exUser = $conn->query($sql);

	if($_REQUEST['action'] == 1)
	{
		$idlogin = $exUser[0]['nmuser'];
		$idmail = $exUser[0]['idmail'];
		$nmcompany = "";
		$dsadress = "";
		$nrphone = "";
		$cdstate = "";
		$cdcity = "";
		$img_company ="logo_portal.png";
	}
	else if($_REQUEST['action'] == 2)
	{
		$ex = $conn->query("SELECT * FROM VRCOMPANY WHERE CDCOMPANY =".$_REQUEST['cdcompany']);
	
		$idlogin = $exUser[0]['nmuser'];
		$idmail = $exUser[0]['idmail'];
		$nmcompany = $ex[0]['nmcompany'];
		$dsadress = $ex[0]['dsadress'];
		$nrphone = $ex[0]['nrphone'];
		$cdstate = $ex[0]['cdstate'];
		$cdcity = $ex[0]['cdcity'];
		$img_company = $ex[0]['fllogo'];
	}
	
	
	if(isset($_REQUEST['view']) && $_REQUEST['view'] == 1)
		$enabled = false;
	else
		$enabled = true;
	
	$utils->imageButton("Registrar", "btnregister", "btnregister", "save()", "save", $enabled);
	$utils->beginDivBorder(true);
?>
	<form id="form" name="form" action="register_company_action.php?action=<? echo $_REQUEST['action'].$form; ?>" method="post" enctype="multipart/form-data" target="_self">
		<table style="width:100%">
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Administrador", "idlogin", "idlogin", 100,"width:510px;", $idlogin, true, false);?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;">
					<?$utils->inputText("Empresa", "nmcompany", "nmcompany", 100,"width:510px;", $nmcompany, true, $enabled, false, array("onblur"=>"verifyCompany()"));?>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding-top:10px;">
					<?$utils->inputText("Email", "idmail", "idmail", 100, "width:245px;", $idmail, true, false);?>
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
					<?$utils->inputFile("Logo", "fllogo", "fllogo", "width: 100%", "verifyImage()", $enabled);?>
				</td>
			</tr>
		</table>
		<? $utils->inputDivImg("img_company", "img_company", 500, 100,"position:absolute; right:30px; bottom:30px; border-color:black; border-width:1px; border-style:solid",$img_company);?>
	</form>
<? $utils->endDivBorder(); ?>

<script type="text/javascript">
	<?
		verifyFormatImg("fllogo", "img_company");
		include_once("../../js/rpc.js");
        $utils->writeJS();
	?>
	
	function verifyCompany()
	{
		var value = document.getElementById("nmcompany").value;
		var field = "NMCOMPANY";
		var table = "VRCOMPANY";
		var whereField = "CDADMIN";
		var action = <?echo $_REQUEST['action']?>;
		
		RPC = new REQUEST("portal/veider_request.php?type=1&action="+action+"&value="+value+"&field="+field+"&table="+table);
		retorno = RPC.Response(null);
		
		if(retorno == 1) {
			alert('Este empresa já está registrada');
			document.getElementById('nmcompany').value = '';
			document.getElementById('nmcompany').focus();
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