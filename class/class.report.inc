<?
	class report
	{
		var $_CSS;
		var $_HTML;
		var $_MPDF;
		
		function report()
		{
			require_once("../../report/mpdf.php");
			$this->_MPDF = new mPDF();
			$this->_HTML = $this->getHeader();
			$this->setCSS("report");
		}
		
		function setCSS($css)
		{
			$this->_CSS .= file_get_contents("../../css/".$css.".css");
		}
		
		function setHTML($html)
		{
			$this->_HTML .= $html;
		}
		
		function getHeader()
		{
			$header = "
				<table cellpadding='0' cellspacing='0' style='border:none'>
					<tr>
						<td align='right'>
							<font class='header'>VEIDER RESERVAS</font>
						</td>
						<td align='right' style='width:100px;'>
							<img src='../../image/veider/veider_280.png'/>
						</td>
					</tr>
					<tr>
						<td style='text-align:left' colspan='2'>
							<font class='header'>RELATORIO DE AGENDAMENTOS</font>
						</td>
					</tr>
				</table><br/>
			";
			return $header;
		}
		
		function output()
		{
			$this->_MPDF->WriteHTML($this->_CSS, 1);
			$this->_MPDF->WriteHTML($this->_HTML);
			$this->_MPDF->Output();
		}
	}
?>