<?
	require_once("../class/class.utils.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?
	$utils = new utils();
?>
</head>
<body style="overflow:hidden; background-color:#333333;">
	<?	$utils->beginDivBorder();?>
		<table cellpadding="0" cellspacing="0" style="width:100%;">
			<tr>
				<td style="padding-top:10px;">
					<? $utils->inputText("Nome da empresa", "nmcompany", "nmcompany", 30, "width:100%"); ?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;">
					<? $utils->inputText("Estado", "nmstate", "nmstate", 50,"width:100%");?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;">
					<? $utils->inputText("Cidade", "nmcity", "nmcity", 50,"width:100%");?>
				</td>
			</tr>
			<tr>
				<td style="padding-top:10px;">
					<? $utils->inputText("Endereço", "dsadress", "dsadress", 50,"width:100%");?>
				</td>
			</tr>
			<tr>
				<td align="center" style="width:50%; bottom:30px; left:10px; position:absolute;">
					<? $utils->inputButton("Pesquisar", "btn_search", "btn_search", 80, "search()");?>
				</td>
				<td align="center" style="width:50%; bottom:30px; right:10px; position:absolute;">
					<? $utils->inputButton("Limpar", "btn_clear", "btn_clear", 80, "clearAll()");?>
				</td>
			</tr>
		</table>
		
	<? $utils->endDivBorder(); ?>

<script type="text/javascript">
	<?$utils->writeJS();?>
	
	function search() {
		var nmcompany = document.getElementById("nmcompany").value;
		var nmstate = document.getElementById("nmstate").value;
		var nmcity = document.getElementById("nmcity").value;
		var dsadress = document.getElementById('dsadress').value;
		
		var params = "&nmcompany="+nmcompany+"&nmstate="+nmstate+"&nmcity="+nmcity+"&dsadress="+dsadress;
		
		parent.document.getElementById('middle').src = "list.php?"+params;
	}
	
	function clearAll() {
		document.getElementById('nmcompany').value = "";
		document.getElementById("nmstate").value = "";
		document.getElementById("nmcity").value = "";
		document.getElementById('dsadress').value = "";
	}
	
	divBorderHeight(26);
</script>
</body>
</html>