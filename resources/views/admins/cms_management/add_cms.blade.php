@extends('layout.admin')
@section('title', 'Add Cms')
@section('content')
<section class="content">
   <div class="container-fluid">
   <div class="block-header">
      <h2>Add Cms</h2>
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
                           {{ Form::open(array('url' => array('/admins/add-cms'),'id' => 'pageForm', 'method' => 'post', 'files' => true)) }}
                           @csrf
                              <div class="form-group form-float">
                                 <label class="form-label">Title</label>
                                 <div class="form-line">
                                    <input type="text" id="title" name="title" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                                    @error('title')
                                    <label id="title-error" class="error" for="title">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <div class="form-group form-float">
                                 <label class="form-label">Description</label>
                                 <div class="form-line">
                                    <textarea id="description" name="description" onkeyup="checkError(this.id);" confirmation="false" class="form-control"></textarea>
                                    @error('description')
                                    <label id="description-error" class="error" for="description">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <div class="form-group form-float">
                                 <label class="form-label">SEO Title</label>
                                 <div class="form-line">
                                    <input type="text" id="seo_title" name="seo_title" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                                    @error('seo_title')
                                    <label id="seo_title-error" class="error" for="seo_title">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <div class="form-group form-float">
                                 <label class="form-label">SEO Description</label>
                                 <div class="form-line">
                                    <textarea id="seo_description" name="seo_description" onkeyup="checkError(this.id);" rows="8" confirmation="false" class="form-control"></textarea>
                                    @error('seo_description')
                                    <label id="seo_description-error" class="error" for="seo_description">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <div class="form-group form-float">
                                 <label class="form-label">SEO Keywords</label>
                                 <div class="form-line">
                                    <textarea id="seo_keyword" name="seo_keyword" onkeyup="checkError(this.id);" rows="8" confirmation="false" class="form-control"></textarea>
                                    @error('seo_keyword')
                                    <label id="seo_keyword-error" class="error" for="seo_keyword">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <div class="form-group form-float">
                                 <label class="form-label">SEO Robots</label>
                                 <div class="form-line">
                                    <select id="robot_tags" name="robot_tags" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                                       <option value="index,follow">index,follow</option>
                                       <option value="index,nofollow">index,nofollow</option>
                                       <option value="noindex,follow">noindex,follow</option>
                                       <option value="noindex,nofollow">noindex,nofollow</option>
                                    </select>
                                    @error('robot_tags')
                                    <label id="robot_tags-error" class="error" for="robot_tags">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="form-label form-float">Status</label>
                                 <div class="">
                                    <input type="checkbox" id="status" value="1" name="status" class="filled-in" />
                                    <label for="status">Active</label>
                                    @error('status')
                                    <label id="status-error" class="error" for="status">{{ $message }}</label>
                                    @enderror 
                                 </div>
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