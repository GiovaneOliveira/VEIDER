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
		*	@param	boolean	$db
		*
		*	@warning
		*			se $db = true, função recebe $date em formato dd/mm/yyyy e retorna 'yyyy-mm-dd'
		*			senao a função recebe $date em formato 'dd mmm yyyy hh:mm' e retorna dd/mm/yyyy
		*/
		function formatDate($date, $db = false)
		{
			$explodeDate = explode(" ", $date);
			$day = (strlen($explodeDate[0]) == 1)? "0".$explodeDate[0] : $explodeDate[0];
			$month = getMonthNumber($explodeDate[1]);
			$year = $explodeDate[2];
			
			return $day."/".$month."/".$year;
		}
		
		/*
		*	Função utilizada por 'formatDate()' para converter abreviaturas dos meses em seu respectivo número
		*	ex: $month = 'ago' -> return '08'
		*/
		function getMonthNumber($month)
		{
			switch($month)
			{
				case 'jan': $return = '01'; break;
				case 'fev': $return = '02'; break;
				case 'mar': $return = '03'; break;
				case 'abr': $return = '04'; break;
				case 'mai': $return = '05'; break;
				case 'jun': $return = '06'; break;
				case 'jul': $return = '07'; break;
				case 'ago': $return = '08'; break;
				case 'set': $return = '09'; break;
				case 'out': $return = '10'; break;
				case 'nov': $return = '11'; break;
				case 'dez': $return = '12'; break;
			}
			return $return;
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
						document.getElementById('".$img."').src = '../temp/img_null.png';
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
		function uploadImg($img)
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
			$new_width = 100;
			$new_height = 100;
			
			$image_p = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($image_p, $img2, 0, 0, 0, 0, $new_width, $new_height, $x, $y);
			
			if($ext[1] == 'png')
				imagepng($image_p, '../temp/'.$nmImg);
			else if(strtolower($ext[1]) == 'jpeg' || strtolower($ext[1]) == 'jpg')
				imagejpeg($image_p, '../temp/'.$nmImg);
			else if($ext[1] == 'gif')
				imagegif($image_p, '../temp/'.$nmImg);
			
			return $nmImg;
		}
	}
?>