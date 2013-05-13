<?
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.menu.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$utils = new utils();
	$menu = new menu();
?>
</head>
<body style="overflow:hidden; background-color:#333333;">
<?
	$utils->beginDivBorder();
	
	$menu->add("Reservas", null, true);
	$menu->add("Calendário", "../company/company_calendar.php?cdcompany=".$_REQUEST['cdcompany'], false);
	$menu->add("Consulta", null, false);
	$menu->add("Cancelamento", null, false);
	$menu->add("Opções", null, true);
	$menu->add("Visualizar dados da empresa", null, false);
	$menu->add("Visualizar espaços", null, false);
	$menu->add("Cadastro de sugestões", null, false);
	
	$menu->output("100%");
?>
	<div align="center" style="width:100%; bottom:20px; left:0px; position:absolute;">
		<? $utils->inputButton("Retornar a tela de pesquisa", "btn_back", "btn_back", 310, "backReload()");?>
	</div>
<?
	$utils->endDivBorder();
?>
<script type="text/javascript">
	function reloadFrames(src) {
		parent.refreshSrc("middle", src);
	}
	
	function backReload(){
		// Filtro
		parent.refreshSrc("left", "../portal/company_filter.php?");
		// Notícias
		parent.refreshSrc("right", "../notice/notice_list.php?");
		// Central
		parent.refreshSrc("middle", "../portal/company_list.php");
		// Cabeçalho
		parent.refreshSrc("top", "../portal/header.php?");
	}
	
	divBorderHeight(26);
</script>
</body>
</html>