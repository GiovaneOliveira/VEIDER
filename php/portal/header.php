<?
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/class.utils.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$conn = new dba_connect();
	$utils = new utils();
?>
</head>
<body style="margin:0; background-color:#333333">
<?
	if(isset($_REQUEST['cdcompany']) && $_REQUEST['cdcompany'] != "") {
		$ex = $conn->query("SELECT FLLOGO FROM VRCOMPANY WHERE CDCOMPANY = ".$_REQUEST['cdcompany']);
	}
?>
	<table cellpadding="0" cellspacing="0" style="width:80%; height:100%;">
			<tr>
				<td>
					<? $utils->inputDivImg("logo_portal", "logo_portal", 500, 100, "position:absolute; right:150px; top: 10px;", empty($ex[0]['fllogo'])? "logo_portal.png" :$ex[0]['fllogo']);?>
				</td>
			</tr>
	</table>
</body>
</html>