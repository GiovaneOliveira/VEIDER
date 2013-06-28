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
		$menu->add("Gestão", null, true);
		$menu->add("Usuários", "../portal/user_pendency.php?", false);
		$menu->add("Empresas", "../portal/company_pendency.php?", false);
	}
	else {
		$menu->add("Reservas", null, true);
		$menu->add("Calendário", "../company/company_calendar.php?cdcompany=".$_REQUEST['cdcompany'], false);
		$menu->add("Consulta", "", false);
		if($company) {
			$menu->add("Cancelamento", "../reserve/reserve_cancel.php?cdcompany=".$_REQUEST['cdcompany'], false);
			$menu->add("Sugestões", "../suggestion/suggestion_list.php?cdcompany=".$_REQUEST['cdcompany'], false);
		} else {
			$menu->add("Cancelamento", "../reserve/reserve_cancel.php?cdcompany=".$_REQUEST['cdcompany']."&cduser=".$_SESSION['CDUSER'], false);
			$menu->add("Sugestões", array("data"=>"../suggestion/suggestion_data.php?cdcompany=".$_REQUEST['cdcompany'], "width"=>"550", "height"=>"440"), false);
		}
		
		$name = "Visualizar";
		if($company) {
			$name = "Gestão";
			$menu->add("Informativo", null, true);
			$menu->add("Relatório de agendamento", array("data"=>"../company/company_report.php?type=1","width"=>"1000","height"=>"700"), false);
			$menu->add("Relatório de assiduidade", "", false);
		}
		
		$menu->add($name, null, true);
		$menu->add("Dados da empresa", array("data"=>"../company/register_company_data.php?&action=2&cdcompany=".$_REQUEST['cdcompany'].($company?"":"&view=1"), "width"=>"635", "height"=>"470"), false);
		$menu->add("Espaços", "../room/room_list.php?cdcompany=".$_REQUEST['cdcompany'], false);
		$menu->add("Itens", "../item/item_list.php?cdcompany=".$_REQUEST['cdcompany'], false);
		if($company) {
			$menu->add("Notícia", array("data"=>"../notice/notice_data.php?cdcompany=".$_REQUEST['cdcompany'], "width"=>"550", "height"=>"400"), false);
		}
	}
	
	$menu->output("100%");
	
	if($_SESSION['FGTYPE'] != 3) {		
		echo "<div align='center' style='width:100%; bottom:20px; left:0px; position:absolute;'>";
		$utils->inputButton("Retornar a tela de pesquisa", "btn_back", "btn_back", 310, "backReload()");
		echo "</div>";
	}
	
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