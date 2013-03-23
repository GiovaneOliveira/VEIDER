<?
    require_once("../class/class.menu.inc");
    require_once("../class/class.utils.inc");
?>
<!DOCTYPE HTML>
<html>
<head>
<?
	$menu = new menu();
	$utils = new utils();
?>
<style type="text/css">
	.menu_head {
		padding: 5px 10px;
		cursor: pointer;
		position: relative;
		margin: 1px;
		font-weight: bold;
		font-family: Gill, Helvetica, sans-serif; 
		background-color: #333333;
		color: #F5F5F5;
	}
	.menu_body {
		display:none;
	}
	.menu_body a {
		display:block;
		color:#333333;
		background-color:#F5F5F5;
		padding-left:10px;
		font-weight:bold;
		font-family: Gill, Helvetica, sans-serif; 
		text-decoration:none;
		border-bottom: 1px solid #333333;
		height: 25px;
	}
	.menu_body a:hover {
		color: #333333;
		background-color: #DDDDDD;
	}
</style>
</head>
<body style="overflow:hidden; background-color:#333333;">
<?
	$utils->beginDivBorder(false);
	
    $menu->add("Titulo 1", null, true);
    $menu->add("Menu 1", "", false);
    $menu->add("Menu 2", "", false);
    
    $menu->add("Titulo 2", null, true);
    $menu->add("Menu 3", "", false);
    $menu->add("Menu 4", "", false);
    
    $menu->add("Titulo 3", null, true);
    $menu->add("Menu 5", "", false);
    $menu->add("Menu 6", "", false);
    
    $menu->output("100%");
	
	$utils->endDivBorder();
?>
</body>
</html>