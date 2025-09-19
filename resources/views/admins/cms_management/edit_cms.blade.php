@extends('layout.admin')
@section('title', 'Edit Cms')
@section('content')
<section class="content">
   <div class="container-fluid">
   <div class="block-header">
      <h2>Edit Cms</h2>
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
                        <div class="body">
                           {{ Form::open(array('url' => array('/admins/edit-cms',Crypt::encrypt($cms->id)),'id' => 'pageForm', 'method' => 'post', 'files' => true)) }}
                           @csrf
                              <div class="form-group form-float">
                                 <label class="form-label">Title</label>
                                 <div class="form-line">
                                    <input type="text" id="title" name="title" value="{{ $cms->title }}" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                                    @error('title')
                                    <label id="title-error" class="error" for="title">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <div class="form-group form-float">
                                 <label class="form-label">Description</label>
                                 <div class="form-line">
                                    <textarea id="description" name="description" onkeyup="checkError(this.id);" confirmation="false" class="form-control">{{ $cms->title }}</textarea>
                                    @error('description')
                                    <label id="description-error" class="error" for="description">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <div class="form-group form-float">
                              	<label class="form-label">SEO Title</label>
                                 <div class="form-line">
                                    <input type="text" id="seo_title" name="seo_title" value="{{ $cms->seo_title }}" onkeyup="checkError(this.id);" confirmation="false" class="form-control">                                    
                                 </div>
                                 @error('seo_title')
                                 <label id="seo_title-error" class="error" for="seo_title">{{ $message }}</label>
                                 @enderror 
                              </div>
                              <div class="form-group form-float">
                              	<label class="form-label">SEO Description</label>
                                 <div class="form-line">
                                    <textarea id="seo_description" name="seo_description" onkeyup="checkError(this.id);" rows="5" confirmation="false" class="form-control">{{ $cms->seo_description }}</textarea>                                    
                                 </div>
                                 @error('seo_description')
                                 <label id="seo_description-error" class="error" for="seo_description">{{ $message }}</label>
                                 @enderror 
                              </div>
                              <div class="form-group form-float">
                              	<label class="form-label">SEO Keyword</label>
                                 <div class="form-line">
                                    <textarea id="seo_keyword" name="seo_keyword" onkeyup="checkError(this.id);" rows="5" confirmation="false" class="form-control">{{ $cms->seo_keyword }}</textarea>                                    
                                 </div>
                                 @error('seo_keyword')
                                 <label id="seo_keyword-error" class="error" for="seo_keyword">{{ $message }}</label>
                                 @enderror 
                              </div>
                              <div class="form-group form-float">
                              	<label class="form-label">SEO Robots</label>
                                 <div class="form-line">
                                    <select id="robot_tags" name="robot_tags" value="{{ $cms->robot_tags }}" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                                    <option {{$cms->robot_tags == 'index,follow' ? "selected" : "" }} value="index,follow">index,follow</option>
                                    <option {{$cms->robot_tags == 'index,nofollow' ? "selected" : "" }} value="index,nofollow">index,nofollow</option>
                                    <option {{$cms->robot_tags == 'noindex,follow' ? "selected" : "" }} value="noindex,follow">noindex,follow</option>
                                    <option {{$cms->robot_tags == 'noindex,nofollow' ? "selected" : "" }} value="noindex,nofollow">noindex,nofollow</option>
                                    </select>                                    
                                 </div>
                                 @error('robot_tags')
                                 <label id="robot_tags-error" class="robot_tags" for="robot_tags">{{ $message }}</label>
                                 @enderror 
                              </div>
                              <label class="form-label">Status</label>
                              <div class="form-group">
                                 <input type="checkbox" id="status" value="1" {{$cms->status == 1 ? "checked" : "" }} name="status" class="filled-in" />
                                 <label for="status">Active</label>
                              </div>
                              <button type="submit" id="submitBtn" class="submitBtn btn btn-primary m-t-15 waves-effect">Submit</button>
                              {{ Form::close() }} 
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
<script type="text/javascript">
$(document).ready(function(e){  
	CKEDITOR.replace('description');
	
   	$('#title').filter_input({regex:'[a-z- &A-Z]'});
			
   	$(document).on('click', '#submitBtn',function(){
   
   		$("#pageForm").validate({
   			errorElement: "label",
   			errorPlacement: function (error, element){
   				$(element).parents('.form-group').append(error);
   			},
   			rules: {
   				'title': {
   					required: true,
   				},
				'description': {
   					required: true,
   				},
   			},
   			messages: {
   				'title': {
   					required: "Please enter title.",
   				},
				'description': {
   					required: "Please enter description.",
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