<?
	require_once("../class/class.utils.inc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?
	$utils = new utils();
?>
</head>
<body style="overflow:hidden; background-color:#333333">
	<?	$utils->beginDivBorder();?>
	<table cellpadding="0" cellspacing="0" style="width:100%; height:100%;">
		<tr>
			<td>
				<? $utils->inputText("Usuário", "idlogin", "idlogin");?>
			</td>
			<td>
				<? $utils->inputText("Senha", "idpassword", "idpassword");?>
			</td>
		</tr>
		<tr>
			<td>
				<? $utils->inputButton("Entrar", "btn_login", "btn_login", 145);?>
			</td>
			<td>
				<? $utils->inputButton("Registrar-se", "btn_register", "btn_register", 145, "userRegister()");?>
			</td>
		</tr>
	</table>
	<? $utils->endDivBorder(); ?>
<script>
	<?$utils->writeJS();?>
	function userRegister() {
		window_open("register_user_data.php", 635, 470);
	}
	
	divBorderHeight(25);
</script>
</body>
</html>