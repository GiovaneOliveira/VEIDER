<?
	require_once("../class/class.dba_connect.inc");
	
	$conn = new dba_connect();
	
	switch($_REQUEST['type'])
	{
		case 1: //Verificar se Login já está registrado
			$ex = $conn->query("SELECT IDLOGIN FROM VRUSER WHERE IDLOGIN LIKE '".$_REQUEST['idlogin']."'");
			
			if(isset($ex[0]))
				echo "1";
			else
				echo "0";
		break;
	}
?>