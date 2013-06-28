<? 
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Cadastro de item</title>
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
		$nmobject = "";
		$vlobject = "";
		$fgcondition = 1;
	}
	else if($_REQUEST['action'] == 2)
	{
		$exObject = $conn->query("SELECT NMOBJECT, VLOBJECT, FGCONDITION FROM VROBJECT WHERE CDOBJECT = '".$_REQUEST['cdobject']."'");
		
		$nmobject = $exObject[0]['nmobject'];
		$vlobject = $exObject[0]['vlobject'];
		$fgcondition = $exObject[0]['fgcondition'];
	}
	
	if(isset($_REQUEST['view']) && $_REQUEST['view'] == 1)
		$enabled = false;
	else
		$enabled = true;

	$utils->imageButton("Registrar", "btnregister", "btnregister", "save()", "save", $enabled);
	$utils->beginDivBorder(true);
?>
	<form action="item_action.php?action=<?=$_REQUEST['action']?>&cdcompany=<?=$_REQUEST['cdcompany']?>&cdobject=<?= $_REQUEST['action'] == 2? $_REQUEST['cdobject'] : -1?>" method="post" enctype="multipart/form-data" target="_self" id="form" name="form" >
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr> 
				<td style="padding-top: 10px; width: 80%">
					<?$utils->inputText("Nome","nmobject","nmobject",60,"width:245px",$nmobject,true, $enabled)?>
				</td>
				<td style="padding-left: 10px; padding-top: 10px; width: 20%">
					<?$utils->inputText("Valor hora (R$)","vlobject","vlobject", 5, "width:115px",$vlobject,true,$enabled,false, array("onblur"=>"verifyValue()"));?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="width:100%; padding-top:10px;">
					<?$utils->inputCombobox("Estado de conservação", "fgcondition", "fgcondition", "width:385px", array(1 => "Bom", 2 => "Regular", 3 => "Ruim" ), "", $fgcondition, true, $enabled);?>
				</td>
			</tr>
		</table>
	</form>
<? $utils->endDivBorder();?>

<script type="text/javascript">
	<?$utils->writeJS();?>
	<?include_once("../../js/rpc.js");?>
	
	function verifyValue(){
		if(isNaN(document.getElementById('vlobject').value)){
			alert('valor inválido');
			document.getElementById('vlobject').value = '';
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