<?
	require_once("../../class/class.report.inc");
	require_once("../../class/class.dba_connect.inc");
	require_once("../../class/veider_functions.inc");
	
	$report = new report();
	$conn = new dba_connect();
	
	// RELATORIO AGENDAMENTO
	$sql = "SELECT CASE RES.FGSITUATION
							WHEN 1
								THEN 'Aberta'
							WHEN 2
								THEN 'Cancelada'
							ELSE
								'Encerrada'
						END AS FGSITUATIONNAME,
			US.NMUSER, RO.NMROOM, RES.VLRESERVE, RES.DTREQUEST, RES.DTREGISTER
			FROM VRRESERVE RES, VRUSER US, VRROOM RO
			WHERE US.CDUSER = RES.CDUSER
			AND RO.CDROOM = RES.CDROOM
			AND RO.CDCOMPANY = ".$_REQUEST['cdcompany'];
	$fields = $conn->query($sql);
	
	$html = "
		<table cellpadding='0' cellspacing='0'>
			<thead>
				<tr>
					<th>SITUAÇÃO</th>
					<th>USUÁRIO</th>
					<th>ESPAÇO</th>
					<th style='text-align:right'>VALOR (R$)</th>
					<th style='text-align:right'>DATA RESERVADA</th>
					<th style='text-align:right'>REGISTRADO EM</th>
				</tr>
			</thead>
			<tbody>";
			foreach($fields as $rows) {
				$html .= "<tr>";
				foreach($rows as $key => $cols) {
					$style = "";
					if($key == "dtrequest" || $key == "dtregister") {
						$cols = formatDate($cols);
						$style = "style='text-align:right'";
					}
					if($key == "vlreserve")
						$style = "style='text-align:right'";
					$html .= "
						<td  class='row' $style>".$cols."</td>
					";
				}
				$html .= "</tr>";
			}
			$html .= "
			</tbody>
		</table>
	";
	
	$report->setHTML(utf8_encode($html));
	$report->output();
	
	$conn->close();
?>