<? 
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Cadastro de espaços</title>
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
		$exCompany = $conn->query("SELECT CDSTATE, CDCITY FROM VRCOMPANY WHERE CDCOMPANY = '".$_REQUEST['cdcompany']."'");
		
		$nmroom = "";
		$vlroom = "";
		$adressroom = "";
		$dsroom = "";
		$nmstate = $exCompany[0]['cdstate'];
		$nmcity = $exCompany[0]['cdcity'];
		$hoursst = "";
		$hoursend = "";
	}
	else if($_REQUEST['action'] == 2)
	{
		
	}

	$utils->imageButton("Registrar", "btnregister", "btnregister", "save()", "save");
	$utils->imageButton("Visualizar imagem", "btnview_img", "btnview_img", "opa()", "");
	$utils->beginDivBorder(true);
?>
	<form action="room_action.php?action=<?=$_REQUEST['action']?>&cdcompany=<?=$_REQUEST['cdcompany']?>" method="post" enctype="multipart/form-data" target="_self" id="form" name="form" >
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr> 
				<td style="padding-top: 10px; width: 80%">
					<?$utils->inputText("Nome","nmroom","nmroom",60,"width:550px",$nmroom,true)?>
				</td>
				<td style="padding-left: 10px; padding-top: 10px; width: 20%">
					<?$utils->inputText("Valor hora (R$)","vlhour","vlhour", 5, "width:115px",$vlroom,true,true,false, array("onblur"=>"verifyValue()"));?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 10px;">
					<?$utils->inputText("Endereço","dsadress","dsadress",50,"width:680px",$adressroom,true)?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table cellpadding="0" cellspacing="0" style="width:100%;">
						<tr>
							<td style="width:50%; padding-top:10px;">
								<?$utils->inputCombobox("Estado", "nmstate", "nmstate", "width:300px;", array(1 => "Estado"), "", $nmstate, true, false);?>
							</td>
							<td style="padding-left:10px; width:50%; padding-top:10px;">
								<?$utils->inputCombobox("Cidade", "nmcity", "nmcity", "width:300px;", array(1 => "Cidade"), "", $nmcity, true, false);?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 10px;">
					<?$utils->inputTextArea("Descrição","dsroom","dsroom","width:680px; height: 100px",$dsroom)?>
				</td>
			</tr>
			<tr> 
				<td style="padding-top:10px;" colspan="2">
					<?$utils->inputFile("Foto", "flphoto_room", "flphoto_room", "width: 100%", "verifyImage()");?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;" colspan="2">
					<fieldset style=" border-color: #333333">
						<legend>Configurações de horário</legend>
						<table cellpadding="0" cellspacing="0" style="width:100%; padding-bottom:10px;">
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCombobox("Horário de início", "hoursst", "hoursst", "width:300px;", makeHours(), "", $hoursst, true);?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCombobox("Horário de término", "hoursend", "hoursend", "width:300px;", makeHours(), "", $hoursend, true);?>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;" colspan="2">
					<fieldset style=" border-color: #333333">
						<legend>Configurações de dias da semana</legend>
						<table cellpadding="0" cellspacing="0" style="width:100%; padding-bottom:10px;">
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Domingo", 1, "fgsunday", "fgsunday");?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Segunda-Feira", 1, "fgmonday", "fgmonday");?>
								</td>
							</tr>
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Terça-Feira", 1, "fgtuesday", "fgtuesday");?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Quarta-Feira", 1, "fgwednesday", "fgwednesday");?>
								</td>
							</tr>
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Quinta-Feira", 1, "fgthursday", "fgthursday");?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Sexta-Feira", 1, "fgfriday", "fgfriday");?>
								</td>
							</tr>
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Sábado", 1, "fgsaturday", "fgsaturday");?>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
		</table>
	</form>
<? $utils->endDivBorder();?>

<script type="text/javascript">
	<?$utils->writeJS();?>
	<?verifyFormatImg("flphoto_company","img_company");?>
	<?include_once("../../js/rpc.js");?>
	
	function verifyValue(){
		if(isNaN(document.getElementById('vlhour').value)){
			alert('valor inválido');
			document.getElementById('vlhour').value = '';
		}
	}
	
	function save(){
		if(required(document.getElementById("form"))) // Retorna true se todos os campos requeridos estiverem preenchidos
			document.getElementById("form").submit();
	}
	
	function opa(){
		alert('opa');
	}
	
	divBorderHeight(30);
</script>
</body>
</html>