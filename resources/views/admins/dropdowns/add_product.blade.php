@extends('layout.admin')
@section('title', 'Add Product')

@section('content')

<section class="content"> 
    <div class="container-fluid">
        <div class="block-header">
            <h2>Add Product</h2>
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
                                        {{ Form::open(array('url' => '/admins/add-product/','id' => 'pageForm', 'method' => 'post', 'files' => true)) }}
                                            @csrf
                                            <div class="form-group">
                                            	<label class="form-label">Parent Category</label>
                                                <div class="form-line">
                                                    <select id="parent_id" name="parent_id" class="form-control show-tick">
                                                        @php
                                                        	echo Helper::getSubCategory($categoryList);
                                                        @endphp
                                                    </select>        
                                               	</div>
                                                @error('parent_id')
                                                <label id="parent_id-error" class="error" for="parent_id">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">Product Name</label>
                                                <div class="form-line">
                                                    <input type="text" name="product_name" id="product_name" class="form-control">
                                                </div>
                                                @error('product_name')
                                                <label id="product_name-error" class="error" for="product_name">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">Product Price</label>
                                                <div class="form-line">
                                                    <input type="text" name="price" id="price" class="form-control">
                                                </div>
                                                @error('price')
                                                <label id="price-error" class="error" for="price">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">Product Quantity</label>
                                                <div class="form-line">
                                                    <input type="text" name="quantity" id="quantity" class="form-control">
                                                </div>
                                                @error('quantity')
                                                <label id="quantity-error" class="error" for="quantity">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">Product Description</label>
                                                <div class="form-line">
                                                	<textarea name="description" rows="6" id="description" class="form-control"></textarea>
                                                </div>
                                                @error('description')
                                                <label id="description-error" class="error" for="description">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">Product Keywords</label>
                                                <div class="form-line">
                                                	<textarea name="keywords" rows="6" id="keywords" class="form-control"></textarea>
                                                </div>
                                                @error('keywords')
                                                <label id="keywords-error" class="error" for="keywords">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">SEO Title</label>
                                                <div class="form-line">
                                                    <input type="text" name="seo_title" id="seo_title" class="form-control">
                                                </div>
                                                @error('seo_title')
                                                <label id="seo_title-error" class="error" for="seo_title">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">SEO Keywords</label>
                                                <div class="form-line">
                                                	<textarea name="seo_keywords" rows="6" id="seo_keywords" class="form-control"></textarea>
                                                </div>
                                                @error('seo_keywords')
                                                <label id="seo_keywords-error" class="error" for="seo_keywords">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">SEO Description</label>
                                                <div class="form-line">
                                                	<textarea name="seo_description" rows="6" id="seo_description" class="form-control"></textarea>
                                                </div>
                                                @error('seo_description')
                                                <label id="seo_description-error" class="error" for="seo_description">{{ $message }}</label>
                                                @enderror
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
                                                 </div>
                                                 @error('robot_tags')
                                                 <label id="robot_tags-error" class="robot_tags" for="robot_tags">{{ $message }}</label>
                                                 @enderror 
                                              </div>
											<label class="form-label">Status</label>
                                            <div class="form-group">
                                                <input type="checkbox" id="status" checked="checked" value="1" name="status" class="filled-in" />
                                                <label for="status">Active</label>
											</div>
											
                                            <button type="submit" id="submitBtn" class="btn btn-primary m-t-15 waves-effect">Submit</button>
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
	$('#price').filter_input({regex:'[0-9.]'});
	$('#quantity').filter_input({regex:'[0-9]'});
	
	CKEDITOR.replace('description');
	CKEDITOR.replace('seo_description');

	$(document).on('click', '#submitBtn',function(){

		$("#pageForm").validate({
			errorElement: "label",
			errorPlacement: function (error, element) {
				$(element).parents('.form-group').append(error);
			},
			rules: {
				'product_name': {
					required: true,
				},
				'price': {
					required: true,
				},
				'quantity': {
					required: true,
				},
				'keywords': {
					required: true,
				}
			},
			messages: {
				'product_name': {
					required: "Please enter product name.",
				} ,
				'price': {
					required: "Please enter product price.",
				},
				'quantity': {
					required: "Please enter product quantity.",
				} ,
				'keywords': {
					required: "Please enter product keywords.",
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