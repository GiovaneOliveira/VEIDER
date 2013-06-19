<?
	require_once("../global.php");
	require_once("../../class/class.dba_connect.inc");
	session_start();
	
	switch($_REQUEST['type'])
	{
		// DESTROI $_SESSION ANTIGA E CRIA UMA NOVA
		case -1:
			session_destroy();
			createSession();
		break;
		
		// VERIFICA CAMPOS PARA LOGIN
		case 0:
			$conn = new dba_connect();
			
			$sql = "SELECT CDUSER, IDLOGIN, IDMAIL, IDPASSWORD, FGTYPE, FLPHOTO, FGBLOCK 
						FROM VRUSER 
						WHERE ".$conn->protectStr("IDLOGIN", $_REQUEST['idlogin'], false)." 
						AND ".$conn->protectStr("IDPASSWORD", encrypt($_REQUEST['idlogin'], $_REQUEST['idpassword']), false);
			
			$ex = $conn->query($sql);
			
			if(isset($ex[0]) && $ex[0]['fgblock'] != 1) {
				$_SESSION['CDUSER'] = $ex[0]['cduser'];
				$_SESSION['FGTYPE'] = $ex[0]['fgtype'];
				
				if($ex[0]['fgtype'] == 2) {
					$excompany = $conn->query("SELECT CDCOMPANY, NMCOMPANY, FLLOGO FROM VRCOMPANY WHERE CDADMIN =".$ex[0]['cduser']);
					
					$_SESSION['CDCOMPANY'] = $excompany[0]['cdcompany'];
				}
				$return = "1";
			}
			else if(isset($ex[0]) && $ex[0]['fgblock'] == 1) {
				$return = "2";
			}
			else {
				$return = "0";
			}
			
			$conn->close();
			echo $return;
		break;
		
		// VERIFICA SE 	$_REQUEST['field'] 		JA EXISTE EM 	$_REQUEST['table']
		case 1:
			$conn = new dba_connect();
			$sql = "SELECT ".$_REQUEST['field']."
						FROM ".$_REQUEST['table']."
						WHERE ".$conn->protectStr($_REQUEST['field'], $_REQUEST['value'], false).
						($_REQUEST['action'] == 2 ? " AND ".$_REQUEST['field']." <> (SELECT ".$_REQUEST['field']." FROM ".$_REQUEST['table']." WHERE ".$_REQUEST['whereField']." = ".$_SESSION['CDUSER'].")": "");
			$ex = $conn->query($sql);
			$conn->close();
			
			echo (isset($ex[0])? "1" : "0");
		break;
		
		// DESBLOQUEIA USUÁRIO APÓS PREENCHER CHAVE DE ATIVAÇÃO
		case 2:
			$conn = new dba_connect();
			$sql = "SELECT CDUSER FROM VRUSER WHERE ACTCODE = '".$_REQUEST['actice_code']."'";
			$ex = $conn->query($sql);
			
			if(isset($ex[0]))
			{
				$table = array("table"=>"VRUSER");
				$fields = array(
					"FGBLOCK"=>0,
					"ACTCODE"=>"NULL"
				);
				$where = array("CDUSER = ".$ex[0]['cduser']=>" AND ");
				$conn->transaction("update", $table, $fields, $where);
				$conn->close();
				
				echo "1";
			} else {
				echo "0";
			}
		break;
		
		// VERIFICAR FGBLOCK DE USUARIO
		case 3:
			$conn = new dba_connect();
			$sql = "SELECT FGBLOCK FROM VRUSER WHERE CDUSER =".$_SESSION['CDUSER'];
			$ex = $conn->query($sql);
			$conn->close();
			
			if($ex[0]['fgblock'] == 2)
				echo "1";
			else
				echo "0";
		break;
	}
?>