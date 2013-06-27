<?
	require_once("../../class/class.tableList.inc");
	require_once("../../class/class.dba_connect.inc");
	session_start();
?>
<!DOCTYPE HTML PUBLI "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<?
	$list = new tableList();
	$conn = new dba_connect();
?>
</head>
<body style="background-color: #F5F5F5">
<input type="hidden" id="cdobject" name="cdobject">
<div id="dvObjectGrid" id="dvObjectGrid" class="dvToGrid">
<?
	$sql = "SELECT ITEM.CDOBJECT, ITEM.CDCOMPANY,ITEM.NMOBJECT, ITEM.VLOBJECT , ITEM.FGCONDITION
				FROM VROBJECT ITEM, VRCOMPANY COMP
				WHERE ITEM.CDCOMPANY = COMP.CDCOMPANY
				AND ITEM.CDCOMPANY = ".$_REQUEST['cdcompany']."
				AND ITEM.CDOBJECT ".(isset($_REQUEST['window'])?"NOT":"")." IN (".$_REQUEST['code_itens'].")
				ORDER BY ITEM.NMOBJECT";
				
	$ex = $conn->query($sql);
	
	$list->setQueryFields($ex);
	$list->setFieldNames(array("NMOBJECT", "VLOBJECT",  "FGCONDITION"));
	$list->setTitleNames(array("NOME", "VALOR HORA (R$)", "CONDIÇÃO"));
	$list->setColWidth(array("400px", "100px", "100px"));
	$list->setColAlign(array("left", "right", "center"));
	$list->setImgCols(array("FGCONDITION"=>"objectCondition"));
	if(isset($_REQUEST['window']))	
		$list->setDblClickFunction("reloadFrame()");
	if(!isset($_REQUEST['window']))
		$list->setClickFunction("cditemFrame()");
	$list->setHiddenObject("cdobject");
	$list->setHiddenFields(array("cdobject","vlobject"));
	$list->printList("dvObjectGrid");
?>
</div>
<script type="text/javascript">
	function reloadFrame(){
		cdobject = document.getElementById('cdobject').value.split(";");
		window.opener.document.getElementById('vl_itens').value = parseInt(window.opener.document.getElementById('vl_itens').value) + parseInt(cdobject[1]);
		window.opener.verifyCost();
		window.opener.document.getElementById('code_itens').value += ","+cdobject[0];
		window.opener.verifyBtn();
		window.opener.document.getElementById('iframe_itens').src = "reserve_assoc_list.php?code_itens="+window.opener.document.getElementById('code_itens').value+"&cdcompany=<?=$_REQUEST['cdcompany']?>";
		window.close();
	}
	
	function cditemFrame(){
		parent.document.getElementById('cdobject').value = document.getElementById('cdobject').value;
	}
</script>
</body>
</html>