<? 
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
	
	$conn = new dba_connect();
	$next = $conn->getNextCode("VRCOMPANY","CDCOMPANY");
	
	$imagem = 'null';
	
	if(!empty($_FILES["flphoto_company"]['tmp_name']))
		$imagem = "'".uploadImg($_FILES["flphoto_company"], 500, 100)."'";
	
	$to      = $_REQUEST['admin_mail'];
	$subject = 'Ativa��o de conta administradora';
	$message = 'DEPOSITO EM CONTA';
	$headers = 'From: veider.reservas@gmail.com' . "\r\n" .
	'Reply-To: veider.reservas@gmail.com' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();
	
	if(mail($to, $subject, $message, $headers)){	
		if($_REQUEST['action'] == 1)
		{
			$sql = "INSERT INTO VRCOMPANY VALUES (".$next.",
																".$_SESSION['user_code'].",
																'COMPANY".$next."',
																'".$_REQUEST['nmcompany']."',
																'".$_REQUEST['dsadress_company']."',
																'".$_REQUEST['nmstate_company']."',
																".$_REQUEST['nmcity_company'].",
																".$_REQUEST['nrphone_company'].",
																".$imagem."
															) ";
			
			$sql .= "UPDATE VRUSER SET FGBLOCK = 2 WHERE CDUSER = '".$_SESSION['user_code']."'";
		}
		else if($_REQUEST['action'] == 2)
		{
			$sql = "UPDATE VRCOMPANY SET NMCOMPANY = '".$_REQUEST['nmcompany']."',
												 DSADRESS = '".$_REQUEST['dsadress_company']."',
												 NRPHONE = '".$_REQUEST['nrphone_company']."',
												 ".(!empty($_FILES["flphoto_company"]['tmp_name'])?"FLLOGO = ".$imagem.",":"")."
												 NMSTATE = ".$_REQUEST['nmstate_company'].",
												 NMCITY = ".$_REQUEST['nmcity_company']."
												 WHERE CDADMIN = '".$_SESSION['user_code']."'
					";
		}
		
		$conn->insert($sql);
		
		echo "<script>".($_REQUEST['action'] == 2?"alert('� necessario efetuar login novamente');":"alert('Solici��o efetuada com sucesso, acesse seu e-mail para mais informa��es');")."window.close()</script>";
	}
	else
	{
		echo "<script>alert('Falha referente ao e-mail');window.close();</script>";
	}
	
?>
