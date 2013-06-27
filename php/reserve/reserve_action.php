<?
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
	
	$conn = new dba_connect();
	
	$table = array("table" => "VRRESERVE", 
						"primarykey" => "CDRESERVE");
						
	$fields = array("CDROOM" => $_REQUEST['cdroom'],
						"CDUSER" => $_REQUEST['cduser'],
						"VLRESERVE" => $_REQUEST['vltotal'],
						"FGSITUATION" => 1,
						"DTREQUEST" => $conn->formatString('10-10-2013'),
						"DTREGISTER" => $conn->formatString('10-10-2013'),
						"QTDURATION" => $_REQUEST['hourend'] - $_REQUEST['hourst'],
						"FGTYPEEND" => 0,
						"FGREASON" => 0,
						"DSJUSTIFY" => "NULL",
						"DSNOTE" => "NULL"
				);
	
			$conn->transaction("insert", $table,$fields);
	
	if($_REQUEST['code_itens'] != "0"){
		$itens = explode(",",$_REQUEST['code_itens']);
		$exReserve = $conn->query("SELECT MAX(CDRESERVE) AS CDRESERVE FROM VRRESERVE");
		foreach ($itens as $key => $value)
		{
			if($key != 0){
				$table = array("table" => "VROBASSOCRESERVE", 
									"primarykey" => "CDASSOCRESERVE");
									
				$fields = array("CDOBJECT" => $value,
									"CDRESERVE" => $exReserve[0]['cdreserve']
							);
				
					$conn->transaction("insert", $table,$fields);
			}
		}
	}
	$conn->close();
	echo "<script>window.opener.location.reload();window.close()</script>";
?>