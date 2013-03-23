<?
	require_once("../class/class.utils.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?
	$utils = new utils();
	error_log(print_r($_SESSION, true));
?>
</head>
<body style="overflow:hidden; background-color:#333333">
	<?	$utils->beginDivBorder();?>
	<?if($_SESSION['startLogin'] == 0){?>
		<table cellpadding="0" cellspacing="0" style="width:100%; height:100%;">
			<tr>
				<td>
					<? $utils->inputText("Usuário", "idlogin", "idlogin");?>
				</td>
				<td>
					<? $utils->inputText("Senha", "idpassword", "idpassword", false, true);?>
				</td>
			</tr>
			<tr>
				<td>
					<? $utils->inputButton("Entrar", "btn_login", "btn_login", 145, "Login();");?>
				</td>
				<td>
					<? $utils->inputButton("Registrar-se", "btn_register", "btn_register", 145, "userRegister()");?>
				</td>
			</tr>
		</table>
	<?} else if($_SESSION['startLogin'] == 1){?>
		<table cellpadding="0" cellspacing="0" style="width:80%; height:100%;">
			<tr>
				<td>
					<?$utils->createFont("USUÁRIO: ".$_SESSION['user_login']);?>
				</td>
			</tr>
			<tr>
				<td>
					<? $utils->inputButton("Deseja tornar-se administrador?", "btn_admin", "btn_admin", 245, "alert('tem nada aqui não');");?>
				</td>
				<td>
					<? $utils->inputButton("Desconectar", "btn_logout", "btn_logout", 145, "Loginout();");?>
				</td>
			</tr>
				<div id="div_photo" style="position:absolute; right:25px; bottom:8px; width:100px; height:100px; border-color:black; border-width:1px; border-style:solid">
						<img id="img_user" name="img_user" width="100px" height="100px" src="../temp/<?=$_SESSION['user_photo']?>" />
				</div>
			</tr>
		</table>
	<?} else if($_SESSION['startLogin'] == 2){?>
		<b>ADMINISADOR: <?=$_SESSION['user_login']?></b>
	<?}?>
	<? $utils->endDivBorder(); ?>
<script>
	<?$utils->writeJS();?>
	<?include_once("../js/rpc.js");?>
	
	function userRegister() {
		window_open("register_user_data.php", 635, 470);
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
	
	divBorderHeight(25);
</script>
</body>
</html>