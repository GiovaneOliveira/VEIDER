<?
	require_once("class.utils.inc");
	
	class calendar
	{
		var $actual_day;
		var $actual_month;
		var $actual_year;
		var $day;
		var $month;
		var $year;
		var $variation;
		
		var $availableMonths;
		var $lastAvailable;
		var $workdays;
        var $company;
		var $cdroom;
		var $reserved;
        
		var $_utils;
		
		function calendar($var)
		{
			echo "<link rel='stylesheet' type='text/css' href='../../css/calendar.css'>";
			
			$this->actual_day = date("d");
			$this->actual_month = date("m");
			$this->actual_year = date("Y");
			
			$this->variation = $var;
			$this->variableDate();
			
			$this->availableMonths = 1;
			$this->setLastAvailable();
			
			$this->_utils = new utils();
		}
		
        function setWorkDays($workdays)
        {
            $this->workdays = $workdays;
        }
        
        function setCompany($company)
        {
            $this->company = $company;
        }
        
		function setCdRoom($cdroom)
		{
			$this->cdroom = $cdroom;
		}
		
		function setReservedDays($dates)
		{
			$this->reserved = $dates;
		}
		
		function variableDate()
		{
			$m = $this->actual_month + ($this->variation);
			$y = $this->actual_year;
			
			if($this->variation == 0) {
				$this->year = $this->actual_year;
				$this->month = $this->actual_month;
				$this->day = $this->actual_day;
			}
			else {
				if($m > 12) {
					$month = abs(12 - $m);
					$y++;
				}
				else if($m < 1) {
					$month = 12 + ($m);
					$y--;
				}
				else {
					$month = $m;
				}
			
				$this->year = $y;
				$this->month = $month < 10? "0".$month : $month;
				$this->day = 01;
			}
			
		}
		
		function setAvailableMonths($qtMonths)
		{
			$this->availableMonths = $qtMonths;
			$this->setLastAvailable();
		}
		
		function setLastAvailable()
		{
			$year = $this->actual_year;
			$month = $this->actual_month;
			$day = $this->actual_day;
			
			if($this->actual_month + $this->availableMonths > 12) {
				$diff = ($this->actual_month + $this->availableMonths) - 12;
				$year = $this->actual_year + 1;
				$month = $diff;
			} else {
				$month = $month + $this->availableMonths;
			}
			
			if($this->actual_day == (date("t", mktime(0, 0, 0, $this->actual_month, 1, $this->actual_year)))) {
				$day = date("t", mktime(0, 0, 0, $month, 1, $this->actual_year));
			}
			
			$this->lastAvailable = mktime(0, 0, 0, $month, $day, $year);
		}
		
		function getMonthName()
		{
			switch($this->month)
			{
				case "01": $month = "Janeiro - ".$this->year; break;
				case "02": $month = "Fevereiro - ".$this->year; break;
				case "03": $month = "Março - ".$this->year; break;
				case "04": $month = "Abril - ".$this->year; break;
				case "05": $month = "Maio - ".$this->year; break;
				case "06": $month = "Junho - ".$this->year; break;
				case "07": $month = "Julho - ".$this->year; break;
				case "08": $month = "Agosto - ".$this->year; break;
				case "09": $month = "Setembro - ".$this->year; break;
				case "10": $month = "Outubro - ".$this->year; break;
				case "11": $month = "Novembro - ".$this->year; break;
				case "12": $month = "Dezembro - ".$this->year; break;
			}
			return $month;
		}
		
		function getWeekDayName($num)
		{
			switch($num)
			{
				case 0: $day = "Domingo"; break;
				case 1: $day = "Segunda"; break;
				case 2: $day = "Terça"; break;
				case 3: $day = "Quarta"; break;
				case 4: $day = "Quinta"; break;
				case 5: $day = "Sexta"; break;
				case 6: $day = "Sábado"; break;
			}
			return $day;
		}
		
		function printCalendar()
		{
			$start = false;
			$end = false;
			$day = 1;
			
			$monthDays['first'] = date("w", mktime(0, 0, 0, $this->month, 1, $this->year)); // Primeiro dia do mes (0=domingo a 6=sabado)
			$monthDays['current'] = date("t", mktime(0, 0, 0, $this->month, 1, $this->year)); // quantidade de dias do mes
			$monthDays['past'] = date("t", mktime(0, 0, 0, (($this->month > 1)? ($this->month - 1) : 12), 1, (($this->month > 1)? $this->year : ($this->year - 1)))); // quantidade de dias do mes anterior
			
			$calendar  = "<table id='calendarTable' name='calendarTable' class='calendarTable' cellpadding='0' cellspacing='5'>\n";
			$calendar .= "		<thead>\n";
			// Cabeçalho
			$calendar .= "			<tr>\n";
			$calendar .= "				<th><div align='center'>".$this->_utils->imageButton("Anterior", "btnback", "btnback", "changeMonth(\"previous\")", "previous", ($this->variation <= -5 || $this->cdroom == 0? false:true), false, true, true)."</div></th>\n";
			$calendar .= "				<th colspan='5'><div style='height:20px; margin-top:-40px;'><table cellpadding='0' cellspacing='0' style='width:100%;'><tr><td style='border:none; vertical-align:botton; text-align:center;'><font class='titleMonth'>".$this->company."</font></td></tr>\n";
            $calendar .= "				<tr><td style='border:none; vertical-align:top; text-align:center;'><font class='titleMonth'>".$this->getMonthName()."</font></td></tr></table></div></th>\n";
			$calendar .= "				<th><div align='center'>".$this->_utils->imageButton("Próximo", "btnnext", "btnnext", "changeMonth(\"next\")", "next", ($this->variation >= 5 || $this->cdroom == 0? false:true), false, true, true)."</div></th>\n";
			$calendar .= "			</tr>\n";
			// Dias da semana
			$calendar .= "			<tr>\n";
			
			for($d=0; $d<=6; $d++) { // Cria colunas com os nomes dos dias da semana
				$calendar .= "				<th id='weekTitle".$d."'><font class='weekTitle'>".$this->getWeekDayName($d)."</font></th>\n";
			}
			$calendar .= "			</tr>\n";
			$calendar .= "		</thead>\n";
			$calendar .= "		<tbody>\n";
			
			for($r=0; $r<=5; $r++) {
				$calendar .= "			<tr>\n";
					for($c=0; $c<=6; $c++) {
						
                        if($start || $c == $monthDays['first']) {
							$start = true;
							
							if($this->workdays[$c] == 0 || $end || ($day < $this->actual_day && $this->month == $this->actual_month) || ($this->month < $this->actual_month) || ($this->year < $this->actual_year) || ($this->lastAvailable < mktime(0, 0, 0, $this->month, $day, $this->year)))
								$disable = true;
							else
								$disable = false;
							
							$calendar .= $this->makeDay($monthDays, $day, $disable);
							$day++;
							
							if($day > $monthDays['current']) {
								$end = true;
								$day = 1;
							}
						}
						else {
							$diff = $monthDays['first'] - $c;
							$pastDay = $monthDays['past'] - ($diff - 1);
							$calendar .= $this->makeDay($monthDays, $pastDay, true);
						}
					}
				$calendar .= "			</tr>\n";
			}
			$calendar .= "		</tbody>\n";
			$calendar .= "</table>\n";
			
			echo $calendar;
		}
		
		/*
		*	Função para retornar os <TD> dos dias
		*
		*	@param	array	$monthDays - array com primeiro dia do mes, quantidade de dias do mes e do mes anterior
		*	@param	int		$day- array com primeiro dia do mes, quantidade de dias do mes e do mes anterior
		*	@param	boolean	$disabled
		*/
		function makeDay($monthDays, $day, $disabled)
		{
			$cday = $day< 10 ? '0'.$day : $day;
			$current = $this->year."-".$this->month."-".$cday;
			$click = "";
			
			if($disabled) {
				$class = "disabled";
			} else if(array_key_exists($current, $this->reserved)) {
				$class = "reserved";
				unset($this->reserved[$current]);
			} else {
				$class = "enabled";
				$click = "onclick=\"newReserve('$current');\"";
			}
			
			$return = "				<td class='".$class."' ".$click.">$day</td>\n";
			return $return;
		}
	}
?>