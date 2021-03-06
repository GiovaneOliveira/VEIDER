<? 
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Cadastro de espa�os</title>
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
		$hourst = 0;
		$hourend = 23;
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
	
	if(isset($_REQUEST['view']) && $_REQUEST['view'] == 1)
		$enabled = false;
	else
		$enabled = true;

	$utils->imageButton("Registrar", "btnregister", "btnregister", "save()", "save", $enabled);
	$utils->beginDivBorder(true);
?>
	<form action="room_action.php?action=<?=$_REQUEST['action']?>&cdcompany=<?=$_REQUEST['cdcompany']?>&cdroom=<?= $_REQUEST['action'] == 2? $_REQUEST['cdroom'] : -1?>" method="post" enctype="multipart/form-data" target="_self" id="form" name="form" >
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr> 
				<td style="padding-top: 10px; width: 80%">
					<?$utils->inputText("Nome","nmroom","nmroom",60,"width:550px",$nmroom,true,$enabled)?>
				</td>
				<td style="padding-left: 10px; padding-top: 10px; width: 20%">
					<?$utils->inputText("Valor hora (R$)","vlhour","vlhour", 5, "width:115px",$vlhour,true,$enabled,false, array("onblur"=>"verifyValue()"));?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 10px;">
					<?$utils->inputText("Endere�o","dsadress","dsadress",50,"width:680px",$dsadress,true,$enabled)?>
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
					<?$utils->inputTextArea("Descri��o","dsroom","dsroom","width:680px; height: 100px",$dsroom, true,$enabled)?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;" colspan="2">
					<fieldset style=" border-color: #333333">
						<legend>Configura��es de hor�rio</legend>
						<table cellpadding="0" cellspacing="0" style="width:100%; padding-bottom:10px;">
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCombobox("Hor�rio de in�cio", "hourst", "hourst", "width:300px;", makeHours(), "verifyHours()", $hourst, true,$enabled);?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCombobox("Hor�rio de t�rmino", "hourend", "hourend", "width:300px;", makeHours(), "verifyHours()", $hourend, true,$enabled);?>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;" colspan="2">
					<fieldset style=" border-color: #333333">
						<legend>Configura��es de dias da semana</legend>
						<table cellpadding="0" cellspacing="0" style="width:100%; padding-bottom:10px;">
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Domingo", 1, "fgsunday", "fgsunday",false, ($fgsunday == 1)?true:false,$enabled);?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Segunda-Feira", 1, "fgmonday", "fgmonday",false, ($fgmonday == 1)?true:false,$enabled);?>
								</td>
							</tr>
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Ter�a-Feira", 1, "fgtuesday", "fgtuesday",false, ($fgtuesday == 1)?true:false,$enabled);?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Quarta-Feira", 1, "fgwednesday", "fgwednesday",false, ($fgwednesday == 1)?true:false,$enabled);?>
								</td>
							</tr>
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Quinta-Feira", 1, "fgthursday", "fgthursday",false, ($fgthursday == 1)?true:false,$enabled);?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("Sexta-Feira", 1, "fgfriday", "fgfriday",false, ($fgfriday == 1)?true:false,$enabled);?>
								</td>
							</tr>
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCheckbox("S�bado", 1, "fgsaturday", "fgsaturday",false, ($fgsaturday == 1)?true:false,$enabled);?>
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
	<?verifyFormatImg("flphoto_room","null", "null");?>
	<?include_once("../../js/rpc.js");?>
	
	function verifyHours(){
		if(parseInt(document.getElementById('hourend').value) <= parseInt(document.getElementById('hourst').value))
		{
			alert("Hor�rio de in�cio deve ser menor que Hor�rio de t�rmino");
			document.getElementById('hourst').selectedIndex = '';
			document.getElementById('hourend').selectedIndex = '';
		}
	}
	
	function verifyValue(){
		if(isNaN(document.getElementById('vlhour').value)){
			alert('valor inv�lido');
			document.getElementById('vlhour').value = '';
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