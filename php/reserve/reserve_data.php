<? 
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Cadastro de reserva</title>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$utils = new utils();
	$conn = new dba_connect();
?>
</head>
<body style="margin:10px;">
<input type="hidden" id="code_itens" name="code_itens" value="0"></input>
<input type="hidden" id="vl_itens" name="vl_itens" value=0></input>
<input type="hidden" id="cdobject" name="cdobject"></input>
<?
	$exRoom = $conn->query("SELECT RM.CDROOM, RM.CDCOMPANY, RM.NMROOM, RM.VLHOUR, RM.DSADRESS, RM.HOURST, RM.HOUREND, CM.CDCITY, CM.CDSTATE FROM VRROOM AS RM, VRCOMPANY AS CM WHERE RM.CDCOMPANY = CM.CDCOMPANY AND CDROOM = '".$_REQUEST['cdroom']."'");
	$exUser = $conn->query("SELECT CDUSER, NMUSER FROM VRUSER WHERE CDUSER = ".$_SESSION['CDUSER']);
	
	if($_REQUEST['action'] == 1)
	{
		$nmuser =  $exUser[0]['nmuser'];
		$nmroom =  $exRoom[0]['nmroom'];
		$vlhour = $exRoom[0]['vlhour'];
		$dsadress =  $exRoom[0]['dsadress'];
		$cdstate = $exRoom[0]['cdstate'];
		$cdcity = $exRoom[0]['cdcity'];
		$hourst = $exRoom[0]['hourst'];
		$hourend = $exRoom[0]['hourend'];
	}
	
	if(isset($_REQUEST['view']) && $_REQUEST['view'] == 1)
		$enabled = false;
	else
		$enabled = true;

	$utils->imageButton("Registrar", "btnregister", "btnregister", "save()", "save", $enabled);
	$utils->imageButton("Associar item", "btnitem", "btnitem", "assoc()", "new", $enabled);
	$utils->imageButton("Deletar item", "btndel", "btndel", "delete_assoc()", "delete", false);
	$utils->beginDivBorder(true);
?>
	<form action="reserve_action.php?action=<?=$_REQUEST['action']?>&cdroom=<?=$_REQUEST['cdroom']?>&cduser=<?=$exUser[0]['cduser'];?>&date=<?=$_REQUEST['dtreserve']?>" method="post" enctype="multipart/form-data" target="_self" id="form" name="form" >
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr> 
				<td colspan="2" style="padding-top: 10px; width: 100%">
					<?$utils->inputText("Nome do usuário","nmuser","nmuser",60,"width:685px",$nmuser,true,false)?>
				</td>
			</tr>
			<tr> 
				<td style="padding-top: 10px; width: 80%">
					<?$utils->inputText("Nome do espaço","nmroom","nmroom",60,"width:550px",$nmroom,true,false)?>
				</td>
				<td style="padding-left: 10px; padding-top: 10px; width: 20%">
					<?$utils->inputText("Valor total (R$)","vltotal","vltotal", 8, "width:115px","0",true,false,false);?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 10px;">
					<?$utils->inputText("Endereço","dsadress","dsadress",50,"width:680px",$dsadress,true,false)?>
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
				<td style="padding-top:10px;" colspan="2">
					<fieldset style=" border-color: #333333">
						<legend>Horário da reserva</legend>
						<table cellpadding="0" cellspacing="0" style="width:100%; padding-bottom:10px;">
							<tr>
								<td style="width:50%; padding-top:10px;">
									<?$utils->inputCombobox("Horário de início", "hourst", "hourst", "width:300px;", makeHours($hourst, $hourend), "verifyCost()", -1, true,$enabled);?>
								</td>
								<td style="padding-left:10px; width:50%; padding-top:10px;">
									<?$utils->inputCombobox("Horário de término", "hourend", "hourend", "width:300px;", makeHours($hourst, $hourend), "verifyCost()", -1, true,$enabled);?>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;" colspan="2">
					<fieldset style="height: 250px; border-color: #333333">
						<legend>Itens da reserva</legend>
						<iframe id="iframe_itens" name="iframe_itens" style="width:100%; height: 230px; overflow: auto;" src="reserve_assoc_list.php?code_itens=0&cdcompany=<?=$exRoom[0]['cdcompany']?>" frameborder="0" ></iframe>
					</fieldset>
				</td>
			</tr>
		</table>
	</form>
<? $utils->endDivBorder();?>

<script type="text/javascript">
	<?$utils->writeJS();?>
	<?include_once("../../js/rpc.js");?>
	
	function save(){
		if(required(document.getElementById("form"))){ // Retorna true se todos os campos requeridos estiverem preenchidos
			document.getElementById("form").action += "&code_itens="+document.getElementById('code_itens').value;
			document.getElementById("form").submit();
		}
	}
	
	function assoc(){
		window_open("reserve_assoc_list.php?code_itens="+document.getElementById('code_itens').value+"&cdcompany=<?=$exRoom[0]['cdcompany']?>&window=1",500,500);
	}
	
	function verifyCost(){
		if(document.getElementById('hourst').value != '' && document.getElementById('hourend').value != ''){
			document.getElementById('vltotal').value = (document.getElementById('hourend').value - document.getElementById('hourst').value)*(<?=$vlhour?>+parseInt(document.getElementById('vl_itens').value));
		}
	}
	
	function verifyBtn(){
		if(document.getElementById('code_itens').value != "0")
			enableButton("btndel");
		else
			disableButton("btndel");
	}
	
	function delete_assoc(){
		cdobject = document.getElementById('cdobject').value.split(";");
		document.getElementById('vl_itens').value = parseInt(document.getElementById('vl_itens').value) - parseInt(cdobject[1]);
		verifyCost();
		newstr = document.getElementById('code_itens').value.replace(","+cdobject[0],"");
		document.getElementById('code_itens').value = newstr;
		verifyBtn();
		document.getElementById('iframe_itens').src = "reserve_assoc_list.php?code_itens="+document.getElementById('code_itens').value+"&cdcompany=<?=$exRoom[0]['cdcompany']?>";
	}
	
	divBorderHeight(30);
</script>
</body>
</html>