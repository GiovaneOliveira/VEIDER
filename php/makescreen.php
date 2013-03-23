<?
	require_once("../class/class.make_screen.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head><title>VEIDER RESERVAS</title>
<?
	$make = new make_screen();
?>
</head>
<body id="body" style="margin:0; overflow:hidden;">
<?
	$make->split_screen(
		"header.php?",
		"login_area.php?",
		"filter.php?",
		"list.php?",
		"notices.php?",
		"footer.php?"
	);
?>
</body>
</html>