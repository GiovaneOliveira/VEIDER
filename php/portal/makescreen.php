<?
	require_once("../../class/class.make_screen.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head><title>VEIDER RESERVAS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$make = new make_screen();
?>
</head>
<body id="body" style="margin:0; overflow:hidden;">
<?
	if(isset($_SESSION['startLogin']) && $_SESSION['startLogin'] == 2)
	{
		$make->split_screen(
			"header.php?",
			"../user/login_area.php?",
			"company_menu.php?",
			"company_list.php?",
			"../notice/notice_list.php?",
			"footer.php?"
		);
	}
	else{
		$make->split_screen(
			"header.php?",
			"../user/login_area.php?",
			"company_filter.php?",
			"company_list.php?",
			"../notice/notice_list.php?",
			"footer.php?"
		);
	}
?>
</body>
</html>