<?
	if( ! defined("_VEIDER_FUNCTIONS_"))
	{
		define("_VEIDER_FUNCTIONS_", 1);
		
		/*
		*	Função para retornar data formatada para exibição em tela ou uso em sql
		*
		*	@author	Giovane de Oliveira
		*
		*	@param	string		$date
		*
		*	@warning
		*			recebe $date em formato 'dd mmm yyyy hh:mm' e retorna dd/mm/yyyy
		*/
		function formatDate($date)
		{
			$explodeDate = explode("-", $date);
			$day = (strlen($explodeDate[2]) == 1)? "0".$explodeDate[2] : $explodeDate[2];
			$month = $explodeDate[1];
			$year = $explodeDate[0];
			
			return $day."/".$month."/".$year;
		}
		
		function verifyFormatImg($file,$img)
		{
			echo "
				function verifyImage()
				{
					var string = document.getElementById('".$file."').value;
					var extension = (string.substring(string.lastIndexOf('.'))).toLowerCase(); 
					
					var right_ext = new Array('.png','.jpeg','.jpg','.gif');
					var valid_ext = false;
					for(x=0;x<4;x++)
					{
						if(right_ext[x] == extension)
							valid_ext = true;
					}
					
					if(valid_ext == true)
						document.getElementById('".$img."').src = document.getElementById('".$file."').value;
					else
					{
						var lastFile = document.getElementById('".$file."');
						var cleanFile = lastFile.cloneNode(true);
						lastFile.parentNode.replaceChild(cleanFile, lastFile);
						document.getElementById('".$img."').src = '../../temp/img_null.png';
						alert('erro');
					}
				}
			";
		}
		
		/*
		*	Cria uma cópia de $img com nome aleatório na pasta 'temp' e retorna o nome do arquivo . extensão
		*
		*	@author Fábio Augusto Cardoso
		*
		*	@param	imagem	$img
		*	@return	string		$nmimg
		*/
		function uploadImg($img, $new_width, $new_height)
		{
			preg_match("/\.(png|jpg|jpeg|gif){1}$/i", $img["name"], $ext);
			
			$nmImg = md5(uniqid(time())).".".$ext[1];
			
			if(strtolower($ext[1]) == 'png')
				$img2 = imagecreatefrompng($img['tmp_name']);
			else if(strtolower($ext[1]) == 'jpeg' || strtolower($ext[1]) == 'jpg')
				$img2 = imagecreatefromjpeg($img['tmp_name']);
			else if(strtolower($ext[1]) == 'gif')
				$img2 = imagecreatefromgif($img['tmp_name']);
			
			$x   = imagesx($img2);
			$y   = imagesy($img2);
			
			$image_p = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($image_p, $img2, 0, 0, 0, 0, $new_width, $new_height, $x, $y);
			
			if($ext[1] == 'png')
				imagepng($image_p, '../../temp/'.$nmImg);
			else if(strtolower($ext[1]) == 'jpeg' || strtolower($ext[1]) == 'jpg')
				imagejpeg($image_p, '../../temp/'.$nmImg);
			else if($ext[1] == 'gif')
				imagegif($image_p, '../../temp/'.$nmImg);
			
			return $nmImg;
		}
        
        /*
        *   Cria div de carregando
        */
        function loading()
        {
            echo "
                <div id='dvLoading' name='dvLoading' class='dvLoading' style='overflow: hidden;'>
                    <img id='imgLoading' src='../../image/veider/loading.gif' class='imgLoading'/>
                </div>
                <script type='text/javascript' src='../../js/jquery.js'></script>
                <script>
                    function showLoading(){
                        $(document).ready(function () {
                            $('#dvLoading').fadeIn();
                        });
                    }
                    function hideLoading(){
                        $(document).ready(function () {
                            $('#dvLoading').fadeOut();
                        });
                    }
                     window.onload = function() { hideLoading(); };
                </script>
            ";
        }
		
		function companyPendency($col, $row) {
			if($col == 2)
				return "<img src='../../image/list_icon/money.png' title='Aguardando pagamento'/>";
			else
				return "";
		}
	}
?>