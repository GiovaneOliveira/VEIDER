<?
	/*
	*	Classe para criar objetos HTML
	*
	*	@author	Fábio Augusto Cardoso
	*				Giovane de Oliveira
	*				Maitê Raduenz Falcão
	*/

	class utils
	{
		var $javascript;
		var $qtbuttons;
		var $toolbar;
		var $stateCombo;
		var $cityCombo;
		
		/*
		*	Construtor - Carrega arquivo de funções em JS e arquivo CSS
		*/
		function utils()
		{
			echo "<script language='javascript' src='../../js/veider.js'></script>";
            echo "<script src='../../js/jquery.js'></script>";
			echo "<link rel='stylesheet' type='text/css' href='../../css/veider.css'>";

			$this->javascript = "";
			$this->qtbuttons = 0;
			$this->toolbar = "";
			$this->stateCombo = false;
			$this->cityCombo = false;
		}

		/*
		*	Função para criar um campo texto
		*
		*	@author	Giovane de Oliveira
		*				Maitê Raduenz Falcão
		*
		*	@param	string		$label, $id, $name, $style ex: 'width:100px;', $value
		*	@param	integer		$maxlength
		*	@param	boolean		$required, $enabled, $password
		*	@param array			$events ex: array("onblur"=>"functionEvent()")
		*/
		function inputText($label = "", $id, $name, $maxlength, $style = "", $value = "", $required = false, $enabled = true, $password = false, $events = array())
		{
			$style = empty($style)? "" : "style='".$style."'";
			$requiredLabel = ($required)? "<font class='inputCommon' style='cursor:help;' title='Obrigatório'>&nbsp;*</font>" : "";
			$label = empty($label)? "" : "<label class='inputCommon' for='".$id."'>".$label."</label>".$requiredLabel."<br>";
			$required = ($required)? "required='1'" : "";
			$enabled = (!$enabled)? "readonly='readonly' class='readOnly'" : "";
			$type = ($password)? "password" : "text";
			
			$event = "";
			foreach($events as $key => $val) {
				$event .= " ".$key."='".$val."' ";
			}

			echo $label."<input type='".$type."' id='".$id."' name='".$name."' maxlength='".$maxlength."' value='".$value."' ".$style.$required.$enabled.$event.">";
		}

		/*
		*	Função para criar um campo <textarea>
		*
		*	@param	string	$label, $id, $name, $style, $value
		*	@param boolean	$required, $enabled
		*	@param array		$events ex: array("onblur"=>"functionOnBlur()")
		*/
		function inputTextArea($label = "", $id, $name, $style = "", $value = "", $required = false, $enabled = true, $events = array())
		{
			$style = empty($style)? "" : "style='".$style."'";
			$requiredLabel = ($required)? "<font class='inputCommon' style='cursor:help;' title='Obrigatório'>&nbsp;*</font>" : "";
			$label = empty($label)? "" : "<label class='inputCommon' for='".$id."'>".$label."</label>".$requiredLabel."<br>";
			$required = ($required)? "required='1'" : "";
			$enabled = (!$enabled)? "readonly='readonly' class='readOnly'" : "";
			
			$event = "";
			foreach($events as $key => $val) {
				$event .= " ".$key."='".$val."' ";
			}
			
			echo $label."<textarea id='".$id."' name='".$name."' maxlength='2000' ".$style.$required.$enabled.$event." class='textArea'>".$value."</textarea>";
		}

		/*
		*	Função para criar um campo font
		*
		*	@author	Fábio Augusto Cardoso
		*
		*	@param	string		$fontText
		*/
		function createFont($fontText)
		{
			echo "<font class='textCommon'>".$fontText."</font>";
		}

		/*
		*	Função para criar um campo combobox
		*
		*	@author Giovane de Oliveira
		*
		*	@param	string		$label, $id, $name, $style ex: 'width:100px;'
		*	@param	array		$option ex: array('option1', 'option2', ...)
		*	@param	string		$onchange ex: 'functionJS(params);' -> Função JS que será executada ao trocar opção do combo
		*	@param	string		$select ex: 'option2' -> Opção do combo que virá selecionada por padrão
		*	@param boolean		$required, $enabled
		*/
		function inputCombobox($label = "", $id, $name, $style = "", $option = array(), $onchange = "", $select = null, $required = false, $enabled = true)
		{
			$requiredLabel = ($required)? "<font class='inputCommon' style='cursor:help;' title='Obrigatório'>&nbsp;*</font>" : "";
			$label = empty($label)? "" : "<label for='".$id."' class='inputCommon'>".$label."</label>".$requiredLabel."<br>";
			$style = empty($style)? "" : "style='".$style."'";
			$onchange = empty($onchange)? "" : "onchange='".$onchange."'";
			$required = ($required)? "required='1'" : "";
			$enabled = (!$enabled)? "disabled='disabled'" : "";
            
			$combobox = $label."
						<select id='".$id."' name='".$name."' ".$style.$onchange.$required.$enabled." >
							<option value='' id='00'></option>";
							foreach($option as $key => $value) {
                                if(is_array($value)) {
                                    $text = $value['content'];
                                    $father = "father='".$value['father']."'";
                                } else {
                                    $text = $value;
                                    $father = "";
                                }
								$selected = $select == $key? "selected='selected'" : "";
								$combobox .= "<option value='".$key."' id='opt_".$id."_".$key."' ".$selected.$father.">".$text."</option>";
							}
			$combobox .= "</select>";

			echo $combobox;
		}
		
		function inputStateCombo($style = "", $selected = "00", $enabled = true, $required = true)
		{
			require_once("class.dba_connect.inc");
			$conn = new dba_connect();
			
			$stateOptions = array();
			$sql = "SELECT CDSTATE, NMSTATE FROM VRSTATE";
			$ex = $conn->query($sql);
			$conn->close();
			
			foreach($ex as $value) {
				$stateOptions[$value['cdstate']] = $value['nmstate'];
			}
			
			$this->stateCombo = true;
			$stateCombo = $this->inputCombobox("Estado", "cdstate", "cdstate", $style, $stateOptions, "", $selected, $required, $enabled);
			
			echo $stateCombo;
		}
		
		function inputCityCombo($style = "", $selected = "00", $enabled = true, $required = true)
		{
			require_once("class.dba_connect.inc");
			$conn = new dba_connect();
			
			$cityOptions = array();
			
			$sql = "SELECT CDCITY, NMCITY, CDSTATE FROM VRCITY ORDER BY NMCITY";
			$ex = $conn->query($sql);
			foreach($ex as $value) {
				$cityOptions[$value['cdcity']]['content'] = $value['nmcity'];
				$cityOptions[$value['cdcity']]['father'] = $value['cdstate'];
			}
			$conn->close();
			
			$this->cityCombo = true;
			$cityCombo = $this->inputCombobox("Cidade", "cdcity", "cdcity", $style, $cityOptions, "", $selected, $required, $enabled);
			
			echo $cityCombo;
		}
		
		/*
		*	Função para criar um campo file
		*
		*	@author Fabio Augusto Cardoso
		*
		*	@param	string		$label, $id, $name, $style ex: 'width:100px;', $onchange ex: 'functionJS(params);'
		*	@param	string		$onchange ex: 'functionJS(params);' -> Função JS que será executada ao selecionar um arquivo
		*	@param boolean		$enabled
		*/
		function inputFile($label, $id, $name, $style = "", $onchange = "", $enabled = true)
		{
			$style = empty($style)? "" : "style='".$style."'";
			$onchange = empty($onchange)? "" : "onchange='".$onchange."'";
			$label = empty($label)? "" : "<label for='".$id."' class='inputCommon'>".$label."</label><br>";
			$enabled = (!$enabled)? "disabled='disabled'" : "";

			echo $label."<input type='file' name='".$name."' id='".$id."' ".$style." ".$onchange.$enabled." />";
		}
		
		/*
		*	Função para criar um checkbox
		*
		*	@author Fabio Augusto Cardoso
		*
		*	@param	string		$label, $type(1 = checkbox, !1 = radio), $id, $name, $onclick ex: 'functionJS(params);'
		*	@param	string		$onclick ex: 'functionJS(params);' -> Função JS que será executada ao selecionar um arquivo
		*	@param boolean		$checked, $enabled
		*/
		function inputCheckbox($label, $type = 1, $id, $name, $onclick = "", $checked = true, $enabled = true)
		{
			$onclick = empty($onclick)? "" : " onclick='".$onclick."'";
			$label = empty($label)? "" : "<label for='".$id."' class='inputCommon'>".$label."</label>";
			$enabled = (!$enabled)? " disabled='disabled'" : "";
			$type = ($type == 1)?" checkbox":"radio";
			$checked = ($checked)?" checked='true'":"checked='false'";
			
			echo "<input type=".$type." name='".$name."' id='".$id."' ".$onclick.$checked.$enabled." />".$label;
		}

		/*
		*	Função para criar um botão com TEXTO
		*
		*	@author Giovane de Oliveira
		*
		*	@param	string		$label, $id, $name
		*	@param	integer		$width ex:150   -> Por padrão não é passado tamanho para o botão, ele será criado do tamanho da palavra ($label)
		*	@param	string		$action ex: 'functionJS(params);' -> Função JS que será executada pressionar o botão
		*	@param	boolean		$enabled (botao habilitado ou nao)
		*/
		function inputButton($label, $id, $name, $width = "", $action = "", $enabled = true)
		{
			$width = empty($width)? "" : "width:".$width."px;";
			$action = empty($action)? "" : " onclick='".$action."' ";
			
			$mouseover = " onmouseover='mouseBtn(this.id, \"Hover\", \"fontButton\")' ";
			$mouseout = " onmouseout='mouseBtn(this.id, \"Normal\", \"fontButton\")' ";
			$mousedown = " onmousedown='mouseBtn(this.id, \"Pressed\", \"fontButtonPressed\")' ";
			$mouseup  = " onmouseup='mouseBtn(this.id, \"Normal\", \"fontButton\")' ";
			
			if($enabled) {
				$class = " class='buttonNormal' ";
				$disable = "";
				$font = " class='fontButton' ";
			} else {
				$class = " class='buttonDisabled' ";
				$disable = " disabled='disabled' ";
				$font = " class='fontButtonDisabled' ";
			}
			$events = $action.$mouseover.$mouseout.$mousedown.$mouseup.$class.$disable;
			
			$button = "<button id='".$id."' name='".$name."' style='padding-top:5px; height:28px; ".$width."' ".$events." align='center'>
								<font id='obj_".$id."' name='obj_".$name."' align='center' ".$font.">".$label."</font>
							</button>";

			$this->qtbuttons++;

			echo $button;
		}

		/*
		*	Função para criar um botão com IMAGEM
		*
		*	@author Giovane de Oliveira
		*
		*	@param	string		$hint, $id, $name
		*	@param	string		$action ex: 'functionJS(params);' -> Função JS que será executada pressionar o botão
		*	@param	strint		$icon ex: 'save' -> nome da imagem salva em "image/button_icon", em formato PNG
		*	@param boolean		$enabled
		*/
		function imageButton($hint, $id, $name, $action, $icon, $enabled = true, $isToolbar = true, $listBtns = false)
		{
			$action = empty($action)? "" : "onclick='".$action."'";
			
			$mouseover = " onmouseover='mouseBtn(this.id, \"Hover\", \"imgButton\")' ";
			$mouseout = " onmouseout='mouseBtn(this.id, \"Normal\", \"imgButton\")' ";
			$mousedown = " onmousedown='mouseBtn(this.id, \"Pressed\", \"imgButtonPressed\")' ";
			$mouseup  = " onmouseup='mouseBtn(this.id, \"Normal\", \"imgButton\")' ";
			
			if($enabled) {
				$class = " class='buttonNormal' ";
				$disable = "";
				$font = " class='imgButton' ";
				$src = "../../image/button_icon/".$icon.".png";
			} else {
				$class = " class='buttonDisabled' ";
				$disable = " disabled='disabled' ";
				$font = " class='imgButtonDisabled' ";
				$src = "../../image/button_icon/".$icon."_disabled.png";
			}
			$events = $action.$mouseover.$mouseout.$mousedown.$mouseup.$class.$disable;
			
			$margintop = ($this->qtbuttons >= 1 && !$listBtns)? "10" : "5";
			$button = "<button id='".$id."' name='".$name."' style='padding-top:5px; width:57px; margin-top:".$margintop."px;' align='center' ".$events.(!empty($hint)? "title='".$hint."'" : "").">
								<img id='obj_".$id."' src='".$src."' ".$font."/>
							</button>";

			$this->qtbuttons++;
            
            if($isToolbar)
                $this->toolbar .= $button;
            else
                return $button;
		}

		/*
		*	Função para criar div com imagem para o campo Photo
		*
		*	@author Fábio Augusto Cardoso
		*
		*	@param	string		$id, $name, $style, $width, $height
		*	@param	strint		$img, campo Photo
		*/

		function inputDivImg($id, $name, $width, $height,$style,$img)
		{
			echo '<div id="div_'.$id.'" name="div_'.$name.'" width="'.$width.'" height="'.$height.'" style="'.$style.'">
						<img id="'.$id.'" name="'.$name.'" width="'.$width.'" height="'.$height.'" src="../../temp/'.$img.'" />
				</div>';
		}

		/*
		*	Função para criar a borda das telas
		*
		*	@author Giovane de Oliveira
		*
		*	@param	boolean	$toolbar - se vai ter ou nao barra com botões
		*
		*	@warning
		*		Se $toolbar == true, deverão ser setados os botões antes da chamada do beginDivBorder.
		*		Ex:
		*				$utils->imageButton("Registrar", "btnregister", "btnregister", "verifySubmit();", "../image/button_icon/save.png");
		*				$utils->beginDivBorder(true);
		*/
		function beginDivBorder($toolbar = false)
		{
			if($toolbar)
			{
				$div = "<div class='dvborder' id='dvborder' name='dvborder' style='margin-left:85px; height:100%;'>";
				$div .= "<div class='dvborder' id='dvtoolbar' name='dvtoolbar' style='position:absolute; left:10px; top:10px; width:60px; height:100%;'>";
				$div .= $this->imageButton("Refresh", "btn_refresh", "btn_refresh", "location.reload()", "refresh");
				$div .= $this->toolbar;
				$div .= "</div>";
			}
			else
			{
				$div = "<div class='dvborder' id='dvborder' name='dvborder' style='height:99%;'>";
			}
			echo $div;
		}

		/*
		*	Fecha borda da tela
		*/
		function endDivBorder()
		{
			echo "</div>";
		}

		/*
		*	Escreve JS armazenado anteriormente
		*/
		function writeJS()
		{
			if($this->stateCombo && $this->cityCombo) {
				$this->javascript .=
					"var cdcity = $('#cdcity option').clone();
					
					$('#cdstate').change(function() {
						var val = $(this).val();  
						
						$('#cdcity').empty();
						
						var emptyOption = new Option('', '0');
						$('#cdcity').append(emptyOption);
						
						cdcity.filter(function(idx, el) {
							if($(el).attr('father') == val || val == 0)
								return $(el).text();
						}).appendTo('#cdcity');
					});
				";
			}
			
			echo $this->javascript;
		}
	}
?>