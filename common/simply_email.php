<?php
/**
* 
*/
class clsSimplyEmail
{	

	private $_mail;
	private $_defaultFrom;
	private $_Host;
	private $_SMTPAuth;
	private $_Port;
	private $_Username;
	private $_Password;
	
	function clsSimplyEmail()
	{
		$this->_mail = new PHPMailer();
		$this->_Host = 'mail.tamboapp.com';
	    $this->_SMTPAuth = true;
	    $this->_Port = 25;
	    $this->_Username = 'info@tamboapp.com';
	    $this->_Password = 'lm03051971';
	    $this->_SMTPSecure = 'tls';
	}

	function EnvioEmail($from, $to, $subject, $message, $attachedFiles = false, $embeddedFiles = false)
	{
	    $mail = $this->_mail;

	    $mail->isSMTP();
        $mail->Host = $this->_Host;
        $mail->SMTPAuth = $this->_SMTPAuth;
        $mail->Host = $this->_Host;
        $mail->Port = $this->_Port;
        $mail->Username = $this->_Username;
        $mail->Password = $this->_Password;
        $mail->SMTPSecure = $this->_SMTPSecure;

	    $mail->setFrom($from);

	    if (is_array($to)){
	        foreach ($to as $email) {
	            $mail->addAddress($email);
	        }
	    }
	    else
	        $mail->addAddress($to);

	    $mail->isHTML(true);

	    $mail->Subject = $subject;
	    $mail->Body    = $message;

	    if (!$mail->send()){
	        $errorinfo = $mail->ErrorInfo;
	        $success = 0;
	    }
	    else {
	        $errorinfo = 'OK';
	        $success = 1;
	    }

	    $mail->ClearAddresses();
	    $mail->smtpClose();

	    $result = array(
	    	'errorinfo' => $errorinfo,
	    	'success' => $success
	    );

	    return $result;
	}
}
?>