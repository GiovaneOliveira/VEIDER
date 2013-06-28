<?
    require_once("../../class/class.calendar.inc");
    require_once("../../class/class.dba_connect.inc");
	require_once("../../class/class.utils.inc");
?>
<html>
<head>
<?
    $variation = (isset($_REQUEST['variation'])? $_REQUEST['variation'] : 0);
	$calendar = new calendar($variation);
    $conn = new dba_connect();
	$utils = new utils();
?>
</head>
<body style="margin:4px; padding:0px;" >
<?
    $cdroom = null;
	if(isset($_REQUEST['cdroom']) && $_REQUEST['cdroom'] > 0)
		$cdroom = $_REQUEST['cdroom'];
	
	$rooms = $conn->query("SELECT CDROOM, NMROOM FROM VRROOM WHERE CDCOMPANY = ".$_REQUEST['cdcompany']);
	
	if($rooms) {
		$sql = "SELECT RO.NMROOM, COMP.NMCOMPANY, RO.FGSUNDAY, RO.FGMONDAY, RO.FGTUESDAY, 
								RO.FGWEDNESDAY, RO.FGTHURSDAY, RO.FGFRIDAY, RO.FGSATURDAY
					FROM VRROOM RO, VRCOMPANY COMP
					WHERE RO.CDCOMPANY = COMP.CDCOMPANY
					AND CDROOM = ".$rooms[0]['cdroom'];
		$ex = $conn->query($sql);
		$workdays = array(
			0 => ($cdroom? $ex[0]['fgsunday'] : 0),
			1 => ($cdroom? $ex[0]['fgmonday'] : 0),
			2 => ($cdroom? $ex[0]['fgtuesday'] : 0),
			3 => ($cdroom? $ex[0]['fgwednesday'] : 0),
			4 => ($cdroom? $ex[0]['fgthursday'] : 0),
			5 => ($cdroom? $ex[0]['fgfriday'] : 0),
			6 => ($cdroom? $ex[0]['fgsaturday'] : 0)
		);
		
		foreach($rooms as $value) {
			$roomOptions[$value['cdroom']] = $value['nmroom'];
		}
		$combo = $utils->inputCombobox("", "cdroom", "cdroom", "width:200px;", $roomOptions, "changeRoom(this)", $cdroom, false, true, true);
		
	} else {
		$sql = "SELECT NMCOMPANY, 'NMROOM' AS NMROOM FROM VRCOMPANY WHERE CDCOMPANY = ".$_REQUEST['cdcompany'];
		$ex = $conn->query($sql);
		$workdays = array(0, 0, 0, 0, 0, 0, 0);
		$cdroom = 0;
		
		$combo = $utils->inputCombobox("", "cdroom", "cdroom", "width:200px;", array(), "changeRoom(this)", $cdroom, false, true, true);
	}
    
	$res = $conn->query("SELECT DTREQUEST FROM VRRESERVE WHERE CDROOM = ".($cdroom? $cdroom : "-1"));
	
	if($res) {
		foreach($res as $value) {
			$dates[$value['dtrequest']] = $value['dtrequest'];
		}
	} else {
		$dates = array();
	}
	
	$calendar->setCdRoom($cdroom);
    $calendar->setCompany($ex[0]['nmcompany']." - ".$combo);
	$calendar->setReservedDays($dates);
	$calendar->setWorkDays($workdays);
    $calendar->printCalendar();
?>
<script type="text/javascript">
	var variation = <?echo $variation;?>;
	var cdcompany = <?echo $_REQUEST['cdcompany'];?>;
	function changeMonth(type)
	{
		if(type == "previous") {
			variation --;
		} else if(type == "next") {
			variation ++;
		}
		room = document.getElementById("cdroom").value;
		location.replace("company_calendar.php?variation="+variation+"&cdcompany="+cdcompany+"&cdroom="+room);
	}
	
	function changeRoom(obj)
	{
		room = (obj.value != "")? obj.value : 0;
		location.replace("company_calendar.php?variation="+variation+"&cdcompany="+cdcompany+"&cdroom="+room);
	}
	
	// date = data selecionada no calendario
	function newReserve(date)
	{
		window_open("../reserve/reserve_data.php?action=1&dtreserve="+date+"&cdroom=<?echo $cdroom?>", 800, 600);
	}
</script>
</body>
</html>