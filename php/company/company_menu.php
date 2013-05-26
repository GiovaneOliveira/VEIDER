<?
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.menu.inc");
	session_start();
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
	$company = false;
	$veider = false;
	if($_SESSION['FGTYPE'] == 2 && $_SESSION['CDCOMPANY'] == $_REQUEST['cdcompany'])
		$company = true;
	else if($_SESSION['FGTYPE'] == 3)
		$veider = true;
	
	$utils->beginDivBorder();
	
	if($veider) {
		$menu->add("Empresas", null, true);
		$menu->add("Solicita��es pendentes", "", false);
	}
	else {
		$menu->add("Reservas", null, true);
		$menu->add("Calend�rio", "../company/company_calendar.php?cdcompany=".$_REQUEST['cdcompany'], false);
		$menu->add("Consulta", "", false);
		$menu->add("Cancelamento", "", false);
		
		if($company) {
			$menu->add("Informativo", null, true);
			$menu->add("Relat�rio de agendamento", "", false);
			$menu->add("Relat�rio de assiduidade", "", false);
		}
		
		$menu->add("Op��es", null, true);
		$menu->add("Dados da empresa", "", false);
		$menu->add("Espa�os", "", false);
		$menu->add("Sugest�es", "", false);
	}
	
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
		// Not�cias
		parent.refreshSrc("right", "../notice/notice_list.php?");
		// Central
		parent.refreshSrc("middle", "../portal/company_list.php");
		// Cabe�alho
		parent.refreshSrc("top", "../portal/header.php?");
	}
	
	divBorderHeight(26);
</script>
</body>
</html>