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

		/*
		*	Construtor - Carrega arquivo de funções em JS e arquivo CSS
		*/
		function utils()
		{
			echo "<script language='javascript' src='../js/veider.js'></script>";
			echo "<link rel='stylesheet' type='text/css' href='../css/veider.css'>";

			$this->javascript = "";
			$this->qtbuttons = 0;
			$this->toolbar = "";
		}

		/*
		*	Função para criar um campo texto
		*
		*	@author	Giovane de Oliveira
		*				Maitê Raduenz Falcão
		*
		*	@param	string		$label, $id, $name, $style ex: 'width:100px;', $value
		*	@param	integer		$maxlength
		*	@param	boolean	$password (se TRUE - campo esconde caracteres digitados)
		*/
		function inputText($label = "", $id, $name, $maxlength, $style = "", $value = "", $required = false, $password = false)
		{
			$style = empty($style)? "" : "style='".$style."'";
			$requiredLabel = ($required)? "<font class='inputCommon' style='cursor:help;' title='Obrigatório'>&nbsp;*</font>" : "";
			$label = empty($label)? "" : "<label class='inputCommon' for='".$id."'>".$label."</label>".$requiredLabel."<br>";
			$required = ($required)? "required='1'" : "";
			$type = ($password)? "password" : "text";
			
			echo $label."<input type='".$type."' id='".$id."' name='".$name."' maxlength='".$maxlength."' value='".$value."' ".$style.$required.">";
		}
		
		/*
		*	Função para criar um campo <textarea>
		*
		*	@param	string	$label, $id, $name, $style, $value
		*/
		function inputTextArea($label = "", $id, $name, $style = "", $value = "", $required = false)
		{
			$style = empty($style)? "" : "style='".$style."'";
			$requiredLabel = ($required)? "<font class='inputCommon' style='cursor:help;' title='Obrigatório'>&nbsp;*</font>" : "";
			$label = empty($label)? "" : "<label class='inputCommon' for='".$id."'>".$label."</label>".$requiredLabel."<br>";
			$required = ($required)? "required='1'" : "";
			
			echo $label."<textarea id='".$id."' name='".$name."' maxlength='2000' ".$style.$required.">".$value."</textarea>";
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
		*	@param	string		$onchange ex: 'functionJS(params);' -> Função JS que será executada ao trocar opção do combo
		*	@param	string		$select ex: 'option2' -> Opção do combo que virá selecionada por padrão
		*	@param	array		$option ex: array('option1', 'option2', ...)
		*/
		function inputCombobox($label = "", $id, $name, $style = "", $option = array(), $onchange = "", $select = null, $required = false)
		{
			$requiredLabel = ($required)? "<font class='inputCommon' style='cursor:help;' title='Obrigatório'>&nbsp;*</font>" : "";
			$label = empty($label)? "" : "<label for='".$id."' class='inputCommon'>".$label."</label>".$requiredLabel."<br>";
			$style = empty($style)? "" : "style='".$style."'";
			$onchange = empty($onchange)? "" : "onchange='".$onchange."'";
			$required = ($required)? "required='1'" : "";
			
			$combo = 1;
			$combobox = $label."
						<select id='".$id."' name='".$name."' ".$style.$onchange.$required." >
							<option value='' id='00'></option>";
							foreach($option as $value) {
								$selected = $select == $combo? "selected='selected'" : "";
								$combobox .= "<option value='".$combo."' id='opt_".$id."_".$combo."' ".$selected.">".$value."</option>";
								$combo++;
							}
			$combobox .= "</select>";

			echo $combobox;
		}

		/*
		*	Função para criar um campo file
		*
		*	@author Fabio Augusto Cardoso
		*
		*	@param	string		$label, $id, $name, $style ex: 'width:100px;', $onchange ex: 'functionJS(params);'
		*	@param	string		$onchange ex: 'functionJS(params);' -> Função JS que será executada ao selecionar um arquivo
		*/
		function inputFile($label, $id, $name, $style = "", $onchange = "")
		{
			$style = empty($style)? "" : "style='".$style."'";
			$onchange = empty($onchange)? "" : "onchange='".$onchange."'";
			$label = empty($label)? "" : "<label for='".$id."' class='inputCommon'>".$label."</label><br>";



			echo $label."<input type='file' name='".$id."' id='".$name."' ".$style." ".$onchange." />";
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
			
			if($enabled) {
				$mouseover = " onmouseover='mouseBtn(this.id, \"buttonHover\", \"fontButton\")' ";
				$mouseout = " onmouseout='mouseBtn(this.id, \"buttonNormal\", \"fontButton\")' ";
				$mousedown = " onmousedown='mouseBtn(this.id, \"buttonPressed\", \"fontButtonPressed\")' ";
				$mouseup  = " onmouseup='mouseBtn(this.id, \"buttonNormal\", \"fontButton\")' ";
				$class = " class='buttonNormal' ";
				$font = " class='fontButton' ";
				
				$events = $action.$mouseover.$mouseout.$mousedown.$mouseup.$class;
			} else {
				$events = " class='buttonDisabled' ";
				$font = " class='fontButtonDisabled' ";
			}
			
			$button = "<div id='".$id."' name='".$name."' style='padding-top:5px; height:18px; ".$width."' ".$events." align='center'>
								<font id='obj_".$id."' name='obj_".$name."' align='center' ".$font.">".$label."</font>
							</div>";
			
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
		*	@param	strint		$icon ex: '../image/imagem.gif' -> url da imagem a ser usada
		*/
		function imageButton($hint, $id, $name, $action, $icon, $enabled = true)
		{
			$action = empty($action)? "" : "onclick='".$action."'";
			
			if($enabled) {
				$mouseover = " onmouseover='mouseBtn(this.id, \"buttonHover\", \"imgButton\")' ";
				$mouseout = " onmouseout='mouseBtn(this.id, \"buttonNormal\", \"imgButton\")' ";
				$mousedown = " onmousedown='mouseBtn(this.id, \"buttonPressed\", \"imgButtonPressed\")' ";
				$mouseup  = " onmouseup='mouseBtn(this.id, \"buttonNormal\", \"imgButton\")' ";
				$class = " class='buttonNormal' ";
				$font = " class='imgButton' ";
				$src = "../image/button_icon/".$icon.".gif";
				
				$events = $action.$mouseover.$mouseout.$mousedown.$mouseup.$class;
			} else {
				$events = " class='buttonDisabled' ";
				$font = " class='imgButtonDisabled' ";
				$src = "../image/button_icon/".$icon."_disabled.gif";
			}
			
			$button = "<div id='".$id."' name='".$name."' style='padding-top:5px; width:54px; margin-top:4px;' align='center' ".$events.(!empty($hint)? "title='".$hint."'" : "").">
								<img id='obj_".$id."' src='".$src."' ".$font."/>
							</div>";
			
			$this->qtbuttons++;
			$this->toolbar .= $button;
		}

		/*
		*	Função para criar div com imagem para o campo Photo
		*
		*	@author Fábio Augusto Cardoso
		*
		*	@param	string		$id, $name, $style
		*	@param	strint		$img, campo Photo
		*/

		function inputDivImg($id, $name, $style,$img)
		{
			echo '<div id="div_'.$id.'" name="div_'.$name.'" width="100" height="100" style="'.$style.'">
						<img id="'.$id.'" name="'.$name.'" width="100" height="100" src="../temp/'.$img.'" />
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
		*				$utils->imageButton("Registrar", "btnregister", "btnregister", "verifySubmit();", "../image/button_icon/save.gif");
		*				$utils->beginDivBorder(true);
		*/
		function beginDivBorder($toolbar = false)
		{
			if($toolbar)
			{
				$div = "<div class='dvborder' id='dvborder' name='dvborder' style='margin-left:85px; height:100%;'>";
				$div .= "<div class='dvborder' id='dvtoolbar' name='dvtoolbar' style='position:absolute; left:10px; top:10px; width:60px; height:100%;'>";
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
			echo $this->javascript;
		}
	}
?>