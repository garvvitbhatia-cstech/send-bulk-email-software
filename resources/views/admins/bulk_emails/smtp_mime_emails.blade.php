@extends('layout.admin')
@section('title', 'Smtp Emails Mime')
@section('content')
@extends('element.admin.jQuery')

<style>
.container {
    width: 95% !important;
}
</style>

<section class="content" style="margin: 100px 15px 0 0;">
  <div class="container-fluid">
    <div class="block-header">
      <h2>Smtp Emails Mime</h2>
    </div>
    <!-- Basic Examples -->
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            <div class="row"> {{ Form::open(array('url' => array('/admins/smtp-emails-mime'),'id' => 'pageForm', 'method' => 'post')) }}
              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <select name="type" class="form-control">
                  <option value="">Type</option>
                  <option value="Plain">Plain</option>
                  <option value="Html">Html</option>
                  <option value="Mime">Mime</option>
                </select>
                &nbsp; </div>
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <button type="submit" class="btn btn-default waves-effect">Search</button>
              </div>
              {{ Form::close() }} </div>
            <ul class="header-dropdown">
              <li class="dropdown"> 
                <!--<a href="{{url('admins/add-smtp-email-mime')}}"><button type="button" class="btn btn-warning btn-lg waves-effect">Add Smtp Email Mime</button></a>--> 
              </li>
            </ul>
          </div>
          <div class="body">
            <div class="table-responsive">
              <div class="dataTables_wrapper form-inline dt-bootstrap">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Run Mode</th> 
                      <th>Mode</th> 
                      <th>Type</th> 
                      <th>Limit</th> 
                      <th>File ID</th> 
                      <th>Page</th> 
                      <th>Created</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Run Mode</th> 
                      <th>Mode</th> 
                      <th>Type</th> 
                      <th>Limit</th> 
                      <th>File ID</th> 
                      <th>Page</th> 
                      <th>Created</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  
                  @if(isset($pages) && $pages->count() > 0)
                  @foreach($pages as $key => $smtp)
                  @php
                  $isExists = 0;
                  $limit = $smtp->smtp_limit != "" ? $smtp->smtp_limit : '--';
                  $fileID = $smtp->file_id != "" ? $smtp->file_id : '--';
                  @endphp
                  <tr>
                    <td>{{ $key+1; }}</td>
                    <td>{{ $smtp->run_mode; }}</td>
                    <td>{{ $smtp->mode; }}</td>
                    <td>{{ $smtp->type; }}</td>
                    <td>{{ $limit; }}</td>
                    <td>{{ $fileID; }}</td>
                    <td>1/100</td>
                    <td>{{ date("F jS, Y",strtotime($smtp->created_at)); }}</td>
                    <td>
                    	@if($smtp->process == 0)
                    	<a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_mime_emails','1')" class="btn bg-blue waves-effect">Start</a>
                        @endif
                        @if($smtp->process == 1)
         				<a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_mime_emails','2')" class="btn bg-blue waves-effect">Pause</a>
                        <a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_mime_emails','4')" class="btn bg-red waves-effect">Stop</a>               	
                        @endif
                        
                        @if($smtp->process == 2)
                        	<a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_mime_emails','3')" class="btn bg-green waves-effect">Resume</a>
                        	<a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_mime_emails','4')" class="btn bg-red waves-effect">Stop</a>
                        @endif
                        
                        @if($smtp->process == 3)
                        	<a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_mime_emails','2')" class="btn bg-blue waves-effect">Pause</a>
                        	<a href="javascript:void(0)" onclick="changeProcessStatus('{{ Crypt::encrypt($smtp->id) }}','smtp_mime_emails','4')" class="btn bg-red waves-effect">Stop</a>
                        @endif
                        
                        @if($smtp->process == 4)
                        	<a href="javascript:void(0)"class="btn bg-red waves-effect">Stopped</a>
                        @endif
                        
                    </td>
                    <td><!--<a href="{{ url('admins/edit-smtp-email-mime',Crypt::encrypt($smtp->id)) }}">
                      <button type="button" title="Edit" class="btn bg-blue waves-effect"> Edit </button>
                      </a>-->
                      <button onclick="deleteRecord('smtp_mime_emails','{{ Crypt::encrypt($smtp->id) }}',{{ $isExists; }});" type="button" title="Delete" class="btn bg-red waves-effect"> Delete </button></td>
                  </tr>
                  @endforeach
                  
                  @else
                  <tr>
                    <td align="center" colspan="9">Record not found</td>
                  </tr>
                  @endif
                    </tbody>
                  
                </table>
              </div>
            </div>
            {!! $pages->appends(request()->except('page','_token'))->links('pagination.custom') !!} </div>
        </div>
      </div>
    </div>
    <!-- #END# Basic Examples --> 
  </div>
</section>
<script type="text/javascript">
	function changeProcessStatus(id,model,status){
		$.ajax({
			type: 'POST',
			url: "{{url('admins/change-process-status')}}",
			data:{dataToken:id,model:model,status:status},
			headers:{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(msg){
				window.location.href = '';
			}
		});
	}
	function searchData(){
		window.location.href="{{url('admins/smtp-emails-mime')}}";	
	}
</script> 
@endsection