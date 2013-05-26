<?
    require_once("../../class/class.calendar.inc");
    require_once("../../class/class.dba_connect.inc");
?>
<html>
<head>
<style type="text/css">
    td {
        border:1px solid lightgray;
    }
    th {
        border:1px solid gray;
        height:30px;
    }
</style>
<?
    $variation = (isset($_REQUEST['variation'])? $_REQUEST['variation'] : 0);
	$calendar = new calendar($variation);
    $conn = new dba_connect();
?>
</head>
<body style="background-color:#FFFFFF; overflow:hidden; margin:4; padding:0;" ><!-- alterar bgcolor para 333333 -->
<?
    $sql = "SELECT RO.NMROOM, COMP.NMCOMPANY, RO.FGSUNDAY, RO.FGMONDAY, RO.FGTUESDAY, 
                            RO.FGWEDNESDAY, RO.FGTHURSDAY, RO.FGFRIDAY, RO.FGSATURDAY
                FROM VRROOM RO, VRCOMPANY COMP
                WHERE RO.CDCOMPANY = COMP.CDCOMPANY
                AND CDROOM = 1";
    $ex = $conn->query($sql);
    
    $workdays = array(
        0 => $ex[0]['fgsunday'],
        1 => $ex[0]['fgmonday'],
        2 => $ex[0]['fgtuesday'],
        3 => $ex[0]['fgwednesday'],
        4 => $ex[0]['fgthursday'],
        5 => $ex[0]['fgfriday'],
        6 => $ex[0]['fgsaturday']
    );
    
    $calendar->setCompany($ex[0]['nmcompany']." - ".$ex[0]['nmroom']);
	$calendar->setWorkDays($workdays);
    $calendar->printCalendar();
?>
<script type="text/javascript">
	var variation = <?echo $variation;?>;
	function changeMonth(type)
	{
		if(type == "previous") {
			variation --;
		} else if(type == "next") {
			variation ++;
		}
		location.replace("company_calendar.php?variation="+variation);
	}
</script>
</body>
</html>