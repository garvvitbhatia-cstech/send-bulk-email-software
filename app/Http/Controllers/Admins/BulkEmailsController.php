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
use App\Models\SendGridEmails;
use App\Models\SmtpEmails;
use App\Models\SmtpEmailsMime;
use App\Models\FileEmails;
use App\Models\FileUpload;

use Illuminate\Support\Facades\Mail;

use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;
 
class BulkEmailsController extends Controller{

	public function sendGridEmails(Request $request){
		$conditions = array('mode' => 'Bulk');
		$cond = array();
		if($request->input('type') != ''){
			$cond['type'] = array('type', $request->input('type'));
		}
		$i = 0;
		foreach($cond as $value){
			$conditions[$i] = $value;
			$i++;
		}
		$pages = SendGridEmails::where($conditions)->latest()->paginate(PAGE_LIMIT);	
		return view('admins.bulk_emails.send_grid_emails',compact('pages'));
	}

	public function addSendgridEmail(Request $request){
		$postData = $request->all();
		if(!empty($postData)){
			$request->validate([
				'run_mode' => 'required',
				'time_to_send' => $request->input('run_mode') === 'Auto' ? 'required|numeric': 'nullable',
				'limit_to_send' => $request->input('run_mode') === 'Auto' ? 'required|numeric': 'nullable',
				'mode' => 'required',				
				'subject' => 'required',
				'from_name' => 'required',
				'from_email' => 'required|email',
				'type' => 'required',
				'body' => 'required',
				'file_id' => $request->input('mode') === 'Bulk' ? 'required': 'nullable',
				'sendgrid_api_key' => 'required'
			],[
				'run_mode.required' => 'Please enter run mode',
				'time_to_send.required' => 'Please enter time to send',
				'time_to_send.numeric' => 'Please enter valid time to send',
				'limit_to_send.required' => 'Please enter limit to send',
				'limit_to_send.numeric' => 'Please enter valid limit to send',
				'mode.required' => 'Please enter mode',
				'message_id.required' => 'Please enter message ID',
				'subject.required' => 'Please enter subject',
				'from_name.required' => 'Please enter from name',
				'from_email.required' => 'Please enter email',
				'from_email.email' => 'Please enter valid email',
				'test_email_recepients.required' => 'Please enter valid email',
				'type.required' => 'Please enter type',
				'body.required' => 'Please enter body',
				'file_id.required' => 'Please enter file ID',
				'sendgrid_api_key.required' => 'Please enter sedgrid API key'
			]);
			
			$status = 0;
			if(isset($request->status)){
				$status = 1;	
			}
			$email = new SendGridEmails;
			$email->run_mode = $request->run_mode;
			$email->time_to_send = $request->time_to_send;
			$email->limit_to_send = $request->limit_to_send;
			$email->test_mail_bulk_count = $request->test_mail_bulk_count;
			$email->mode = $request->mode;
			$email->message_id = $request->input('message_id');
			$email->subject = $request->subject;
			$email->from_name = $request->from_name;
			$email->from_email = $request->from_email;
			$email->test_email_recepients = $request->test_email_recepients;
			$email->type = $request->type;
			$email->body = $request->body;
			$email->sendgrid_limit = $request->sendgrid_limit;
			$email->file_id = $request->file_id;
			$email->sendgrid_api_key = $request->sendgrid_api_key;
			$email->status = $status;
			$email->save();
			if($request->input('page_action') == 'edit'){
				return redirect('admins/edit-send-grid-email/'.Crypt::encrypt($email->id))->with('success','Sendgrid emails has been created successfully');
			}else{
				return redirect('admins/send-grid-emails')->with('success','Sendgrid emails has been created successfully');
			}
		}
		return view('admins.bulk_emails.add_send_grid_emails');	
	}
	
	public function editSendGridEmail(Request $request, $id){
		$email = SendGridEmails::where('id',Crypt::decrypt($id))->first();				
		$postData = $request->all();
		if(!empty($postData)){
			$request->validate([
				'run_mode' => 'required',
				'time_to_send' => $request->input('run_mode') === 'Auto' ? 'required|numeric': 'nullable',
				'limit_to_send' => $request->input('run_mode') === 'Auto' ? 'required|numeric': 'nullable',
				'mode' => 'required',
				'subject' => 'required',
				'from_name' => 'required',
				'from_email' => 'required|email',
				'type' => 'required',
				'body' => 'required',
				'file_id' => $request->input('mode') === 'Bulk' ? 'required': 'nullable',
				'sendgrid_api_key' => 'required'
			],[
				'run_mode.required' => 'Please enter run mode',
				'time_to_send.required' => 'Please enter time to send',
				'time_to_send.numeric' => 'Please enter valid time to send',
				'limit_to_send.required' => 'Please enter limit to send',
				'limit_to_send.numeric' => 'Please enter valid limit to send',
				'mode.required' => 'Please enter mode',
				'message_id.required' => 'Please enter message ID',
				'subject.required' => 'Please enter subject',
				'from_name.required' => 'Please enter from name',
				'from_email.required' => 'Please enter email',
				'from_email.email' => 'Please enter valid email',
				'test_email_recepients.required' => 'Please enter valid email',
				'type.required' => 'Please enter type',
				'body.required' => 'Please enter body',
				'file_id.required' => 'Please enter file ID',
				'sendgrid_api_key.required' => 'Please enter sedgrid API key'
			]);
			
			$status = 0;
			if(isset($request->status)){
				$status = 1;	
			}			
			$email = SendGridEmails::find($email->id);
			$email->run_mode = $request->run_mode;
			$email->time_to_send = $request->time_to_send;
			$email->limit_to_send = $request->limit_to_send;
			$email->test_mail_bulk_count = $request->test_mail_bulk_count;
			$email->mode = $request->mode;
			$email->message_id = $request->input('message_id');
			$email->subject = $request->subject;
			$email->from_name = $request->from_name;
			$email->from_email = $request->from_email;
			$email->test_email_recepients = $request->test_email_recepients;
			$email->type = $request->type;
			$email->body = $request->body;
			$email->sendgrid_limit = $request->sendgrid_limit;
			$email->file_id = $request->file_id;
			$email->sendgrid_api_key = $request->sendgrid_api_key;
			$email->status = $status;
			$email->save();
			return back()->with('success','Sendgrid emails has been updated successfully');
		}
		
		if(!empty($email)){
			return view('admins.bulk_emails.edit_send_grid_emails',compact('email'));
		}else{
			return redirect('admins/send-grid-emails');
		}
		
	}
	
	public function smtpEmails(Request $request){
		$conditions = array('mode' => 'Bulk','run_mode' => 'Auto');
		$cond = array();
		if($request->input('type') != ''){
			$cond['type'] = array('type', $request->input('type'));
		}
		$i = 0;
		foreach($cond as $value){
			$conditions[$i] = $value;
			$i++;
		}
		$pages = SmtpEmails::where($conditions)->latest()->paginate(PAGE_LIMIT);	
		return view('admins.bulk_emails.smtp_emails',compact('pages'));
	}
	
	public function smtpEmailsPaninate(Request $request){
		$conditions = array('mode' => 'Bulk','run_mode' => 'Auto');
		$cond = array();
		if($request->input('type') != ''){
			$cond['type'] = array('type', $request->input('type'));
		}
		$i = 0;
		foreach($cond as $value){
			$conditions[$i] = $value;
			$i++;
		}
		$pages = SmtpEmails::where($conditions)->latest()->paginate(PAGE_LIMIT);	
		return view('admins.bulk_emails.smtp_emails_paginate',compact('pages'));
	}

	public function addSmtpEmail(Request $request){
    
		$postData = $request->all();
		if(!empty($postData)){	
			$request->validate([
				'server' => 'required',
				'port' => 'required',
				'user' => 'required',
				'password' => 'required',
				'run_mode' => 'required',
				'time_to_send' => $request->input('run_mode') === 'Auto' ? 'required|numeric': 'nullable',
				'limit_to_send' => $request->input('run_mode') === 'Auto' ? 'required|numeric': 'nullable',
				'mode' => 'required',
				'subject' => 'required',
				'from_name' => 'required',
				'from_email' => 'required|email',
				'type' => 'required',
				'body' => 'required',
				'file_id' => $request->input('mode') === 'Bulk' ? 'required': 'nullable'
			],[
				'server.required' => 'Please enter server',
				'port.required' => 'Please enter port',
				'user.required' => 'Please enter user',
				'password.required' => 'Please enter password',
				'run_mode.required' => 'Please enter run mode',
				'message_id.required' => 'Please enter message ID',
				'time_to_send.required' => 'Please enter time to send',
				'time_to_send.numeric' => 'Please enter valid time to send',
				'limit_to_send.required' => 'Please enter limit to send',
				'limit_to_send.numeric' => 'Please enter valid limit to send',
				'mode.required' => 'Please enter mode',
				'message_id.required' => 'Please enter message ID',
				'subject.required' => 'Please enter subject',
				'from_name.required' => 'Please enter from name',
				'from_email.required' => 'Please enter email',
				'from_email.email' => 'Please enter valid email',
				'test_email_recepients.required' => 'Please enter valid email',
				'type.required' => 'Please enter type',
				'body.required' => 'Please enter body',
				'file_id.required' => 'Please enter file ID'
			]);
			
			$status = 0;
			if(isset($request->status)){
				$status = 1;	
			}
			$email = new SmtpEmails;
			$email->server = $request->input('server');
			$email->port = $request->input('port');
			$email->user = $request->input('user');
			$email->tls = $request->input('tls');
			$email->message_id = $request->input('message_id');
			$email->password = $request->input('password');
			$email->tmp_password = $request->input('password');
			$email->run_mode = $request->input('run_mode');
			$email->send_time = $request->input('time_to_send');
			$email->send_limit = $request->input('limit_to_send');
			$email->test_mail_bulk_count = $request->input('test_mail_bulk_count');
			$email->mode = $request->input('mode');
			$email->subject = $request->input('subject');
			$email->from_name = $request->input('from_name');
			$email->from_email = $request->input('from_email');
			$email->test_email_recepients = $request->input('test_email_recepients');
			$email->type = $request->input('type');
			$email->body = $request->input('body');
			$email->smtp_limit = $request->input('smtp_limit');	
			$email->file_id = $request->input('file_id');
			$email->status = $status;
			$email->save();
			if($request->input('page_action') == 'edit'){
				return redirect('admins/edit-smtp-email/'.Crypt::encrypt($email->id))->with('success','Smtp email has been created successfully');
			}else{
				return redirect('admins/smtp-emails')->with('success','Smtp email has been created successfully');				
			}
		}
		return view('admins.bulk_emails.add_smtp_emails');	
	}
	
	public function editSmtpEmail(Request $request, $id){
		$email = SmtpEmails::where('id',Crypt::decrypt($id))->first();
		$postData = $request->all();
		if(!empty($postData)){
			$request->validate([
				'server' => 'required',
				'port' => 'required',
				'user' => 'required',
				'password' => 'required',
				'run_mode' => 'required',
				'time_to_send' => $request->input('run_mode') === 'Auto' ? 'required|numeric': 'nullable',
				'limit_to_send' => $request->input('run_mode') === 'Auto' ? 'required|numeric': 'nullable',
				'mode' => 'required',
				'subject' => 'required',
				'from_name' => 'required',
				'from_email' => 'required|email',
				'type' => 'required',
				'body' => 'required',
				'file_id' => $request->input('mode') === 'Bulk' ? 'required': 'nullable'
			],[
				'server.required' => 'Please enter server',
				'port.required' => 'Please enter port',
				'user.required' => 'Please enter user',
				'password.required' => 'Please enter password',
				'run_mode.required' => 'Please enter run mode',
				'time_to_send.required' => 'Please enter time to send',
				'time_to_send.numeric' => 'Please enter valid time to send',
				'limit_to_send.required' => 'Please enter limit to send',
				'limit_to_send.numeric' => 'Please enter valid limit to send',
				'mode.required' => 'Please enter mode',
				'message_id.required' => 'Please enter message ID',
				'subject.required' => 'Please enter subject',
				'from_name.required' => 'Please enter from name',
				'from_email.required' => 'Please enter email',
				'from_email.email' => 'Please enter valid email',
				'test_email_recepients.required' => 'Please enter valid email',
				'type.required' => 'Please enter type',
				'body.required' => 'Please enter body',
				'file_id.required' => 'Please enter file ID'
			]);
			
			$status = 0;
			if(isset($request->status)){
				$status = 1;	
			}
			$email = SmtpEmails::find($email->id);
			$email->server = $request->input('server');
			$email->port = $request->input('port');
			$email->user = $request->input('user');
			$email->tls = $request->input('tls');
			$email->message_id = $request->input('message_id');
			$email->password = $request->input('password');
			$email->tmp_password = $request->input('password');
			$email->run_mode = $request->input('run_mode');
			$email->send_time = $request->input('time_to_send');
			$email->send_limit = $request->input('limit_to_send');
			$email->test_mail_bulk_count = $request->input('test_mail_bulk_count');
			$email->mode = $request->input('mode');
			$email->subject = $request->input('subject');
			$email->from_name = $request->input('from_name');
			$email->from_email = $request->input('from_email');
			$email->test_email_recepients = $request->input('test_email_recepients');
			$email->type = $request->input('type');
			$email->body = $request->input('body');
			$email->smtp_limit = $request->input('smtp_limit');	
			$email->file_id = $request->input('file_id');
			$email->status = $status;
			$email->save();
			
			#send email
			$sendTestEmail = false;
			$emailData = SmtpEmails::find($email->id);
			if($emailData->run_mode == 'Normal' && $emailData->mode == 'Bulk'){
				require base_path("vendor/autoload.php");
       	 		$mail = new PHPMailer(true);
				$allEmails = FileEmails::select('id','email')->where('file_uid',$emailData->file_id)->where('send_mark',2)->orderBy('id','ASC')->take($emailData->smtp_limit)->get()->toArray();	
				foreach($allEmails as $key => $allEmail){
					
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
						 return back()->with('error',$e->getMessage());
					}
					
					FileEmails::where('id',$allEmail['id'])->update(['send_mark' => 1]);
				}
				
				if($emailData->test_email_recepients != ""){
					$sendTestEmail = true;
				}

			}
			if($sendTestEmail || $emailData->mode == 'Test'){
				require base_path("vendor/autoload.php");
       	 		$mail = new PHPMailer(true);
				$explodeEmails = explode(',',$emailData->test_email_recepients);
				foreach($explodeEmails as $key => $email){
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
						$mail->addAddress(trim($email));
						if($emailData->type == 'Html'){
							$mail->isHTML(true);
						}
						$mail->Subject = $emailData->subject;
						$mail->Body    = $emailData->body;
						$mail->send();
						$mail->ClearAllRecipients();
					}catch (Exception $e) {
						 return back()->with('error',$e->getMessage());
					}
				}
				return back()->with('success','Email send successfully');
				
			}
						
		}
		
		if(!empty($email)){
			return view('admins.bulk_emails.edit_smtp_emails',compact('email'));
		}else{
			return redirect('admins/smtp-emails');
		}
		
	}
	
	public function smtpEmailsMime(Request $request){
		$conditions = array('mode' => 'Bulk');
		$cond = array();
		if($request->input('type') != ''){
			$cond['type'] = array('type', $request->input('type'));
		}
		$i = 0;
		foreach($cond as $value){
			$conditions[$i] = $value;
			$i++;
		}
		$pages = SmtpEmailsMime::where($conditions)->latest()->paginate(PAGE_LIMIT);	
		return view('admins.bulk_emails.smtp_mime_emails',compact('pages'));
	}

	public function addSmtpEmailMime(Request $request){
		$postData = $request->all();
		if(!empty($postData)){
			$request->validate([
				'server' => 'required',
				'port' => 'required',
				'user' => 'required',
				'password' => 'required',
				'run_mode' => 'required',
				'time_to_send' => $request->input('run_mode') === 'Auto' ? 'required|numeric': 'nullable',
				'limit_to_send' => $request->input('run_mode') === 'Auto' ? 'required|numeric': 'nullable',
				'mode' => 'required',
				'subject' => 'required',
				'from_name' => 'required',
				'from_email' => 'required|email',
				'type' => 'required',
				'body' => 'required', 
				'file_id' => $request->input('mode') === 'Bulk' ? 'required': 'nullable'
			],[
				'server.required' => 'Please enter server',
				'port.required' => 'Please enter port',
				'user.required' => 'Please enter user',
				'password.required' => 'Please enter password',
				'run_mode.required' => 'Please enter run mode',
				'time_to_send.required' => 'Please enter time to send',
				'time_to_send.numeric' => 'Please enter valid time to send',
				'limit_to_send.required' => 'Please enter limit to send',
				'limit_to_send.numeric' => 'Please enter valid limit to send',
				'mode.required' => 'Please enter mode',
				'message_id.required' => 'Please enter message ID',
				'subject.required' => 'Please enter subject',
				'from_name.required' => 'Please enter from name',
				'from_email.required' => 'Please enter email',
				'from_email.email' => 'Please enter valid email',
				'test_email_recepients.required' => 'Please enter valid email',
				'type.required' => 'Please enter type',
				'body.required' => 'Please enter body', 
				'file_id.required' => 'Please enter file ID'
			]);
						
			$status = 0;
			if(isset($request->status)){
				$status = 1;	
			}
			$email = new SmtpEmailsMime;
			$email->server = $request->input('server');
			$email->port = $request->input('port');
			$email->user = $request->input('user');
			$email->tls = $request->input('tls');
			$email->password = $request->input('password');
			$email->tmp_password = $request->input('password');
			$email->run_mode = $request->input('run_mode');
			$email->send_time = $request->input('time_to_send');
			$email->send_limit = $request->input('limit_to_send');
			$email->test_mail_bulk_count = $request->input('test_mail_bulk_count');
			$email->mode = $request->input('mode');
			$email->message_id = $request->input('message_id');
			$email->subject = $request->input('subject');
			$email->from_name = $request->input('from_name');
			$email->from_email = $request->input('from_email');
			$email->test_email_recepients = $request->input('test_email_recepients');
			$email->type = $request->input('type');
			$email->body = $request->input('body');	 
			$email->file_id = $request->input('file_id');
			$email->smtp_limit = $request->input('smtp_limit');
			$email->status = $status;
			$email->save();
			if($request->input('page_action') == 'edit'){
				return redirect('admins/edit-smtp-email-mime/'.Crypt::encrypt($email->id))->with('success','Smtp email has been created successfully');
			}else{
				return redirect('admins/smtp-emails-mime')->with('success','Smtp email mime has been created successfully');		
			}			
		}
		return view('admins.bulk_emails.add_smtp_mime_emails');	
	}
	
	public function editSmtpEmailMime(Request $request, $id){
		$email = SmtpEmailsMime::where('id',Crypt::decrypt($id))->first();				
		$postData = $request->all();
		if(!empty($postData)){		
			$request->validate([
				'server' => 'required',
				'port' => 'required',
				'user' => 'required',
				'password' => 'required',
				'run_mode' => 'required',
				'time_to_send' => $request->input('run_mode') === 'Auto' ? 'required|numeric': 'nullable',
				'limit_to_send' => $request->input('run_mode') === 'Auto' ? 'required|numeric': 'nullable',
				'mode' => 'required',
				'subject' => 'required',
				'from_name' => 'required',
				'from_email' => 'required|email',
				'type' => 'required',
				'body' => 'required', 
				'file_id' => $request->input('mode') === 'Bulk' ? 'required': 'nullable'
			],[
				'server.required' => 'Please enter server',
				'port.required' => 'Please enter port',
				'user.required' => 'Please enter user',
				'password.required' => 'Please enter password',
				'run_mode.required' => 'Please enter run mode',
				'time_to_send.required' => 'Please enter time to send',
				'time_to_send.numeric' => 'Please enter valid time to send',
				'limit_to_send.required' => 'Please enter limit to send',
				'limit_to_send.numeric' => 'Please enter valid limit to send',
				'mode.required' => 'Please enter mode',
				'message_id.required' => 'Please enter message ID',
				'subject.required' => 'Please enter subject',
				'from_name.required' => 'Please enter from name',
				'from_email.required' => 'Please enter email',
				'from_email.email' => 'Please enter valid email',
				'test_email_recepients.required' => 'Please enter valid email',
				'type.required' => 'Please enter type',
				'body.required' => 'Please enter body', 
				'file_id.required' => 'Please enter file ID'
			]);
			
			$status = 0;
			if(isset($request->status)){
				$status = 1;	
			}
			$email = SmtpEmailsMime::find($email->id);
			$email->server = $request->input('server');
			$email->port = $request->input('port');
			$email->user = $request->input('user');
			$email->tls = $request->input('tls');
			$email->password = $request->input('password');
			$email->tmp_password = $request->input('password');
			$email->run_mode = $request->input('run_mode');
			$email->send_time = $request->input('time_to_send');
			$email->send_limit = $request->input('limit_to_send');
			$email->test_mail_bulk_count = $request->input('test_mail_bulk_count');
			$email->mode = $request->input('mode');
			$email->message_id = $request->input('message_id');
			$email->subject = $request->input('subject');
			$email->from_name = $request->input('from_name');
			$email->from_email = $request->input('from_email');
			$email->test_email_recepients = $request->input('test_email_recepients');
			$email->type = $request->input('type');
			$email->body = $request->input('body'); 
			$email->file_id = $request->input('file_id');
			$email->smtp_limit = $request->input('smtp_limit');
			$email->status = $status;
			$email->save();
			return back()->with('success','Smtp email mime has been updated successfully');		
		}
		
		if(!empty($email)){
			return view('admins.bulk_emails.edit_smtp_mime_emails',compact('email'));
		}else{
			return redirect('admins/smtp-emails-mime');
		}
		
	}
	
	public function upload(Request $request){			
		$postData = $request->all();
		if(!empty($postData)){
			$request->validate([
				'file' => 'file|required|mimetypes:txt,text/plain,text/html',
			],[
				'file.required' => 'Please select file',
				'file.mimetypes' => 'Please select text file',
			]);			
			if(!empty($request->file('file'))){
				$actual_image_name2 = sha1(str_shuffle(microtime(true).mt_rand(100001,999999)).uniqid(rand().true).$request->file('file')).'.'.$request->file->extension();
				$destination2 = base_path().'/public/assets/images/admin/gallery/';
				if($request->file->move($destination2, $actual_image_name2)){
					$file = new FileUpload;
					$file->file = $actual_image_name2;
					if($file->save()){
						$filename = $request->file('file')->getClientOriginalName();
						$uid = $this->getUniqueId($file->id);
						FileUpload::where('id', $file->id)->update(['uid' => $uid]);
						$file_path = base_path().'/public/assets/images/admin/gallery/'.$file->file;
						$total_records = $inserted_records = 0;
						if(file_exists($file_path)){
							$array = explode("\n", file_get_contents($file_path));
							if(count($array) > 0){								
								foreach($array as $key => $email){
									$total_records += 1;
									if(!empty($email)){
										$emails = new FileEmails;
										$emails->email = $email;
										$emails->file_id = $file->id;
										$emails->file_uid = $uid;
										$emails->save();
										
										$inserted_records += 1;
									}
								}
							}
						}
						$msg = 'The file '.$filename.' has been uploaded. File opened...'.$total_records.' record(s) read from file. '.$inserted_records.' record(s) inserted into database table.'. ' <br><br>File ID: <span style="font-size: 15px;">'.$uid.'</span>';
						return back()->with('success',$msg);
					}else{
						return back()->with('error','Error on upload file');
					}
				}else{
					return back()->with('error','Something went wrong');
				}
			}else{
				return redirect('admins/upload');
			}
		}
		return view('admins.bulk_emails.upload');
	}
	
	function getUniqueId($string){
		$length = 10;
		$rand = str_shuffle(mt_rand(11111,99999).mt_rand(11111,99999));
		return str_pad($string,$length,$rand, STR_PAD_LEFT);
	}
	
}