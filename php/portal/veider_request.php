<?
	require_once("../global.php");
	require_once("../../class/class.dba_connect.inc");
	session_start();
	
	$conn = new dba_connect();
	
	switch($_REQUEST['type'])
	{
		case -1: //Nova sessão
			 session_destroy();
			 createSession();
		break;
		case 0: //Vevificar campos para Login
			$sql = "SELECT CDUSER, IDLOGIN, IDMAIL, IDPASSWORD, FGTYPE, FLPHOTO, FGBLOCK FROM VRUSER 
			WHERE FGBLOCK <> 1 AND ".$conn->protectStr("IDLOGIN", $_REQUEST['idlogin'], false)." AND ".$conn->protectStr("IDPASSWORD", $_REQUEST['idpassword'], false);
			
			$ex = $conn->query($sql);
			
			if(isset($ex[0]))
			{
				$_SESSION['user_code'] = $ex[0]['cduser'];
				$_SESSION['user_login'] = $ex[0]['idlogin'];
				$_SESSION['user_mail'] = $ex[0]['idmail'];
				$_SESSION['user_password'] = $ex[0]['idpassword'];
				$_SESSION['user_photo'] = $ex[0]['flphoto'];
				$_SESSION['startLogin'] = $ex[0]['fgtype'];
				
				if($ex[0]['fgtype'] == 2)
				{
					$excompany = $conn->query("SELECT CDCOMPANY, NMCOMPANY, FLLOGO FROM VRCOMPANY WHERE CDADMIN =".$ex[0]['cduser']);
					
					$_SESSION['cd_company'] = $excompany[0]['cdcompany'];
					$_SESSION['nm_company'] = $excompany[0]['nmcompany'];
					$_SESSION['company_logo'] = $excompany[0]['fllogo'];
				}
				echo "1";
			}
			else
				echo "0";
		break;
		case 1: //Verificar se IDLOGIN já está registrado
			$sql = "SELECT IDLOGIN FROM VRUSER WHERE ".$conn->protectStr("IDLOGIN", $_REQUEST['idlogin'], false).($_REQUEST['action'] == 2 ? " AND IDLOGIN <> '".$_SESSION['user_login']."'" : "");
			
			$ex = $conn->query($sql);
			
			if(isset($ex[0]))
				echo "1";
			else
				echo "0";
		break;
		case 2: //Verificar se IDMAIL já está registrado
			$sql = "SELECT IDMAIL FROM VRUSER WHERE ".$conn->protectStr("IDMAIL", $_REQUEST['idmail'], false).($_REQUEST['action'] == 2 ? " AND IDMAIL <> '".$_SESSION['user_mail']."'" : "");
			
			$ex = $conn->query($sql);
			
			if(isset($ex[0]))
				echo "1";
			else
				echo "0";
		break;
		case 3: //Verificar se IDMAIL já está registrado
			$sql = "SELECT CDUSER FROM VRUSER WHERE ACTCODE = '".$_REQUEST['actice_code']."'";
			
			$ex = $conn->query($sql);
			
			if(isset($ex[0]))
			{
				$sql = "UPDATE VRUSER SET FGBLOCK = 0,
													   ACTCODE = null
							WHERE CDUSER = '".$ex[0]['cduser']."'
					";
		
				$conn->insert($sql);
				
				echo "1";
			}
			else
				echo "0";
		break;
		case 4: //Verificar NMCOMPANY já está registrado
			$sql = "SELECT NMCOMPANY FROM VRCOMPANY WHERE ".$conn->protectStr("NMCOMPANY", $_REQUEST['nmcompany'], false).($_REQUEST['action'] == 2 ? " AND NMCOMPANY <> '".$_SESSION['nm_company']."'" : "");
			
			$ex = $conn->query($sql);
			
			if(isset($ex[0]))
				echo "1";
			else
				echo "0";
		break;
		case 5://Verificar FGBLOCK de usuario
			$sql = "SELECT FGBLOCK FROM VRUSER WHERE CDUSER =".$_SESSION['user_code'];
			
			$ex = $conn->query($sql);
			
			if($ex[0]['fgblock'] == 2)
				echo "1";
			else
				echo "0";
		break;
	}
?>