<?
	if( ! defined("_VEIDER_FUNCTIONS_"))
	{
		define("_VEIDER_FUNCTIONS_", 1);
		
		function sendMail($mailProperties = array())
		{
			$mailProperties['headers'] = 
				"From: veider.reservas@gmail.com"."\r\n".
				"Reply-To: veider.reservas@gmail.com"."\r\n".
				"X-Mailer: PHP/" . phpversion();
			
			$mailSent = mail($mailProperties['to'], $mailProperties['subject'], $mailProperties['message'], $mailProperties['headers']);
			
			return $mailSent;
		}
		
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
		
		function verifyFormatImg($file,$img,$default)
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
				
					if(valid_ext == true){
						if(document.getElementById('".$img."'))
							document.getElementById('".$img."').src = document.getElementById('".$file."').value;
					}
					else
					{
						var lastFile = document.getElementById('".$file."');
						var cleanFile = lastFile.cloneNode(true);
						lastFile.parentNode.replaceChild(cleanFile, lastFile);
						if(document.getElementById('".$img."'))
							document.getElementById('".$img."').src = '../../temp/".$default."';
						alert('Erro referente a extenção do arquivo');
					}
				}
			";
		}
		
		/*
		*   Cria div de carregando
		*/
		function loading()
		{
			echo "
				<div id='dvLoading' name='dvLoading' class='dvLoading' style='overflow:hidden; z-index:50;'>
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
		
		function userBlock($col, $row) {
			if($col == 1 && $row['actcode'] == null)
				return "<img src='../../image/list_icon/inactive.png' title='Bloqueado'/>";
			else
				return "";
		}
		
		function objectCondition($col, $row){
			if($col == 1)
				return "<img src='../../image/list_icon/bom.png' title='Bom'/>";
			else if($col == 2)
				return "<img src='../../image/list_icon/regular.png' title='Regular'/>";
			else if($col == 3)
				return "<img src='../../image/list_icon/ruim.png' title='Ruim'/>";
			else
				return "";
		}
		
		/*
		*  Cria array de horas ( [0] => 00:00 - [23] => 23:00 )
		*/
		function makeHours($st = 0,$end = 24)
		{
			$arrayHours = array(); 
			for($key = $st; $key < $end; $key++)
				{
					if($key < 10)
						$arrayHours[$key] = "0".$key.":00";
					else
						$arrayHours[$key] = $key.":00";
				}
			
			return $arrayHours;
		}
		
		/*
		*	Retorna string criptografada
		*
		*	@param	string	$key		chave para criptografar
		*	@param	string	$value	valor a ser criptografado
		*/
		function encrypt($key, $value)
		{
			$key = md5($key);
			$encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $value, MCRYPT_MODE_ECB);
			$encrypted = base64_encode($encrypted);
			
			return $encrypted;
		}
		
		/*
		*	Retorna string descriptografada
		*
		*	@param string $key	chave para descriptografar
		*	@param string $value	valor criptografado
		*
		*	@warning
		*		a chave deve ser a mesma que foi usada para criptografar
		*/
		function decrypt($key, $value)
		{
			$key = md5($key);
			$decrypted = base64_decode($value);
			$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decrypted, MCRYPT_MODE_ECB);
			
			return $decrypted;
		}
	}
?>