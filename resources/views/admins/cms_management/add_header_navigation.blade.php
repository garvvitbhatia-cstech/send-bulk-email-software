@extends('layout.admin')
@section('title', 'Add Header Navigation')
@section('content')
<section class="content">
   <div class="container-fluid">
   <div class="block-header">
      <h2>Add Header Navigation</h2>
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
                           {{ Form::open(array('url' => array('/admins/add-header-navigation'),'id' => 'pageForm', 'method' => 'post', 'files' => true)) }}
                           @csrf
                           <div class="form-group form-float">
                              <label class="form-label">Title</label>
                              <div class="form-line">
                                 <select name="parent_id" id="parent_id" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                                 @php
                                 	echo Helper::getNavigationCategory($headerNavigationList);
                                 @endphp
                                 </select>
                              </div>
                              @error('parent_id')
                              <label id="parent_idError" class="error" for="parent_id">{{ $message }}</label>
                              @enderror 
                           </div>
                           <div class="form-group form-float">
                              <label class="form-label">Target Window</label>
                              <div class="form-line">
                                 <select id="target_window" name="target_window" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                                    <option value="Self">Self</option>
                                    <option value="blank">Blank</option>
                                 </select>
                                 @error('target_window')
                                 <label id="target_windowError" class="error" for="parent_id">{{ $message }}</label>
                                 @enderror 
                              </div>
                           </div>
                           <div class="form-group form-float">
                              <label class="form-label">Page Type</label>
                              <div class="form-line">
                                 <select id="type" name="type" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                                    <option value="cms">CMS</option>
                                    <option value="custom">Custom</option>
                                 </select>
                                 @error('type')
                                 <label id="typeError" class="error" for="type">{{ $message }}</label>
                                 @enderror 
                              </div>
                           </div>
                           <div id="cmsPageDiv">
                              <div class="form-group form-float">
                                 <label class="form-label">CMS Pages</label>
                                 <div class="form-line">
                                    <select id="menu_page_id" name="menu_page_id" onchange="checkError(this.id);" confirmation="false" class="form-control">
                                       <option value="">Select Cms Page</option>
                                       @if(isset($cmsPageList) && !empty($cmsPageList))                         	
                                       @foreach($cmsPageList as $cmsKey => $cmsVal)
                                       	<option value="{{ $cmsKey }}"> {{ $cmsVal }} </option>
                                       @endforeach
                                       @endif
                                    </select>
                                    @error('menu_page_id')
                                    <label id="menu_page_idError" class="error" for="menu_page_id">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                           </div>
                           <div id="customPageDiv" style="display:none;">
                              <div class="form-group form-float">
                                 <label class="form-label">Title:</label>
                                 <div class="form-line">
                                    <input type="text" id="title" name="title" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                                    @error('title')
                                    <label id="titleError" class="error" for="title">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <div class="form-group form-float">
                                 <label class="form-label">Custom URL</label>
                                 <div class="form-line">
                                    <input type="text" id="url" name="url" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                                    @error('url')
                                    <label id="urlError" class="error" for="url">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <div class="form-group form-float">
                                 <label class="form-label">SEO Title</label>
                                 <div class="form-line">
                                    <input type="text" id="seo_title" name="seo_title" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                                    @error('seo_title')
                                    <label id="seo_titleError" class="error" for="seo_title">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <div class="form-group form-float">
                                 <label class="form-label">SEO Description</label>
                                 <div class="form-line">
                                    <textarea id="seo_description" name="seo_description" onkeyup="checkError(this.id);" rows="8" confirmation="false" class="form-control"></textarea>
                                    @error('seo_description')
                                    <label id="seo_descriptionError" class="error" for="seo_description">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <div class="form-group form-float">
                                 <label class="form-label">SEO Keywords</label>
                                 <div class="form-line">
                                    <textarea id="seo_keyword" name="seo_keyword" onkeyup="checkError(this.id);" rows="8" confirmation="false" class="form-control"></textarea>
                                    @error('seo_keyword')
                                    <label id="seo_keywordError" class="error" for="seo_keyword">{{ $message }}</label>
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
                                    <label id="robot_tagsError" class="error" for="robot_tags">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              </div>
                              <div class="form-group">
                                 <label class="form-label form-float">Status</label>
                                 <div class="form-line">
                                    <input type="checkbox" id="status" value="1" name="status" class="filled-in" />
                                    <label for="status">Active</label>
                                    @error('status')
                                    <label id="statusError" class="error" for="status">{{ $message }}</label>
                                    @enderror 
                                 </div>
                              </div>
                              <button type="button" id="submitBtn" class="submitBtn btn btn-primary m-t-15 waves-effect">Submit</button>
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
var frmSubmitted = 0;
$('.submitBtn').click(function(){
   var flag = 0;
   if(frmSubmitted == 0){
      if($.trim($('#type').val()) == "cms"){
         if($.trim($('#menu_page_id').val()) == ""){
            $('#menu_page_idError').show().html('Please select cms page.').slideDown();
            $('#menu_page_id').focus();
            frmSubmitted = 0;
            flag = 1;
            return false;
         }
      }
      if($.trim($('#type').val()) == "custom"){
         if($.trim($('#title').val()) == ""){
            $('#titleError').show().html('Please enter page title.').slideDown();
            $('#title').focus();
            frmSubmitted = 0;
            flag = 1;
            return false;
         }
         if($.trim($('#url').val()) == ""){
            $('#urlError').show().html('Please enter page url.').slideDown();
            $('#url').focus();
            frmSubmitted = 0;
            flag = 1;
            return false;
         }else{
            url_validate = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
            if(!url_validate.test($.trim($('#url').val()))){
               $('#urlError').show().html('Please enter valid url.').slideDown();
               $('#url').focus();
               frmSubmitted = 0;
               flag = 1;
               return false;
            }
         }
         if($.trim($('#seo_title').val()) == ""){
            $('#seo_titleError').show().html('Please enter seo title.').slideDown();
            $('#seo_title').focus();
            frmSubmitted = 0;
            flag = 1;
            return false;
         }
         if($.trim($('#seo_description').val()) == ""){
            $('#seo_descriptionError').show().html('Please enter seo description.').slideDown();
            $('#seo_description').focus();
            frmSubmitted = 0;
            flag = 1;
            return false;
         }
         if($.trim($('#seo_keyword').val()) == ""){
            $('#seo_keywordError').show().html('Please enter seo keyword.').slideDown();
            $('#seo_keyword').focus();
            frmSubmitted = 0;
            flag = 1;
            return false;
         }
      }
      if(flag == 0){
         $('.submitBtn').html('Processing...');
         $('#pageForm').submit();
         frmSubmitted = 1;
         return true;
      }
   }else{
      return false;
   }
});

$('#type').on('change', function (){
   if(this.value == 'custom'){
      $('#customPageDiv').css('display', 'block');
      $('#cmsPageDiv').css('display', 'none');
   }else{
      $('#customPageDiv').css('display', 'none');
      $('#cmsPageDiv').css('display', 'block');
   }
});
</script> 
@endsection