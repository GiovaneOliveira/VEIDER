<?
    class menu
    {
        var $menu;
        var $itens;
        
        function menu()
        {
            $this->menu = array();
            $this->itens = 0;
            echo "<link rel='stylesheet' type='text/css' href='../../css/menu.css'>";
            echo "<script type='text/javascript' src='../../js/menu.js'></script>";
            echo "<script type='text/javascript' src='../../js/jquery.js'></script>";
            // Efeito Jquery para deslizar op��es do menu
            echo "  <script>
                            $(document).ready( function() {
                                /* Faz o slide do elemento que tiver class = menuItem , quando um paragrafo com classe = menuTitle for clicado */
                                $('#output_menu p.menuTitle').click(function() {
                                    $(this).next('div.menuItem').slideToggle(300).siblings('div.menuItem').slideUp('slow');
                                    $(this).siblings();
                                });
                            });
                        </script>";
        }
        
        /*
        *   Fun��o para adicionar uma linha no menu
        *
        *   Author  Giovane de Oliveira
        *
        *   @param  $label    string      Nome do menu
        *   @param  $src      string      URL que vai ser carregada ao clicar no menu
        *   @param  $owner  boolean     Se menu � pai(true) ou filho(false)
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
            
            $mouseover = " onmouseover=\"menuBG(this.id, 1);\" ";
            $mouseout = " onmouseout=\"menuBG(this.id, 2);\" ";
            
            $output = "<div id='output_menu' name='output_menu' class='dvMenu' style='width:".$width.";'>\n";
            
            $item = 0;
            foreach($array as $key => $value)
            {
                if($value['owner']) {
                    if($key > 0)
                        $output .= "</div>\n";
                    $output .= "<p class='menuTitle'>".$value['label']."</p>\n";
                    $output .= "<div class='menuItem'>\n";
                } else {
                    $item ++;
                    
					$action = is_array($value['src']) ? "window_open('".$value['src']['data']."', ".$value['src']['width'].", ".$value['src']['height'].")" : "reloadFrames('".$value['src']."')";
					
					$output .= "\t<a id='item_".$item."' class='itemSpan' onmousedown=\"menuBG(this.id, 3); ".$action.";\" ".$mouseover.$mouseout.">".$value['label']."</a>\n";
                }
            }
            $output .= "</div>\n";
            
            echo $output;
        }
    }
?>