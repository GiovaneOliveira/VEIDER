<?
	require_once("../../class/class.utils.inc");
	require_once("../../class/class.dba_connect.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$utils = new utils();
	$conn = new dba_connect();
?>
</head>
<body style="overflow:hidden; background-color:#333333">
<?
	$utils->beginDivBorder();
	
	if(isset($_SESSION['CDUSER'])) {
		$ex = $conn->query("SELECT IDLOGIN, NMUSER, FLPHOTO FROM VRUSER WHERE CDUSER = ".$_SESSION['CDUSER']);
	}
	
	// NÃO LOGADO
	if($_SESSION['FGTYPE'] == 0)
	{	?>
		<table cellpadding="0" cellspacing="0" style="width:100%; height:100%;">
			<tr>
				<td colspan="2" style="padding-left:40px; width: 66.6%">
					<? $utils->inputText("Usuário", "idlogin", "idlogin", 100, "width: 250");?>
				</td>
				<td style="width: 33.3%">
					<? $utils->inputText("Senha", "idpassword", "idpassword", 50, "", "", false, true, true);?>
				</td>
			</tr>
			<tr>
				<td style="padding-left:40px; width: 33.3%">
					<? $utils->inputButton("Entrar", "btn_login", "btn_login", 100, "Login();");?>
				</td>
				<td style="padding-left:10px; width: 33.3%">
					<? $utils->inputButton("Registrar-se", "btn_register", "btn_register", 100, "userRegister(1)");?>
				</td>
				<td style="width: 33.3%">
					<? $utils->inputButton("Ativar conta", "btn_active", "btn_active", 140, "userActive()");?>
				</td>
			</tr>
		</table>
		<?
	} 
	
	// USUARIO LOGADO
	else if($_SESSION['FGTYPE'] == 1)
	{	?>
		<table cellpadding="0" cellspacing="0" style="width:80%; height:100%;">
			<tr style="width:100%; height:50%;">
				<td style="width:60%;">
					<?$utils->createFont("USUÁRIO: ");
					   $utils->inputText("", "login_name", "login_name", 100, "width: 150", $ex[0]['nmuser'], false, false);
					?>
				</td>
				<td style="width:40%;">
					<? $utils->inputButton("Editar Perfil", "btn_edit", "btn_edit", 100, "userRegister(2)");?>
				</td>
			</tr>
			<tr style="width:100%; height:50%;">
				<td style="width:60%;">
					<? $utils->inputButton("Tornar-se administrador", "btn_admin", "btn_admin", 225, "companyRegister(1)");?>
				</td>
				<td style="width:40%;">
					<? $utils->inputButton("Desconectar", "btn_logout", "btn_logout", 100, "Logout()");?>
				</td>
			</tr>
				<? $utils->inputDivImg("img_login", "img_login", 100, 100, "position:absolute; right:40px; bottom:8px; border-color:black; border-width:1px; border-style:solid",empty($ex[0]['flphoto'])? "img_null.png" :$ex[0]['flphoto']);?>
		</table>
		<?
	}
	
	// ADMINISTRADOR LOGADO
	else if($_SESSION['FGTYPE'] == 2)
	{	?>
		<table cellpadding="0" cellspacing="0" style="width:80%; height:100%;">
			<tr style="width:100%; height:50%;">
				<td style="width:60%;" colspan="2">
					<?$utils->createFont("ADMINISTRADOR: ");
					   $utils->inputText("", "login_name", "login_name", 100, "width: 130", $ex[0]['nmuser'], false, false);
					?>
				</td>
				<td style="width:40%;">
					<? $utils->inputButton("Editar Perfil", "btn_edit_user", "btn_edit_user", 100, "userRegister(2)");?>
				</td>
			</tr>
			<tr style="width:100%; height:50%;">
				<td style="width:33%;">
					<? $utils->inputButton("Editar Empresa", "btn_edit_company", "btn_edit_company", 125, "companyRegister(2)");?>
				</td>
				<td style="width:33%;">
					<? $utils->inputButton("Visitar Empresa", "btn_login_company", "btn_login_company", 125, "loginCompany()");?>
				</td>
				<td style="width:33%;">
					<? $utils->inputButton("Desconectar", "btn_logout", "btn_logout", 100, "Logout()");?>
				</td>
			</tr>
				<? $utils->inputDivImg("img_admin", "img_admin", 100, 100, "position:absolute; right:40px; bottom:8px; border-color:black; border-width:1px; border-style:solid",empty($ex[0]['flphoto'])? "img_null.png" :$ex[0]['flphoto']);?>
		</table>
		<?
	}
	
	// VEIDER LOGADO
	else if($_SESSION['FGTYPE'] == 3)
	{	?>
		<table cellpadding="0" cellspacing="0" style="padding-left:10px; padding-top:13px">
			<tr>
				<td>
					<?
						$utils->createFont("USUÁRIO: ");
						$utils->inputText("", "login_name", "login_name", 100, "width:105px", $ex[0]['nmuser'], false, false);
					?>
				</td>
				<td style="padding-left: 12px;">
					<? $utils->inputButton("Desconectar", "btn_logout", "btn_logout", 175, "Logout()"); ?>
				</td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" style="padding-left:10px; padding-top:15px">
			<tr>
				<td>
					<? $utils->inputButton("Gestão de usuários", "btn_vruser", "btn_vruser", 175, "pendency(1)");?>
				</td>
				<td style="padding-left:20px;">
					<? $utils->inputButton("Gestão de empresas", "btn_vrcompany", "btn_vrcompany", 175, "pendency(2)");?>
				</td>
			</tr>
		</table>
		<? $utils->inputDivImg("img_admin", "img_admin", 100, 100, "position:absolute; right:40px; bottom:8px; border-color:black; border-width:1px; border-style:solid",empty($ex[0]['flphoto'])? "img_null.png" :$ex[0]['flphoto']);
	}
	
	$utils->endDivBorder(); 
?>

<script>
<?
	$utils->writeJS();
	include_once("../../js/rpc.js");
?>
	
	function userRegister(action) {
		cduser = "<?= isset($_SESSION['CDUSER'])?$_SESSION['CDUSER']:''?>";
		window_open("../user/register_user_data.php?action="+action+"&cduser="+cduser, 635, 470);
	}
	
	function companyRegister(action) {
		cdcompany = "<?= isset($_SESSION['CDCOMPANY'])?$_SESSION['CDCOMPANY']:''?>";
		cduser = "<?= isset($_SESSION['CDUSER'])?$_SESSION['CDUSER']:''?>";
		
		RPC = new REQUEST("portal/veider_request.php?type=3");
		retorno = RPC.Response(null);
		
		if(retorno == 0)
			window_open("../company/register_company_data.php?action="+action+"&cdcompany="+cdcompany+"&cduser="+cduser, 635, 470);
		else
			alert('Solicitação já requisitada');
	}
	
	function userActive() {
		window_open("../user/active_data.php", 635, 125);
	}
	
	function Logout()
	{
		RPC = new REQUEST("portal/veider_request.php?type=-1");
		RPC.Response(null);
		parent.window.location.reload();
	}
	
	function loginCompany()
	{
		cdcompany = "<?= isset($_SESSION['CDCOMPANY'])?$_SESSION['CDCOMPANY']:''?>";
		
		// Menu
		parent.refreshSrc("left", "../company/company_menu.php?cdcompany="+cdcompany);
		// Notícias
		parent.refreshSrc("right", "../notice/notice_list.php?cdcompany="+cdcompany);
		// Central
		parent.refreshSrc("middle", "../portal/company_list.php");
		// Cabeçalho
		parent.refreshSrc("top", "../portal/header.php?cdcompany="+cdcompany);
	}
	
	function Login()
	{
		RPC = new REQUEST("portal/veider_request.php?type=0&idlogin="+document.getElementById('idlogin').value+"&idpassword="+document.getElementById('idpassword').value);
		retorno = RPC.Response(null);
		
		if(retorno == 1)
		{
			parent.refreshSrc("login", "../user/login_area.php");
			parent.refreshSrc("middle", "");
		}
		else if(retorno == 2)
		{
			alert('Acesse seu e-mail e ative sua conta');
		}
		else
			alert('Usuário e/ou Senha inválidos');
	}
	
	function pendency(type)
	{
		if(type == 1)
			parent.refreshSrc("middle", "../portal/user_pendency.php?");
		else
			parent.refreshSrc("middle", "../portal/company_pendency.php?");
	}
	<?
		if($_SESSION['FGTYPE'] == 3) {
			echo "parent.refreshSrc('left', '../company/company_menu.php?');";
		}
	?>
	
	divBorderHeight(26);
</script>
</body>
</html>