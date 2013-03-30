<?
	require_once("../class/class.utils.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$utils = new utils();
	//error_log(print_r($_SESSION, true));
?>
</head>
<body style="overflow:hidden; background-color:#333333">
	<?	$utils->beginDivBorder();?>
	<?if($_SESSION['startLogin'] == 0){?>
		<table cellpadding="0" cellspacing="0" style="width:100%; height:100%;">
			<tr>
				<td>
					<? $utils->inputText("Usuário", "idlogin", "idlogin", 15);?>
				</td>
				<td>
					<? $utils->inputText("Senha", "idpassword", "idpassword", 50, "", "", false, true);?>
				</td>
			</tr>
			<tr>
				<td>
					<? $utils->inputButton("Entrar", "btn_login", "btn_login", 145, "Login();");?>
				</td>
				<td>
					<? $utils->inputButton("Registrar-se", "btn_register", "btn_register", 145, "userRegister(1)");?>
				</td>
			</tr>
		</table>
	<?} else if($_SESSION['startLogin'] == 1){?>
		<table cellpadding="0" cellspacing="0" style="width:80%; height:100%;">
			<tr style="width:100%; height:50%;">
				<td style="width:60%;">
					<?$utils->createFont("USUÁRIO: ".$_SESSION['user_login']);?>
				</td>
				<td style="width:40%;">
					<? $utils->inputButton("Editar Perfil", "btn_edit", "btn_edit", 100, "userRegister(2)");?>
				</td>
			</tr>
			<tr style="width:100%; height:50%;">
				<td style="width:60%;">
					<? $utils->inputButton("Tornar-se administrador", "btn_admin", "btn_admin", 225, "opa()");?>
				</td>
				<td style="width:40%;">
					<? $utils->inputButton("Desconectar", "btn_logout", "btn_logout", 100, "Logout()");?>
				</td>
			</tr>
				<? $utils->inputDivImg("img_login", "img_login", "position:absolute; right:40px; bottom:8px; border-color:black; border-width:1px; border-style:solid",$_SESSION['user_photo']);?>
			</tr>
		</table>
	<?} else if($_SESSION['startLogin'] == 2){?>
		<b>ADMINISTRADOR: <?=$_SESSION['user_login']?></b>
	<?}?>
	<? $utils->endDivBorder(); ?>
<script>
	<?$utils->writeJS();?>
	<?include_once("../js/rpc.js");?>
	
	function userRegister(action) {
		window_open("register_user_data.php?action="+action, 635, 470);
	}
	
	function Logout()
	{
		RPC = new REQUEST("veider_request.php?type=-1", "../php/");
		RPC.Response(null);
		window.location.reload();
	}
	
	function Login()
	{
		RPC = new REQUEST("veider_request.php?type=0&idlogin="+document.getElementById('idlogin').value+"&idpassword="+document.getElementById('idpassword').value, "../php/");
		retorno = RPC.Response(null);
		
		if(retorno == 1)
		{
			window.location.reload();
		}
		else
			alert('Deu merda');
	}
	
	function opa(){
	alert('tem nada aqui não');
	}
	divBorderHeight(25);
</script>
</body>
</html>