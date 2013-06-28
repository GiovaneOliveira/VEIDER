<?
	require_once("../../class/class.dba_connect.inc");
	
	$conn = new dba_connect();
	
	$table = array("table"=>"VRRESERVE");
	$fields = array("FGSITUATION"=>$_REQUEST['type'], "DSJUSTIFY"=>$conn->formatString($_REQUEST['dsjustify']));
	$where = array("CDRESERVE=".$_REQUEST['cdreserve']=>" AND ");
	
	$conn->transaction("update", $table, $fields, $where);
	$conn->transaction("delete", array("table"=>"VROBASSOCRESERVE"), array(), $where);
	
	$conn->close();
	
	echo "<script>opener.parent.refreshSrc('middle','');window.close();</script>";
?>