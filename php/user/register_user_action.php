<? 
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	session_start();
    
    $mailProperties['to'] = $_REQUEST['idmail'];
    $mailProperties['subject'] = "Chave de ativação";
    $mailProperties['message'] = "Chave de ativação: ".md5($_REQUEST['idmail']);
	$mailSent = sendMail($mailProperties);
    
	if($mailSent)
    {
        $conn = new dba_connect();
        
        $flphoto = "NULL";
        if(!empty($_FILES["flphoto"]["tmp_name"]))
            $flphoto = uploadImg($_FILES["flphoto"], 100, 100);
        
        $table = array(
            "table"=>"VRUSER",
            "primarykey"=>"CDUSER"
        );
        
        $fields = array(
            "NMUSER"=>$conn->formatString($_REQUEST['nmuser']),
            "IDLOGIN"=>$conn->formatString($_REQUEST['idlogin']),
            "IDPASSWORD"=>$conn->formatString(encrypt($_REQUEST['idlogin'], $_REQUEST['idpassword'])),
            "IDMAIL"=>$conn->formatString($_REQUEST['idmail']),
            "DSADRESS"=>$conn->formatString($_REQUEST['dsadress']),
            "NRPHONE"=>$_REQUEST['nrphone'],
            "CDSTATE"=>$_REQUEST['cdstate'],
            "CDCITY"=>$_REQUEST['cdcity'],
            "FLPHOTO"=>$conn->formatString($flphoto)
        );
        
        // INSERT
		if($_REQUEST['action'] == 1)
		{
            $fieldsInsert = array(
                "IDUSER"=>$conn->selectID("USER", "CDUSER", "VRUSER"),
                "FGTYPE"=>1,
                "FGBLOCK"=>1,
                "ACTCODE"=>$conn->formatString(md5($_REQUEST['idmail']))
            );
			$fields = array_merge($fields, $fieldsInsert);
            
            $conn->transaction("insert", $table, $fields);
            $conn->close();
		}
        
        // UPDATE
		else if($_REQUEST['action'] == 2)
		{
            $where = array("CDUSER = ".$_REQUEST['cduser']=>" AND ");
            
            $conn->transaction("update", $table, $fields, $where);
            $conn->close();
        }
		
		echo "<script>".($_REQUEST['action'] == 2?"alert('É necessario efetuar login novamente');":"alert('Cadastro salvo com sucesso, acesse seu e-mail e ative sua conta');")."window.close()</script>";
	}
	else
	{
		echo "<script>alert('Falha referente ao e-mail');window.close();</script>";
	}
	
?>