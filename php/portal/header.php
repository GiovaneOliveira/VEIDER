<?
	require_once("../../class/class.utils.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$utils = new utils();
?>
</head>
<body style="margin:0; background-color:#333333">
	<table cellpadding="0" cellspacing="0" style="width:80%; height:100%;">
			</tr>
				<? $utils->inputDivImg("logo_portal", "logo_portal", 500, 100, "position:absolute; right:150px; top: 10px;", isset($_SESSION['company_logo'])?$_SESSION['company_logo']:"logo_portal.png");?>
			</tr>
	</table>
</body>
</html>