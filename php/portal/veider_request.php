<?
	require_once("../global.php");
	require_once("../../class/class.dba_connect.inc");
	session_start();
	
	$conn = new dba_connect();
	
	switch($_REQUEST['type'])
	{
		case -1: //Nova sess�o
			 session_destroy();
			 createSession();
		break;
		case 0: //Vevificar campos para Login
			$sql = "SELECT CDUSER, IDLOGIN, IDMAIL, IDPASSWORD, FGTYPE, FLPHOTO, FGBLOCK FROM VRUSER 
			WHERE ".$conn->protectStr("IDLOGIN", $_REQUEST['idlogin'], false)." AND ".$conn->protectStr("IDPASSWORD", $_REQUEST['idpassword'], false);
			
			$ex = $conn->query($sql);
			
			if(isset($ex[0]) && $ex[0]['fgblock'] != 1)
			{
				$_SESSION['user_code'] = $ex[0]['cduser'];
				$_SESSION['startLogin'] = $ex[0]['fgtype'];
				
				if($ex[0]['fgtype'] == 2)
				{
					$excompany = $conn->query("SELECT CDCOMPANY, NMCOMPANY, FLLOGO FROM VRCOMPANY WHERE CDADMIN =".$ex[0]['cduser']);
					
					$_SESSION['cd_company'] = $excompany[0]['cdcompany'];
				}
				echo "1";
			}
			else if(isset($ex[0]) && $ex[0]['fgblock'] == 1)
			{
				echo "2";
			}
			else
				echo "0";
		break;
		case 1: //Verificar se IDLOGIN j� est� registrado
			$sql = "SELECT IDLOGIN FROM VRUSER WHERE ".$conn->protectStr("IDLOGIN", $_REQUEST['idlogin'], false).($_REQUEST['action'] == 2 ? " AND IDLOGIN <> (SELECT IDLOGIN FROM VRUSER WHERE CDUSER = '".$_SESSION['user_code']."')": "");
			
			$ex = $conn->query($sql);
			
			if(isset($ex[0]))
				echo "1";
			else
				echo "0";
		break;
		case 2: //Verificar se IDMAIL j� est� registrado
			$sql = "SELECT IDMAIL FROM VRUSER WHERE ".$conn->protectStr("IDMAIL", $_REQUEST['idmail'], false).($_REQUEST['action'] == 2 ? " AND IDMAIL <> (SELECT IDMAIL FROM VRUSER WHERE CDUSER = '".$_SESSION['user_code']."')" : "");
			
			$ex = $conn->query($sql);
			
			if(isset($ex[0]))
				echo "1";
			else
				echo "0";
		break;
		case 3: //Verificar se IDMAIL j� est� registrado
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
		case 4: //Verificar NMCOMPANY j� est� registrado
			$sql = "SELECT NMCOMPANY FROM VRCOMPANY WHERE ".$conn->protectStr("NMCOMPANY", $_REQUEST['nmcompany'], false).($_REQUEST['action'] == 2 ? " AND NMCOMPANY <> (SELECT NMCOMPANY FROM VRCOMPANY WHERE CDADMIN = '".$_SESSION['user_code']."')" : "");
			
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