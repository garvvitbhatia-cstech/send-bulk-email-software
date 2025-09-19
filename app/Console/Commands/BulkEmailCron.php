<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Models\SmtpEmails;
use App\Models\SmtpEmailsMime;
use App\Models\FileEmails;
use App\Models\FileUpload;
use App\Models\City;

use Illuminate\Support\Facades\Mail;

use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;

class BulkEmailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
		$checkCount = SmtpEmails::where('run_mode','Auto')->where('mode','Bulk')->where('running_process',1)->count();
		if($checkCount == 0){
			$emailData = SmtpEmails::where('run_mode','Auto')->where('mode','Bulk')->whereIn('process',[1,3])->first();
			if(isset($emailData->id)){
				SmtpEmails::where('id',$emailData->id)->update(['running_process' => 1]);
				$allEmails = FileEmails::select('id','email')->where('file_uid',$emailData->file_id)->where('send_mark',2)->orderBy('id','ASC')->take($emailData->send_limit)->get()->toArray();	
				
				foreach($allEmails as $key => $allEmail){
					
					require base_path("vendor/autoload.php");
       				$mail = new PHPMailer(true);
					
					try {
						$mail->SMTPDebug = 0;
						$mail->isSMTP();
						$mail->Host = $emailData->server;
						$mail->SMTPAuth = true;
						$mail->Username = trim($emailData->user);
						$mail->Password = trim($emailData->password);
						$mail->SMTPSecure = trim($emailData->tls);
						$mail->Port = trim($emailData->port);
						$mail->setFrom(trim($emailData->from_email), trim($emailData->from_name));
						$mail->MessageID = "<" . md5('NITAM'.(idate("U")-1000000000)).'@'.$emailData->message_id.'>';
						$mail->addAddress(trim($allEmail['email']));
						if($emailData->type == 'Html'){
							$mail->isHTML(true);
						}
						$mail->Subject = $emailData->subject;
						$mail->Body = $emailData->body;
						$mail->send();
						$mail->ClearAllRecipients();
						
					}catch (Exception $e) {
						 //return back()->with('error',$e->getMessage());
					}
					
					FileEmails::where('id',$allEmail['id'])->update(['send_mark' => 1]);
				}
				echo 'Success'; die;
				
			}else{
				echo 'No campaign exist'; die;
			}
		}else{
			$emailData = SmtpEmails::where('run_mode','Auto')->where('mode','Bulk')->where('running_process',1)->whereIn('process',[1,3])->first();
			if(isset($emailData->id)){
				
				$allEmails = FileEmails::select('id','email')->where('file_uid',$emailData->file_id)->where('send_mark',2)->orderBy('id','ASC')->take($emailData->send_limit)->get()->toArray();	
				
				if(count($allEmails) > 0){
					foreach($allEmails as $key => $allEmail){
						
						require base_path("vendor/autoload.php");
       				    $mail = new PHPMailer(true);
						
						try {
							$mail->SMTPDebug = 0;
							$mail->isSMTP();
							$mail->Host = $emailData->server;
							$mail->SMTPAuth = true;
							$mail->Username = trim($emailData->user);
							$mail->Password = trim($emailData->password);
							$mail->SMTPSecure = trim($emailData->tls);
							$mail->Port = trim($emailData->port);
							$mail->setFrom(trim($emailData->from_email), trim($emailData->from_name));
							$mail->MessageID = "<" . md5('NITAM'.(idate("U")-1000000000)).'@'.$emailData->message_id.'>';
							$mail->addAddress(trim($allEmail['email']));
							if($emailData->type == 'Html'){
								$mail->isHTML(true);
							}
							$mail->Subject = $emailData->subject;
							$mail->Body = $emailData->body;
							$mail->send();
							$mail->ClearAllRecipients();
							
						}catch (Exception $e) {
							 //return back()->with('error',$e->getMessage());
						}
						
						FileEmails::where('id',$allEmail['id'])->update(['send_mark' => 1]);
					}
					
					echo 'Success'; die;
				
				}else{
					SmtpEmails::where('id',$emailData->id)->update(['process' => 5,'running_process' => 2]);
					echo 'Campaign completed'; die;
				}
				
				
			}else{
				echo 'No campaign exist'; die;
			}
			
		}
	}
	
}
