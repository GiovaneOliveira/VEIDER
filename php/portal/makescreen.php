<?
	require_once("../../class/class.make_screen.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head><title>VEIDER RESERVAS</title>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$make = new make_screen();
?>
</head>
<body id="body" style="margin:0; overflow:hidden;">
<?
	$make->split_screen(
		"../portal/header.php?",
		"../user/login_area.php?",
		"../portal/company_filter.php?",
		"../portal/company_list.php?",
		"../notice/notice_list.php?",
		"../portal/footer.php?"
	);
?>
</body>
</html>