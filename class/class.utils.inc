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
		*	@param	boolean	$password (se TRUE - campo esconde caracteres digitados)
		*/
		function inputText($label = "", $id, $name, $style = "", $password = false, $value = "")
		{
			$style = empty($style)? "" : "style='".$style."'";
			$label = empty($label)? "" : "<label class='inputCommon' for='".$id."'>".$label."</label><br>";
			$type = ($password)? "password" : "text";
			
			echo $label."<input type='".$type."' id='".$id."' name='".$name."' value='".$value."' ".$style." >";
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
		function inputCombobox($label = "", $id, $name, $style = "", $option = array(), $onchange = "", $select = null)
		{
			$label = empty($label)? "" : "<label for='".$id."' class='inputCommon'>".$label."</label><br>";
			$style = empty($style)? "" : "style='".$style."'";
			$onchange = empty($onchange)? "" : "onchange='".$onchange."'";
			
			$combo = 1;
			$combobox = $label."
						<select id='".$id."' name='".$name."' ".$style.$onchange.">
							<option value='' id='00'></option>";
							foreach($option as $value) {
								$selected = $select == $value? "selected='selected'" : "";
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
			$action = empty($action)? "" : "onchange='".$onchange."'";
			$label = empty($label)? "" : "<label for='".$id."' class='inputCommon'>".$label."</label><br>";
			
			
			
			echo $label."<input type='file' name='".$id."' id='".$name."' ".$style." ".$onchange." />";
		}
		
		/*
		*	Função para criar um botão com TEXTO
		*
		*	@author Giovane de Oliveira
		*
		*	@param	string		$label, $id, $name
		*	@param	integer	$width ex:150   -> Por padrão não é passado tamanho para o botão, ele será criado do tamanho da palavra ($label)
		*	@param	string		$action ex: 'functionJS(params);' -> Função JS que será executada pressionar o botão
		*/
		function inputButton($label, $id, $name, $width = "", $action = "")
		{
			$width = empty($width)? "" : "width:".$width."px;";
			$action = empty($action)? "" : "onclick='".$action."'";
			
			$button = "<div id='".$id."' name='".$name."' style='padding-top:5px; height:18px; ".$width."' ".$action." onmouseover='mouseBtn(this.id, \"buttonHover\", \"fontButton\")' onmouseout='mouseBtn(this.id, \"buttonNormal\", \"fontButton\")' onmousedown='mouseBtn(this.id, \"buttonPressed\", \"fontButtonPressed\")' onmouseup='mouseBtn(this.id, \"buttonNormal\", \"fontButton\")' class='buttonNormal' align='center'>
								<font id='obj_".$id."' name='obj_".$name."' class='fontButton' align='center'>".$label."</font>
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
		function imageButton($hint, $id, $name, $action, $icon)
		{
			$action = empty($action)? "" : "onclick='".$action."'";
			
			$button = "<div id='".$id."' name='".$name."' style='padding-top:5px; width:54px; margin-top:4px;' ".$action." onmouseover='mouseBtn(this.id, \"buttonHover\", \"imgButton\")' onmouseout='mouseBtn(this.id, \"buttonNormal\", \"imgButton\")' onmousedown='mouseBtn(this.id, \"buttonPressed\", \"imgButtonPressed\")' onmouseup='mouseBtn(this.id, \"buttonNormal\", \"imgButton\")' class='buttonNormal' align='center' ".(!empty($hint)? "title='".$hint."'" : "").">
								<img id='obj_".$id."' src='".$icon."' class='imgButton'/>
							</div>";
			
			$this->qtbuttons++;
			$this->toolbar .= $button;
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