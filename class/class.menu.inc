<?
    class menu
    {
        var $menu;
        var $itens;
        
        function menu()
        {
            $this->menu = array();
            $this->itens = 0;
            echo "<script type='text/javascript' src='../../js/jquery.js'></script>";
			echo "<script type='text/javascript'>
						$(document).ready(function()
						{
							// desliza o elemento com class=menu_body quando paragrafo com class=menu_head é clicado
							$('#output_menu p.menu_head').click(function()
							{
								//$(this).next('div.menu_body').slideToggle(300).siblings('div.menu_body').slideUp('slow'); -> Contrai o q estiver expandido
								$(this).next('div.menu_body').slideToggle(400);
							});
						});
					</script>";
        }
        
        /*
        *   Função para adicionar uma linha no menu
        *
        *   Author  Giovane de Oliveira
        *
        *   @param  $label    string      Nome do menu
        *   @param  $src      string      URL que vai ser carregada ao clicar no menu
        *   @param  $owner  boolean     Se menu é pai(true) ou filho(false)
        */
        function add($label, $src, $owner)
        {
            $this->menu[$this->itens]['label'] = $label;
            $this->menu[$this->itens]['src'] = $src;
            $this->menu[$this->itens]['owner'] = $owner;
            
            $this->itens++;
        }
        
        function output($width)
        {
            $array = $this->menu;
            
            $output = "<div id='output_menu' name='output_menu' width='".$width."'>";
            
            foreach($array as $key => $value)
            {
                if($value['owner']) {
                    if($key > 0)
                        $output .= "</div>";
                    $output .= "<p class='menu_head'>".$value['label']."</p>";
                    $output .= "<div class='menu_body'>";
                } else {
                    $output .= "<a href='#'>".$value['label']."</a>";
                }
            }
            
            $output .= "</div>";
            
            echo $output;
        }
    }
?>