<?
	class tableList
	{
		var $queryfields;
		var $titlenames;
		var $fieldnames;
		var $maxwidth;
		var $hidden;
		var $total;
		
		function tableList(){
			echo "<link rel='stylesheet' type='text/css' href='../css/veider.css'>";
			echo "<script language='javascript' src='../js/tableList.js'></script>";
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
		
		function setMaxWidth($maxwidth) {
			$this->maxwidth = $maxwidth;
		}
		
		function setHiddenObject($hidden) {
			$this->hidden = $hidden;
		}
		
		function printList($obj) {
			$this->total = count($this->queryfields);
			
			$col = 0; $row = 1;
			
			$list = "
				<script type='text/javascript'>
					var hiddenField = '".strtolower($this->hidden)."';
					var divToOutput = document.getElementById('".$obj."');
					
					dvList();
					tableList(".$row.");
				";
				foreach($this->titlenames as $key => $value) {
					$list .= "newTitleTd('".$value."', ".$col.", ".$row.", '".$this->maxwidth[$col]."');";
					$col++;
				}
				foreach($this->queryfields as $key => $value) {
					$col = 0;
					$list .= "newRegTr(".$this->queryfields[$key][strtolower($this->hidden)].", ".$row.");";
					foreach($this->fieldnames as $key2 => $value2) {
						$list .= "newRegTd('".$this->queryfields[$key][strtolower($value2)]."', ".$col.", ".$row.", '".$this->maxwidth[$col]."');";
						$col++;
					}
					$row++;
				}
				
				$list .= "getFooter(".$this->total.");";
				$list .= "
					</script>
				";
			
			echo $list;
		}
	}
?>