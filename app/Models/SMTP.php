<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use PHPMailer\PHPMailer\PHPMailer;

class SMTP extends Model
{
	public function SMTP(){
		
		require base_path("vendor/autoload.php");
		$mail = new PHPMailer(true);
		
		$mail->SMTPDebug = 0;
		$mail->isSMTP();
		$mail->Host = env('MAIL_HOST');
		$mail->SMTPAuth = true;
		$mail->Username = env('MAIL_USERNAME');
		$mail->Password = env('MAIL_PASSWORD');
		$mail->SMTPSecure = env('MAIL_ENCRYPTION');
		$mail->Port = env('MAIL_PORT');
		$mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
		
		return $mail;
	}
}
