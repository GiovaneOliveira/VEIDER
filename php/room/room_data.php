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
	$exCompany = $conn->query("SELECT CDSTATE, CDCITY FROM VRCOMPANY WHERE CDCOMPANY = '".$_REQUEST['cdcompany']."'");
	
	if($_REQUEST['action'] == 1)
	{
		$nmroom = "";
		$vlhour = "";
		$dsadress = "";
		$dsroom = "";
		$cdstate = $exCompany[0]['cdstate'];
		$cdcity = $exCompany[0]['cdcity'];
		$hourst = "";
		$hourend = "";
		$fgsunday = 1;
		$fgmonday = 1;
		$fgtuesday = 1;
		$fgwednesday = 1;
		$fgthursday = 1;
		$fgfriday = 1;
		$fgsaturday = 1;
	}
	else if($_REQUEST['action'] == 2)
	{
		$exRoom = $conn->query("SELECT NMROOM, VLHOUR, DSADRESS, DSROOM, HOURST, HOUREND, FGSUNDAY, FGMONDAY, FGTUESDAY, FGWEDNESDAY, FGTHURSDAY, FGFRIDAY, FGSATURDAY FROM VRROOM WHERE CDROOM = '".$_REQUEST['cdroom']."'");
		
		$nmroom = $exRoom[0]['nmroom'];
		$vlhour = $exRoom[0]['vlhour'];
		$dsadress = $exRoom[0]['dsadress'];
		$dsroom = $exRoom[0]['dsroom'];
		$cdstate = $exCompany[0]['cdstate'];
		$cdcity = $exCompany[0]['cdcity'];
		$hourst = $exRoom[0]['hourst'];
		$hourend = $exRoom[0]['hourend'];
		$fgsunday = $exRoom[0]['fgsunday'];
		$fgmonday = $exRoom[0]['fgmonday'];
		$fgtuesday = $exRoom[0]['fgtuesday'];
		$fgwednesday = $exRoom[0]['fgwednesday'];
		$fgthursday = $exRoom[0]['fgthursday'];
		$fgfriday = $exRoom[0]['fgfriday'];
		$fgsaturday = $exRoom[0]['fgsaturday'];
	}

	$utils->imageButton("Registrar", "btnregister", "btnregister", "save()", "save");
	$utils->imageButton("Visualizar imagem", "btnview_img", "btnview_img", "opa()", "photo");
	$utils->beginDivBorder(true);
?>
	<form action="room_action.php?action=<?=$_REQUEST['action']?>&cdcompany=<?=$_REQUEST['cdcompany']?>" method="post" enctype="multipart/form-data" target="_self" id="form" name="form" >
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr> 
				<td style="padding-top: 10px; width: 80%">
					<?$utils->inputText("Nome","nmroom","nmroom",60,"width:550px",$nmroom,true)?>
				</td>
				<td style="padding-left: 10px; padding-top: 10px; width: 20%">
					<?$utils->inputText("Valor hora (R$)","vlhour","vlhour", 5, "width:115px",$vlhour,true,true,false, array("onblur"=>"verifyValue()"));?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 10px;">
					<?$utils->inputText("Endereço","dsadress","dsadress",50,"width:680px",$dsadress,true)?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table cellpadding="0" cellspacing="0" style="width:100%;">
						<tr>
							<td style="width:50%; padding-top:10px;">
								<?$utils->inputStateCombo("width:325px;", $cdstate, false);?>
							</td>
							<td style="padding-left:10px; width:50%; padding-top:10px;">
								<?$utils->inputCityCombo("width:325px;", $cdcity, false);?>
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
									<?$utils->inputCombobox("Horário de início", "hourst", "hourst", "width:300px;", makeHours(), "", $hourst, true);?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCombobox("Horário de término", "hourend", "hourend", "width:300px;", makeHours(), "", $hourend, true);?>
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
									<?$utils->inputCheckbox("Domingo", 1, "fgsunday", "fgsunday",false, ($fgsunday == 1)?true:false);?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Segunda-Feira", 1, "fgmonday", "fgmonday",false, ($fgmonday == 1)?true:false);?>
								</td>
							</tr>
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Terça-Feira", 1, "fgtuesday", "fgtuesday",false, ($fgtuesday == 1)?true:false);?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Quarta-Feira", 1, "fgwednesday", "fgwednesday",false, ($fgwednesday == 1)?true:false);?>
								</td>
							</tr>
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Quinta-Feira", 1, "fgthursday", "fgthursday",false, ($fgthursday == 1)?true:false);?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Sexta-Feira", 1, "fgfriday", "fgfriday",false, ($fgfriday == 1)?true:false);?>
								</td>
							</tr>
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Sábado", 1, "fgsaturday", "fgsaturday",false, ($fgsaturday == 1)?true:false);?>
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