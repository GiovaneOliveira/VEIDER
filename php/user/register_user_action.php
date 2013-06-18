<? 
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
	
	$conn = new dba_connect();
	$next = $conn->getNextCode("VRUSER","CDUSER");
	
	$imagem = 'null';
	
	if(!empty($_FILES["flphoto"]['tmp_name']))
		$imagem = "'".uploadImg($_FILES["flphoto"], 100, 100)."'";
	
	$to      = $_REQUEST['idmail'];
	$subject = 'Chave de ativação';
	$message = 'Chave de ativação: '.md5($_REQUEST['idmail']);
	$headers = 'From: veider.reservas@gmail.com' . "\r\n" .
	'Reply-To: veider.reservas@gmail.com' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();
	
	if(mail($to, $subject, $message, $headers)){	
		if($_REQUEST['action'] == 1)
		{
			$sql = "INSERT INTO VRUSER VALUES (".$next.",
																'USER".$next."',
																'".$_REQUEST['nmuser']."',
																'".$_REQUEST['idlogin']."',
																'".$_REQUEST['idpassword']."',
																'".$_REQUEST['idmail']."',
																'".$_REQUEST['dsadress']."',
																'".$_REQUEST['nrphone']."',
																1,
																1,
																".$imagem.",
																".$_REQUEST['nmstate'].",
																".$_REQUEST['nmcity'].",
																'".md5($_REQUEST['idmail'])."'
															)";
			
			
		}
		else if($_REQUEST['action'] == 2)
		{
			$sql = "UPDATE VRUSER SET NMUSER = '".$_REQUEST['nmuser']."',
												 IDLOGIN = '".$_REQUEST['idlogin']."',
												 IDPASSWORD = '".$_REQUEST['idpassword']."',
												 IDMAIL = '".$_REQUEST['idmail']."',
												 DSADRESS = '".$_REQUEST['dsadress']."',
												 NRPHONE = '".$_REQUEST['nrphone']."',
												 ".(!empty($_FILES["flphoto"]['tmp_name'])?"FLPHOTO = ".$imagem.",":"")."
												 CDSTATE = ".$_REQUEST['nmstate'].",
												 CDCITY = ".$_REQUEST['nmcity']."
												 WHERE CDUSER = '".$_SESSION['CDUSER']."'
					";
		}
		
		$conn->insert($sql);
		
		echo "<script>".($_REQUEST['action'] == 2?"alert('É necessario efetuar login novamente');":"alert('Cadastro salvo com sucesso, acesse seu e-mail e ative sua conta');")."window.close()</script>";
	}
	else
	{
		echo "<script>alert('Falha referente ao e-mail');window.close();</script>";
	}
	
?>
