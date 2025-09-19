@extends('layout.admin')
@section('title', 'Upload File')
@section('content')
<section class="content" style="margin: 100px 15px 0 0;">
  <div class="container-fluid">
    <div class="block-header">
      <h2>Upload File</h2>
    </div>
    <!-- Input -->
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="">
          <div class="body">
            <div class="row clearfix">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                <div class="card"> 
                @include('../flash-message')
                {{ Form::open(array('url' => array('/admins/upload'),'id' => 'pageForm', 'method' => 'post', 'files' => true)) }}
                  @csrf
                  <div class="body">
                    <div class="form-group form-float">
                      <label class="form-label">Select Text File To Upload</label>
                      <div class="form-line">
                        <input type="file" id="file" name="file" onkeyup="checkError(this.id);" accept=".txt" confirmation="false" class="form-control">
                      </div>
                      @error('file')
                      <label id="file-error" class="error" for="file">{{ $message }}</label>
                      @enderror </div>
                    <button type="submit" id="submitBtn" class="btn btn-primary m-t-15 waves-effect">Upload</button>
                    {{ Form::close() }} 
                    </div>
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
   $(document).ready(function(e){

   	$(document).on('click', '#submitBtn',function(){
   
   		$("#pageForm").validate({
   			errorElement: "label",
   			errorPlacement: function (error, element){
   				$(element).parents('.form-group').append(error);
   			},
   			rules: {
   				'file': {
   					required: true,
   				}
   			},
   			messages: {
   				'file': {
   					required: "Please select file.",
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