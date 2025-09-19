@extends('layout.admin')
@section('title', 'Smtp Emails')
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
      <h2>Smtp Emails</h2>
    </div>
    <!-- Basic Examples -->
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            <div class="row"> {{ Form::open(array('url' => array('/admins/smtp-emails'),'id' => 'pageForm', 'method' => 'post')) }}
              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <select name="type" class="form-control">
                  <option value="">Type</option>
                  <option value="Plain">Plain</option>
                  <option value="Html">Html</option>
                </select>
                &nbsp; </div>
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <button type="submit" class="btn btn-default waves-effect">Search</button>
              </div>
              {{ Form::close() }} </div>
            <ul class="header-dropdown">
              <li class="dropdown"> 
                <!--<a href="{{url('admins/add-smtp-email')}}"><button type="button" class="btn btn-warning btn-lg waves-effect">Add Smtp Email</button></a>--> 
              </li>
            </ul>
          </div>
          <div class="body">
            <div class="table-responsive">
              <div class="dataTables_wrapper form-inline dt-bootstrap" id="replaceHtml">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Run Mode</th> 
                      <th>Mode</th> 
                      <th>Type</th> 
                      <th>Limit</th> 
                      <th>File ID</th> 
                      <th>Total Emails</th> 
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
                      <th>Total Emails</th> 
                      <th>Created</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  
                 
                  <tr>
                    <td colspan="8" align="center">Loading....</td>
                  </tr>
             
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
setInterval(() => {paginate()}, "5000");
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
	function paginate(){
		$.ajax({
			type: 'POST',
			url: "{{url('admins/smtp-emails-pagination')}}",
			data:{},
			headers:{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(msg){
				$('#replaceHtml').html(msg);
			}
		});
	}

	function searchData(){
		window.location.href="{{url('admins/smtp-emails')}}";	
	}
</script> 
@endsection