<? 
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
	
	$mailProperties['to'] = $_REQUEST['idmail'];
	$mailProperties['subject'] = "Ativação de conta de administrador";
	$mailProperties['message'] = "DEPOSITO EM CONTA";
	$mailSent = sendMail($mailProperties);
	
	if($mailSent)
	{
		$conn = new dba_connect();
		
		$fllogo = "NULL";
		if(!empty($_FILES["flphoto_company"]["tmp_name"]))
			$fllogo = uploadImg($_FILES["flphoto_company"], 500, 100);
		
		$table = array(
			"table"=>"VRCOMPANY",
			"primarykey"=>"CDCOMPANY"
		);
		
		$fields = array(
			"NMCOMPANY"=>$conn->formatString($_REQUEST['nmcompany']),
			"DSADRESS"=>$conn->formatString($_REQUEST['dsadress']),
			"CDSTATE"=>$_REQUEST['cdstate'],
			"CDCITY"=>$_REQUEST['cdcity'],
			"NRPHONE"=>$_REQUEST['nrphone'],
			"FLLOGO"=>$conn->formatString($fllogo)
		);
		
		// INSERT
		if($_REQUEST['action'] == 1)
		{
			$fieldsInsert = array(
				"CDADMIN"=>$_REQUEST['cduser'],
				"IDCOMPANY"=>$conn->selectID("COMPANY", "CDCOMPANY", "VRCOMPANY"),
			);
			$fields = array_merge($fields, $fieldsInsert);
			
			$insert = $conn->transaction("insert", $table, $fields);
			
			if($insert) {
				$userTable = array("table"=>"VRUSER");
				$userField = array("FGBLOCK"=>2);
				$userWhere = array("CDUSER = ".$_REQUEST['cduser']=>" AND ");
				
				$conn->transaction("update", $userTable, $userField, $userWhere);
			}
			$conn->close();
		}
		
		// UPDATE
		else if($_REQUEST['action'] == 2)
		{
			$where = array("CDADMIN = ".$_REQUEST['cduser']=>" AND ");
			
			$conn->transaction("update", $table, $fields, $where);
			$conn->close();
		}
		
		echo "<script>".($_REQUEST['action'] == 2?"alert('É necessario efetuar login novamente');":"alert('Solicição efetuada com sucesso, acesse seu e-mail para mais informações');")."window.close()</script>";
	}
	else
	{
		echo "<script>alert('Falha referente ao e-mail');window.close();</script>";
	}
	
?>
