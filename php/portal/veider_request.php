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
			$ex = $conn->query("SELECT CDUSER, IDLOGIN, IDPASSWORD, FGTYPE, FLPHOTO FROM VRUSER WHERE IDLOGIN LIKE '".$_REQUEST['idlogin']."' AND IDPASSWORD LIKE '".$_REQUEST['idpassword']."'");
			
			if(isset($ex[0]))
			{
				$_SESSION['user_code'] = $ex[0]['cduser'];
				$_SESSION['user_login'] = $ex[0]['idlogin'];
				$_SESSION['user_password'] = $ex[0]['idpassword'];
				$_SESSION['user_photo'] = $ex[0]['flphoto'];
				$_SESSION['startLogin'] = $ex[0]['fgtype'];
				
				if($ex[0]['fgtype'] == 2)
				{
					$excompany = $conn->query("SELECT CDCOMPANY, NMCOMPANY FROM VRCOMPANY WHERE CDADMIN =".$ex[0]['cduser']);
					
					$_SESSION['cd_company'] = $excompany[0]['cdcompany'];
					$_SESSION['nm_company'] = $excompany[0]['nmcompany'];
				}
				else
				{
					$_SESSION['cd_company'] = '';
					$_SESSION['nm_company'] = '';
				}
				
				echo "1";
			}
			else
				echo "0";
		break;
		case 1: //Verificar se IDLOGIN já está registrado
			$ex = $conn->query("SELECT IDLOGIN FROM VRUSER WHERE IDLOGIN LIKE '".$_REQUEST['idlogin']."'".($_REQUEST['action'] == 2 ? " AND IDLOGIN <> '".$_SESSION['user_login']."'" : ""));
			
			if(isset($ex[0]))
				echo "1";
			else
				echo "0";
		break;
	}
?>