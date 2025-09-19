@extends('layout.admin')
@section('title', 'Add Smtp Email')
@section('content')
<section class="content" style="margin: 64px 15px 0 0;">
  <div class="container-fluid">
    <div class="block-header">
      <h2>Add Smtp Email</h2>
    </div>
    <!-- Input -->
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="">
          <div class="body">
            <div class="row clearfix">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card"> @include('../flash-message')
                  <div class="body"> {{ Form::open(array('url' => array('/admins/add-smtp-email'),'id' => 'pageForm', 'method' => 'post', 'files' => true)) }}
                    @csrf
                    <div style="overflow: hidden;">
                    	<input type="hidden" id="page_action" name="page_action" value="edit"/>
                      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                      
                       <div class="row clearfix">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group form-float">
                    <label class="form-label">Server <span style="color:#F00">*</span></label>
                    <div class="form-line">
                    <input type="text" id="server" name="server" onkeyup="checkError(this.id);" value="{{old('server')}}" confirmation="false" class="form-control">
                    </div>
                    @error('server')
                    <label id="server-error" class="error" for="server">{{ $message }}</label>
                    @enderror </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><div class="form-group form-float">
                          <label class="form-label">User <span style="color:#F00">*</span></label>
                          <div class="form-line">
                            <input type="text" id="user" name="user" onkeyup="checkError(this.id);" value="{{old('user')}}" confirmation="false" class="form-control">
                          </div>
                          @error('user')
                          <label id="user-error" class="error" for="user">{{ $message }}</label>
                          @enderror </div></div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><div class="form-group form-float">
                          <label class="form-label">Password <span style="color:#F00">*</span></label>
                          <div class="form-line">
                            <input type="text" id="password" name="password" onkeyup="checkError(this.id);" value="{{old('password')}}" confirmation="false" class="form-control">
                          </div>
                          @error('password')
                          <label id="password-error" class="error" for="password">{{ $message }}</label>
                          @enderror </div></div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><div class="form-group form-float">
                          <label class="form-label">Port <span style="color:#F00">*</span></label>
                          <div class="form-line">
                            <input type="text" id="port" name="port" onkeyup="checkError(this.id);" value="{{old('port')}}" confirmation="false" class="form-control">
                          </div>
                          @error('port')
                          <label id="port-error" class="error" for="port">{{ $message }}</label>
                          @enderror </div></div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><div class="form-group form-float">
                          <label class="form-label">TLS</label>
                          <div class="form-line">
                            <select name="tls" id="tls" onchange="checkError(this.id);" confirmation="false" class="form-control">
                              <option {{old('tls') == 'auto'?'selected':''}} value="auto">Auto</option>
                              <option {{old('tls') == 'none'?'selected':''}} value="none">None</option>
                              <option {{old('tls') == 'ssl'?'selected':''}} value="ssl">SSL</option>
                              <option {{old('tls') == 'tls'?'selected':''}} value="tls">TLS</option>
                            </select>
                          </div>
                          @error('tls')
                          <label id="tls-error" class="error" for="tls">{{ $message }}</label>
                          @enderror </div></div>
                    </div>
                      </div>
                      
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group form-float">
                          <label class="form-label">Run Mode <span style="color:#F00">*</span></label>
                          <div class="demo-radio-button form-line">
                            <input {{old('run_mode') == 'Normal'?'checked':''}} name="run_mode" type="radio" class="run_mode with-gap radio" value="Normal" id="normal" checked="checked">
                            <label for="normal">Normal</label>
                            <input {{old('run_mode') == 'Auto'?'checked':''}} name="run_mode" type="radio" value="Auto" class="run_mode with-gap radio" id="auto">
                            <label for="auto">Auto</label>
                          </div>
                        </div>
                        <div id="run_mode_div" style="display:none">
                          <div class="form-group form-float">
                            <label class="form-label">Time to Send (seconds): <span style="color:#F00">*</span></label>
                            <div class="form-line">
                              <input type="text" id="time_to_send" name="time_to_send" onkeyup="checkError(this.id);" value="{{old('time_to_send')}}" confirmation="false" class="form-control">
                            </div>
                            @error('time_to_send')
                            <label id="time_to_send-error" class="error" for="time_to_send">{{ $message }}</label>
                            @enderror </div>
                          <div class="form-group form-float">
                            <label class="form-label">Limit to Send (number) <span style="color:#F00">*</span></label>
                            <div class="form-line">
                              <input type="text" id="limit_to_send" name="limit_to_send" onkeyup="checkError(this.id);" value="{{old('limit_to_send')}}" confirmation="false" class="form-control">
                            </div>
                            @error('limit_to_send')
                            <label id="limit_to_send-error" class="error" for="limit_to_send">{{ $message }}</label>
                            @enderror </div>
                          <div class="form-group form-float">
                            <label class="form-label">Bulk Count For Test Mail</label>
                            <div class="form-line">
                              <input type="text" id="test_mail_bulk_count" name="test_mail_bulk_count" value="{{old('test_mail_bulk_count')}}" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                            </div>
                            @error('test_mail_bulk_count')
                            <label id="test_mail_bulk_count-error" class="error" for="test_mail_bulk_count">{{ $message }}</label>
                            @enderror </div>
                        </div>
                        
                      </div>
                      
                      
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="body">
                    <div class="form-group form-float">
                      <label class="form-label">Mode <span style="color:#F00">*</span></label>
                      <div class="demo-radio-button form-line">
                        <input {{old('mode') == 'Test'?'checked':''}} name="mode" type="radio" value="Test" class="with-gap radio" id="test" checked="checked">
                        <label for="test">Test </label>
                        <input {{old('mode') == 'Bulk'?'checked':''}} name="mode" value="Bulk" type="radio" class="with-gap radio" id="bulk">
                        <label for="bulk">Bulk</label>
                      </div>
                    </div>
                    
                    <div class="row clearfix">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group form-float">
                      <label class="form-label">Subject <span style="color:#F00">*</span></label>
                      <div class="form-line">
                        <input type="text" id="subject" name="subject" onkeyup="checkError(this.id);" value="{{old('subject')}}" confirmation="false" class="form-control">
                      </div>
                      @error('subject')
                      <label id="subject-error" class="error" for="subject">{{ $message }}</label>
                      @enderror </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><div class="form-group form-float">
                      <label class="form-label">Message ID</label>
                      <div class="form-line">
                        <input type="text" id="message_id" name="message_id" onkeyup="checkError(this.id);" value="{{old('message_id')}}" confirmation="false" class="form-control">
                      </div>
                      @error('message_id')
                      <label id="message_id-error" class="error" for="message_id">{{ $message }}</label>
                      @enderror </div></div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><div class="form-group form-float">
                      <label class="form-label">From (Name) <span style="color:#F00">*</span></label>
                      <div class="form-line">
                        <input type="text" id="from_name" name="from_name" onkeyup="checkError(this.id);" value="{{old('from_name')}}" confirmation="false" class="form-control">
                      </div>
                      @error('from_name')
                      <label id="from_name-error" class="error" for="from_name">{{ $message }}</label>
                      @enderror </div></div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><div class="form-group form-float">
                      <label class="form-label">From (Email) <span style="color:#F00">*</span></label>
                      <div class="form-line">
                        <input type="email" id="from_email" name="from_email" onkeyup="checkError(this.id);" value="{{old('from_email')}}" confirmation="false" class="form-control">
                      </div>
                      @error('from_email')
                      <label id="from_email-error" class="error" for="from_email">{{ $message }}</label>
                      @enderror </div></div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><div class="form-group form-float">
                      <label class="form-label">Test Email Recepients</label>
                      <div class="form-line">
                        <input type="text" id="test_email_recepients" name="test_email_recepients" onkeyup="checkError(this.id);" value="{{old('test_email_recepients')}}" confirmation="false" class="form-control">
                      </div>
                      @error('test_email_recepients')
                      <label id="test_email_recepients-error" class="error" for="test_email_recepients">{{ $message }}</label>
                      @enderror </div></div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group form-float">
                      <label class="form-label">Type <span style="color:#F00">*</span></label>
                      <div class="demo-radio-button form-line">
                        <input {{old('type') == 'Plain'?'checked':''}} name="type" type="radio" value="Plain" class="with-gap radio" id="Plain" checked="checked">
                        <label for="Plain">Plain </label>
                        <input {{old('type') == 'Html'?'checked':''}} name="type" value="Html" type="radio" class="with-gap radio" id="Html">
                        <label for="Html">Html</label>
                        
                        <input type="button" id="preview_btn" value="Preview" class="btn btn-warning"/>
                      </div>
                    </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group form-float">
                      <label class="form-label">Body <span style="color:#F00">*</span></label>
                      <div class="form-line">
                        <textarea id="body" rows="5" name="body" onkeyup="checkError(this.id);" confirmation="false" class="form-control">{{old('body')}}</textarea>
                      </div>
                      @error('body')
                      <label id="body-error" class="error" for="body">{{ $message }}</label>
                      @enderror </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><div class="form-group form-float">
                      <label class="form-label">Limit</label>
                      <div class="form-line">
                        <input type="text" id="smtp_limit" name="smtp_limit" onkeyup="checkError(this.id);" value="{{old('smtp_limit')}}" confirmation="false" class="form-control">
                      </div>
                      @error('smtp_limit')
                      <label id="smtp_limit-error" class="error" for="smtp_limit">{{ $message }}</label>
                      @enderror </div></div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group form-float">
                      <label class="form-label">File ID</label>
                      <div class="form-line">
                        <input type="text" id="file_id" name="file_id" onkeyup="checkError(this.id);" value="{{old('file_id')}}" confirmation="false" class="form-control">
                      </div>
                      @error('file_id')
                      <label id="file_id-error" class="error" for="file_id">{{ $message }}</label>
                      @enderror </div></div>
                      <div style="padding:10px;" class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <button type="submit" id="submitBtn" class="btn btn-primary m-t-15 waves-effect">Send</button></div>
                    </div>
                    
                    
                    {{ Form::close() }} </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- #END# Input --> 
  </div>
</section>
<script>
	$(document).on('click','#preview_btn',function(){
		$('#defaultModalLabel').html(null);
		$('#errorMsgPopUp').html($('#body').val());
		$('#error500').modal('show');
	});
   $(document).ready(function(e){
	   
	$('#test_mail_bulk_count').filter_input({regex:'[0-9]'});
	$('#limit_to_send').filter_input({regex:'[0-9]'});
	$('#sendgrid_limit').filter_input({regex:'[0-9]'});
	$('#time_to_send').filter_input({regex:'[0-9]'});	
	   
	$(document).on('click','.run_mode',function(){
		var div_id =$(this).val();
		$('#run_mode_div').hide();
		$('#page_action').val('edit');
		$('#submitBtn').html('Send');
		if(div_id == 'Auto'){
			$('#run_mode_div').show();
			$('#page_action').val('list');
			$('#submitBtn').html('Submit');
		}
	});
   		
   	$(document).on('click', '#submitBtn',function(){
   
   		$("#pageForm").validate({
   			errorElement: "label",
   			errorPlacement: function (error, element){
   				$(element).parents('.form-group').append(error);
   			},
   			rules: {
   				'title': {
   					required: true,
   				}
   			},
   			messages: {
   				'title': {
   					required: "Please enter title.",
   				}
   			},
   			submitHandler: function(form){
   				$('#submitBtn').html('Processing...');
   				form.submit();				
   			}
   		});
   	
   	});
	
   });
   
   
</script> 
@endsection