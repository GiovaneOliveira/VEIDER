<?
	class tableList
	{
		var $queryfields;
		var $titlenames;
		var $fieldnames;
		var $colwidth;
		var $colalign;
		var $hidden;
		var $clickfunction = false;
		var $dblclickfunction = false;
		var $datecols = null;
		var $imgcols = null;
		var $total;

		function tableList(){
			echo "<script type='text/javascript' src='../../js/list.js'></script>";
			echo "<link rel='stylesheet' type='text/css' href='../../css/list.css' />";
		}

		function setQueryFields($queryfields) {
			$this->queryfields = $queryfields;
		}

		function setTitleNames($titlenames) {
			$this->titlenames = $titlenames;
		}

		function setFieldNames($fieldnames) {
			$this->fieldnames = $fieldnames;
		}

		function setColWidth($colwidth) {
			$this->colwidth = $colwidth;
		}

		function setColAlign($colalign) {
			$this->colalign = $colalign;
		}

		function setHiddenObject($hidden) {
			$this->hidden = $hidden;
		}

		function setClickFunction($function) {
			$this->clickfunction = $function;
		}

		function setDblClickFunction($function) {
			$this->dblclickfunction = $function;
		}
		
		function setDateCols($cols) {
			$this->datecols = $cols;
		}
		
		function setImgCols($cols) {
			$this->imgcols = $cols;
		}
		
		function printList($obj) {
			$this->total = count($this->queryfields);

			$col = 0; $row = 1; $click = ""; $dblclick = "";

			$mouseover = " onmouseover='mouseReg(this.id, 1)' ";
			$mouseout = " onmouseout='mouseReg(this.id, 2)' ";
			
			if($this->clickfunction)
				$click = " onclick='".$this->clickfunction."' ";
			if($this->dblclickfunction)
				$dblclick = " ondblclick='".$this->dblclickfunction."' ";

			$events = $mouseover.$mouseout.$click.$dblclick;

			$list = "
				<div id='dv_list_".$this->hidden."' style='width:100%;overflow:auto;'>
					<table cellpadding='0' cellspacing='0' style='min-width:100%;'>
						<thead>
							<tr class='trHeader'>\n";
								foreach($this->titlenames as $value) {
									$list .= "<th class='thHeader' style='width:".$this->colwidth[$col]."; text-align:".$this->colalign[$col].";'>".$value."</th>\n";
									$col++;
								}
							$list.="</tr>
						</thead>
						<tbody>\n";
							foreach($this->queryfields as $rowfield) {
									$col = 0;
									$list .= "<tr class='trList' id='".$this->hidden."_tr_".$row."' ".$events." onmousedown='mouseReg(this.id, 3); setHidden(".$rowfield[strtolower($this->hidden)].")' >\n";
									foreach($this->fieldnames as $colfield) {
										$coldata = $this->alterColValue($colfield, $rowfield[strtolower($colfield)], $this->queryfields[$row-1]);
										
										$list .= "<td class='tdList' style='width:".$this->colwidth[$col]."; text-align:".$this->colalign[$col].";'>".$coldata."</td>\n";
										$col++;
									}
									$list .= "</tr>\n";
									$row++;
							}
							$list .= "</tbody>
					</table>
				</div>
				<div class='dvFooter'><font class='fontFooter'>Total - (".$this->total.")</font></div>
				<script type='text/javascript'>var hiddenField = '".$this->hidden."'; document.getElementById('dv_list_".$this->hidden."').style.height = (".$obj.".clientHeight - 35)+'px';</script>
			";
			
			echo $list;
		}
		
		function alterColValue($colfield, $coldata, $rowdata)
		{
			require_once("../../class/veider_functions.inc");
			
			if(is_array($this->datecols) && in_array($colfield, $this->datecols) && !empty($coldata)) {
				return formatDate($coldata);
			} else if(is_array($this->imgcols) && array_key_exists($colfield, $this->imgcols)) {
				$function = $this->imgcols[$colfield];
				return $function($coldata, $rowdata);
			}
			else {
				return $coldata;
			}
		}
	}
?>