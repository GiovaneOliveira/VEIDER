<?
	require_once("class.utils.inc");
	
	class tableList
	{
		var $queryfields;
		var $titlenames;
		var $fieldnames;
		var $colwidth;
		var $colalign;
		var $hidden;
		var $hiddenfields = "";
		var $clickfunction = false;
		var $dblclickfunction = false;
		var $hastoolbar = false;
		var $toolbarbuffer = "";
		var $_utils;
		var $datecols = null;
        var $moneycols = null;
		var $imgcols = null;
		var $total;
		
		function tableList(){
            echo "<script type='text/javascript' src='../../js/jquery.js'></script>";
			echo "<script type='text/javascript' src='../../js/list.js'></script>";
			echo "<link rel='stylesheet' type='text/css' href='../../css/list.css' />";
			$this->_utils = new utils();
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
		
		function setHiddenFields($array) {
			$this->hiddenfields = $array;
		}
		
		function setClickFunction($function) {
			$this->clickfunction = $function;
		}

		function setDblClickFunction($function) {
			$this->dblclickfunction = $function;
		}
		
		function setHasToolbar($hastoolbar) {
			$this->hastoolbar = $hastoolbar;
		}
		
		function setDateCols($cols) {
			$this->datecols = $cols;
		}
		
        function setMoneyCols($cols) {
            $this->moneycols = $cols;
        }
        
		function setImgCols($cols) {
			$this->imgcols = $cols;
		}
		
		function addButton($label, $id, $name, $action, $icon, $enabled) {
			$this->toolbarbuffer[$id] = $this->_utils->imageButton($label, $id, $name, $action, $icon, $enabled, false, true);
		}
		
		function printList($obj) {
			$this->total = count($this->queryfields);

			$col = 0; $row = 1; $click = ""; $dblclick = ""; $dvlist_height = 35;

			$mouseover = " onmouseover='mouseReg(this.id, 1)' ";
			$mouseout = " onmouseout='mouseReg(this.id, 2)' ";
			
			if($this->clickfunction)
				$click = " onclick='".$this->clickfunction."' ";
			if($this->dblclickfunction)
				$dblclick = " ondblclick='".$this->dblclickfunction."' ";

			$events = $mouseover.$mouseout.$click.$dblclick;
            
            if($this->hastoolbar) {
                $dvlist_height = 84;
                $toolbar = "
                    <div id='dv_toolbar_".$this->hidden."' style='width:100%; overflow:hidden; border-bottom:2px groove #333333'>
                        <table cellpadding='0' cellspacing='0'>
                            <tr>\n";
                                foreach($this->toolbarbuffer as $value) {
                                    $toolbar .= "<td style='padding-left:10px; padding-bottom:7px;'>\n".$value."\n</td>\n";
                                }
                            $toolbar .= "</tr>
                        </table>
                    </div>\n";
            }
            
			$list = "
				<div id='dv_list_".$this->hidden."' style='width:100%; overflow:auto;'>
					<table id='table_list_".$this->hidden."' cellpadding='0' cellspacing='0' style='min-width:100%;'>
						<thead>\n";
							$list .= "<tr class='trHeader'>\n";
								foreach($this->titlenames as $value) {
									$list .= "<th class='thHeader' style='width:".$this->colwidth[$col]."; text-align:".$this->colalign[$col].";'>".$value."</th>\n";
									$col++;
								}
							$list.="</tr>
						</thead>
						<tbody>\n";
							foreach($this->queryfields as $rowfield) {
									$col = 0; $hidden = "";
									foreach($this->hiddenfields as $hiddenfield) {
										$hidden .= ";".$rowfield[strtolower($hiddenfield)];
									}
									$hidden = substr($hidden, 1);
									$list .= "<tr class='trList' id='".$this->hidden."_tr_".$row."' ".$events." onmousedown='mouseReg(this.id, 3); setHidden(\"".$hidden."\")' >\n";
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
			";
			
            $script = "
                <script>
                    $('#dv_list_".$this->hidden."').scroll(function(){
                        var scroll = $('#dv_list_".$this->hidden."').scrollTop();
                        if(scroll > 0) {
                            translate($('#table_list_".$this->hidden." th'), 0, scroll);
                        } else {
                            translate($('#table_list_".$this->hidden." th'), 0, 0);
                        }
                    });
                    
                    function translate(element, x, y) {    
                        /*var translation = 'translate('+x+'px,'+y+'px)';
                        element.css({
                            'transform': translation,
                            '-ms-transform': translation
                        });*/
                    }
                    
                    var hiddenField = '".$this->hidden."';
                    document.getElementById('dv_list_".$this->hidden."').style.height = (".$obj.".clientHeight - ".$dvlist_height.")+'px';
                </script>";
            
            $list = ($this->hastoolbar? $toolbar : "").$list.$script;
			echo $list;
		}
		
		function alterColValue($colfield, $coldata, $rowdata)
		{
			require_once("../../class/veider_functions.inc");
			
			if(is_array($this->datecols) && in_array($colfield, $this->datecols) && !empty($coldata)) {
				return formatDate($coldata);
			} else if(is_array($this->moneycols) && in_array($colfield, $this->moneycols) && $coldata != "") {
                return formatMoney($coldata);
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