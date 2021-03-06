<?php 

/**
* 
*/
class Correo 
{
	
	//Atributos para el envio de correo (acceso privado)
	//private static $_userName = Config::get('config.mail.usermail'); // mail username
	//private static $_password = Config::get('config.mail.pass'); // mail password
	//private static $_from = 'Administrador del Sistema';
	//private static $_host = Config::get('config.mail.host');
	//private static $_port = Config::get('config.mail.port');

	/**
	 * Quien envia el Mail
	 * @var $fromName
	 */
	//public static $fromName = 'Administrador del Sistema';
	/**
	 * Asunto del Mail
	 * @var $subject
	 */
	//public static $subject = 'Envio de Clave de Acceso';

	/**
	 * Genera Claves aleatorias...
	 *
	 * @param int $length
	 */
	public static function generarClave($length)
	{
		$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
		$cad = '';
		for($i=0;$i<$length;$i++) {
			$cad .= substr($str,rand(0,62),1);
		}
		return $cad;
	}
	/**
	 * Envia un correo
	 *
	 * @param $mail
	 * @param $pass
	 * @param $body
	 */
	public static function send($correo, $person, $body)
	{
		//Cargamos las librería PHPMailer
		Load::lib('PHPMailer/class.phpmailer');
		Load::lib('PHPMailer/class.smtp');
		//instancia de PHPMailer
		$mail = new PHPMailer();

		$mail->IsSMTP();
		$mail->SMTPAuth = true; // enable SMTP authentication
		// $mail->SMTPSecure = 'ssl'; // sets the prefix to the servier
		$mail->Host = self::$_host; // sets Soluciones SL as the SMTP server
		$mail->Port = self::$_port; // set the SMTP port for the Soluciones SL server
		$mail->Username = self::$_userName;
		$mail->Password = self::$_password;
		$mail->AddReplyTo(self::$_from, 'Administrador del Sistema');
		$mail->From = self::$_from;
		$mail->FromName = 'Administrador del Sistema';
		$mail->Subject = 'Envío de clave de acceso';
		$mail->Body = $body;
		$mail->WordWrap = 50; // set word wrap
		$mail->MsgHTML($body);
		$mail->AddAddress($correo, $person);
		$mail->IsHTML(true); // send as HTML

		//Enviamos el correo
		$exito = $mail->Send();
		$intentos = 1;
		//esto se realizara siempre y cuando la variable $exito contenga como valor false
		while ((!$exito) && $intentos < 1){
			sleep(5);
			$exito = $mail->Send();
			$intentos = $intentos +1;
		}
		return $exito;
	}

		public static function newsletter($correo)
	{
		//Cargamos las librería PHPMailer
		Load::lib('PHPMailer/class.phpmailer');
		Load::lib('PHPMailer/class.smtp');
		//instancia de PHPMailer
		$mail = new PHPMailer();

		$mail->IsSMTP();
		$mail->SMTPAuth = true; // enable SMTP authentication
		// $mail->SMTPSecure = 'ssl'; // sets the prefix to the servier
		$mail->Host = self::$_host; // sets Soluciones SL as the SMTP server
		$mail->Port = self::$_port; // set the SMTP port for the Soluciones SL server
		$mail->Username = self::$_userName;
		$mail->Password = self::$_password;
		$mail->AddReplyTo(self::$_from, 'Administrador del Sistema');
		$mail->From = self::$_from;
		$mail->FromName = 'Administrador del Sistema';
		$mail->Subject = 'Bienvenido a Telcorp';
		//$mail->Body = $body;
		$mail->WordWrap = 50; // set word wrap
		$mail->MsgHTML(file_get_contents('mail/contents.html'), dirname(__FILE__));
		$mail->AddAddress($correo);
		$mail->IsHTML(true); // send as HTML
		$mail->addAttachment('download/brochure_telcorp_2014.pdf');

		//Enviamos el correo
		$exito = $mail->Send();
		$intentos = 1;
		//esto se realizara siempre y cuando la variable $exito contenga como valor false
		while ((!$exito) && $intentos < 1){
			sleep(5);
			$exito = $mail->Send();
			$intentos = $intentos +1;
		}
		return $exito;
	}


	/**
	 * Envia un correo
	 *
	 * @param $mail
	 * @param $pass
	 * @param $body
	 */
	public static function sendContact($correo, $person, $telf, $body)
	{
		//Cargamos las librería PHPMailer
		Load::lib('PHPMailer/class.phpmailer');
		Load::lib('PHPMailer/class.smtp');
		//Load::lib('PHPMailer/PHPMailerAutoload');
		//instancia de PHPMailer
		$mail = new PHPMailer();

		$mail->IsSMTP();
		//$mail->SMTPDebug = 2;
		//$mail->Debugoutput = 'html';
		
		$mail->SMTPAuth = true; // enable SMTP authentication
		//$mail->SMTPSecure = 'ssl'; // sets the prefix to the servier
		$mail->Host = Config::get('config.mail.host'); // sets Soluciones SL as the SMTP server
		$mail->Port = Config::get('config.mail.port'); // set the SMTP port for the Soluciones SL server
		$mail->Username = Config::get('config.mail.usermail');
		$mail->Password = Config::get('config.mail.pass');
		$mail->AddReplyTo($correo, $person);
		$mail->From = $correo;
		$mail->FromName = $person;
		$mail->Subject =  'Contacto desde la web Formulario de Contacto';
		$mail->Body = "Telf.: " . $telf .  "r\n\r\nMessage.: " . stripslashes($body);
		$mail->WordWrap = 50; // set word wrap
		$mail->MsgHTML("<strong>Name.: </strong>" . $person . "\r\n\r\n <p><strong>Mail.: </strong>" . $correo . "\r\n\r\n <p><strong>Telf.: </strong>" . $telf . "\r\n\r\n <p><strong>Message.: </strong><br>" . stripslashes($body));
		$mail->AddAddress('admin@solucionessl.com.ve', 'Administrador del Sistema');
		$mail->IsHTML(true); // send as HTML

		//Enviamos el correo
		$exito = $mail->Send();
		$intentos = 1;
		//esto se realizara siempre y cuando la variable $exito contenga como valor false
		while ((!$exito) && $intentos < 1){
			sleep(5);
			$exito = $mail->Send();
			$intentos = $intentos +1;
		}
		return $exito;
	}

	public static function sendJoin($correo, $person, $telf, $body)
	{
		//Cargamos las librería PHPMailer
		Load::lib('PHPMailer/class.phpmailer');
		Load::lib('PHPMailer/class.smtp');
		//instancia de PHPMailer
		$mail = new PHPMailer();

		$mail->IsSMTP();
		$mail->SMTPAuth = true; // enable SMTP authentication
		//$mail->SMTPSecure = 'ssl'; // sets the prefix to the servier
		$mail->Host = self::$_host; // sets Soluciones SL as the SMTP server
		$mail->Port = self::$_port; // set the SMTP port for the Soluciones SL server
		$mail->Username = self::$_userName;
		$mail->Password = self::$_password;
		$mail->AddReplyTo($correo, $person);
		$mail->From = $correo;
		$mail->FromName = $person;
		$mail->Subject =  'Contacto desde el Formulario Unete a Nosotros';
		$mail->Body = "Telf.: " . $telf .  "r\n\r\nMessage.: " . stripslashes($body);
		$mail->WordWrap = 50; // set word wrap
		$mail->MsgHTML("<strong>Name.: </strong>" . $person . "\r\n\r\n <p><strong>Mail.: </strong>" . $correo . "\r\n\r\n <p><strong>Telf.: </strong>" . $telf . "\r\n\r\n <p><strong>Message.: </strong><br>" . stripslashes($body));
		$mail->AddAddress('no-responder@solucionessl.com.ve', 'Administrador del Sistema');
		$mail->IsHTML(true); // send as HTML

		//Enviamos el correo
		$exito = $mail->Send();
		$intentos = 1;
		//esto se realizara siempre y cuando la variable $exito contenga como valor false
		while ((!$exito) && $intentos < 1){
			sleep(5);
			$exito = $mail->Send();
			$intentos = $intentos +1;
		}
		return $exito;
	}

}