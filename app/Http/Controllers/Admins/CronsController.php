<?php
namespace App\Http\Controllers\Admins;
 
use Hash;
use Session;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider; 
use Illuminate\Http\Request;
use App\Http\Requests; 
use App\Item;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\SmtpEmails;
use App\Models\SmtpEmailsMime;
use App\Models\FileEmails;
use App\Models\FileUpload;
use App\Models\City;

use Illuminate\Support\Facades\Mail;

use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;
 
class CronsController extends Controller{

	public function sendNormalBulkEmail(Request $request){
		require base_path("vendor/autoload.php");
       	$mail = new PHPMailer(true);
				
		$emailData = SmtpEmails::where('id',$request->input('camp_id'))->first();
		if(isset($emailData->file_id) && !empty($emailData->file_id)){
			$fileData = FileUpload::where('uid',$emailData->file_id)->first();
			if(isset($fileData->id) && !empty($fileData->id)){
				$emails = FileEmails::where('file_id',$fileData->id)->where('send_mark',2)->orderBy('id','ASC')->paginate(10);
				foreach($emails as $key => $email){
					if(filter_var($email->email, FILTER_VALIDATE_EMAIL)){
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
							$mail->addAddress(trim($email->email));
							if($emailData->type == 'Html'){
								$mail->isHTML(true);
							}
							$mail->Subject = $emailData->subject;
							$mail->Body    = $emailData->body;
							$mail->send();
							/*if( !$mail->send() ) {
								return back()->with('error',$mail->ErrorInfo);
							}*/
							FileEmails::where('id',$email->id)->update(['send_mark' => 1]);
						}catch (Exception $e) {
							 //return back()->with('error',$e->getMessage());
						}
					}
				}
				$processState = 1;
				if($request->input('total_page') == $request->input('page')){
					$processState = 5;
				}
				SmtpEmails::where('id',$request->input('camp_id'))->update(['process' => $processState, 'total_page' => $request->input('total_page'),'page' => $request->input('page')]);
				echo 'Success'; die;
			}else{
				echo 'File Data Not Found'; die;
			}
		}else{
			echo 'Error'; die;
		}
		
	}
	public function sendAutoBulkEmail(Request $request){
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
						$mail->addAddress(trim($allEmail['email']));
						if($emailData->type == 'Html'){
							$mail->isHTML(true);
						}
						$mail->Subject = $emailData->subject;
						$mail->Body = $emailData->body;
						$mail->send();
						
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
							$mail->addAddress(trim($allEmail['email']));
							if($emailData->type == 'Html'){
								$mail->isHTML(true);
							}
							$mail->Subject = $emailData->subject;
							$mail->Body = $emailData->body;
							$mail->send();
							
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