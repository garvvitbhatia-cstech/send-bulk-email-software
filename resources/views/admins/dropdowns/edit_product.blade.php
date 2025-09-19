@extends('layout.admin')
@section('title', 'Edit Product')
@extends('element.admin.jQuery');
@section('content')

<link href="{{ URL::asset('public/assets/css/admin/dropzone.css') }}" rel="stylesheet">
<script src="{{ URL::asset('public/assets/js/admin/dropzone.js') }}"></script>


<section class="content"> 
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Product</h2>
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
                                        {{ Form::open(array('url' => array('/admins/edit-product',Crypt::encrypt($product->id)),'id' => 'pageForm', 'method' => 'post', 'files' => true)) }}
                                            @csrf
                                            <div class="form-group">
                                            	<label class="form-label">Parent Category</label>
                                                <div class="form-line">
                                                    <select id="parent_id" name="parent_id" class="form-control show-tick">
                                                        @php
                                                        	echo Helper::getSubCategory($categoryList,$product->category_id);
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
                                                    <input type="text" name="product_name" id="product_name" value="{{ $product->product_name }}" class="form-control">
                                                </div>
                                                @error('product_name')
                                                <label id="product_name-error" class="error" for="product_name">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">Product Price</label>
                                                <div class="form-line">
                                                    <input type="text" name="price" id="price" value="{{ $product->price }}" class="form-control">
                                                </div>
                                                @error('price')
                                                <label id="price-error" class="error" for="price">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">Product Quantity</label>
                                                <div class="form-line">
                                                    <input type="text" name="quantity" id="quantity" value="{{ $product->quantity }}" class="form-control">
                                                </div>
                                                @error('quantity')
                                                <label id="quantity-error" class="error" for="quantity">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">Product Description</label>
                                                <div class="form-line">
                                                	<textarea name="description" rows="6" id="description" class="form-control">{{ $product->description }}</textarea>
                                                </div>
                                                @error('description')
                                                <label id="description-error" class="error" for="description">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">Product Keywords</label>
                                                <div class="form-line">
                                                	<textarea name="keywords" rows="6" id="keywords" class="form-control">{{ $product->keywords }}</textarea>
                                                </div>
                                                @error('keywords')
                                                <label id="keywords-error" class="error" for="keywords">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">SEO Title</label>
                                                <div class="form-line">
                                                    <input type="text" name="seo_title" id="seo_title" value="{{ $product->seo_title }}" class="form-control">
                                                </div>
                                                @error('seo_title')
                                                <label id="seo_title-error" class="error" for="seo_title">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">SEO Keywords</label>
                                                <div class="form-line">
                                                	<textarea name="seo_keywords" rows="6" id="seo_keywords" class="form-control">{{ $product->seo_keywords }}</textarea>
                                                </div>
                                                @error('seo_keywords')
                                                <label id="seo_keywords-error" class="error" for="seo_keywords">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                            	<label class="form-label">SEO Description</label>
                                                <div class="form-line">
                                                	<textarea name="seo_description" rows="6" id="seo_description" class="form-control">{{ $product->seo_description }}</textarea>
                                                </div>
                                                @error('seo_description')
                                                <label id="seo_description-error" class="error" for="seo_description">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group form-float">
                                                <label class="form-label">SEO Robots</label>
                                                 <div class="form-line">
                                                    <select id="robot_tags" name="robot_tags" onkeyup="checkError(this.id);" confirmation="false" class="form-control">
                                                    <option {{$product->robot_tags == 'index,follow' ? "checked" : "" }} value="index,follow">index,follow</option>
                                                    <option {{$product->robot_tags == 'index,nofollow' ? "checked" : "" }} value="index,nofollow">index,nofollow</option>
                                                    <option {{$product->robot_tags == 'noindex,follow' ? "checked" : "" }} value="noindex,follow">noindex,follow</option>
                                                    <option {{$product->robot_tags == 'noindex,nofollow' ? "checked" : "" }} value="noindex,nofollow">noindex,nofollow</option>
                                                    </select>                                    
                                                 </div>
                                                 @error('robot_tags')
                                                 <label id="robot_tags-error" class="robot_tags" for="robot_tags">{{ $message }}</label>
                                                 @enderror 
                                            </div>                                            
                                            <div class="form-group form-float">
                                                <label class="form-label">Product Images</label>
                                                <div id="my-awesome-dropzone" class="dropzone"></div>
                                            </div>
                                            @if(isset($productImages) && !empty($productImages->count() > 0))
                                            <hr>                                            
                                            	<table style="width:500px;" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                                <thead>
                                                  <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Ordering</th>
                                                    <th>Action</th>
                                                  </tr>
                                                </thead>              
                                                <tbody>
                                            	@foreach($productImages as $key => $image)
                                                	@php
                                                        if(!empty($image->image_name)){
                                                    @endphp
                                                    
                                                    	<tr>
                                                        	<td>{{ $key+1 }}</td>
                                                            <td>
                                                            <img width="100px;" alt="" title="" src="{{ URL::asset('public/assets/images/admin/products/') }}/{!! $image->image_name !!}" />
                                                            </td>
                                                            <td width="100px;">
                                                            <input type="text" name="ordering[]" id="" class="form-control" placeholder="ordering" class="ordering" value="{{ $image->ordering }}"/>
                                                            <input type="hidden" name="orderingEditId[]" value="{{ $image->id }}"/>
                                                            </td>
                                                            <td>
                                      						<button title="Remove Product Image" onClick="removeProductImage('{{ Crypt::encrypt($image->id) }}')" type="button" title="Delete" class="btn bg-red waves-effect">
                                                                <i class="material-icons">delete</i>
                                                            </button>
                                                            </td>
                                                        </tr>                                                                                                          
                                                    @php
                                                        }
                                                    @endphp  
                                                @endforeach  
                                                </tbody>
                                                </table>                                                                                             
                                            @endif
                                            <br />
											<label class="form-label">Status</label>
                                            <div class="form-group">
                                                <input type="checkbox" id="status" checked="checked" {{$product->status == 1 ? "checked" : "" }} value="1" name="status" class="filled-in" />
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

/**************delete banner image*****************/
function removeProductImage(rowId){
	if (rowId != '') {
		swal({
			title: "Do you want to delete this product image?",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			cancelButtonText: "No",
			confirmButtonText: 'Yes',
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				swal("Deleted!", "", "success");
				$.ajax({
					type: 'POST',
					url: "{{url('admins/delete-product-image')}}",
					headers:{
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {rowId: rowId},
					success: function(msg) {
						window.location.reload(true);
					},
					error: function(ts){
						$('#errorMsgPopUp').html('Something went wrong');
						$('#Error500').modal('show');
					}
				})
			} else {
				swal("Cancelled", "", "error");
			}
		});
	}
}

$('#my-awesome-dropzone').attr('class', 'dropzone');
var myDropzone = new Dropzone('#my-awesome-dropzone', {
	url: "{{url('admins/upload-product-images')}}",
	clickable: true,
	method: 'POST',
	maxFiles: 50,
	parallelUploads: 50,
	maxFilesize: 20,
	addRemoveLinks: false,
	dictRemoveFile: 'Remove',
	dictCancelUpload: 'Cancel',
	dictCancelUploadConfirmation: 'Confirm cancel?',
	dictDefaultMessage: 'Drop files here to upload',
	dictFallbackMessage: 'Your browser does not support drag n drop file uploads',
	dictFallbackText: 'Please use the fallback form below to upload your files like in the olden days',
	paramName: 'file',
	params: {'pid':'{{ $product->id }}'},
	forceFallback: false,
	createImageThumbnails: true,
	maxThumbnailFilesize: 5,
	//acceptedFiles: ".jpeg,.jpg,.webp,.png,.svg",
	acceptedFiles: "image/*",
	autoProcessQueue: true,
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	},
	init: function() {
		this.on('thumbnail', function(file) {
			if (file.width < 100 || file.height < 100) {
				file.rejectDimensions();
			} else {
				file.acceptDimensions();
			}
		});
	},
	accept: function(file, done) {
		file.acceptDimensions = done;
		file.rejectDimensions = function() {
			done('The image must be at least 100 x 100px')
		};
	}
});

myDropzone.on("complete", function(file) {
	var status = file.status;
	if (status == 'success') {

	}
	console.log(file);
});

var count = 1;
myDropzone.on("success", function(file, responseText) {
	var fnamenew = file.name;
	count++;
});

myDropzone.on("removedfile", function(file) {
	var fname = file.name;
	fname2 = fname.trim().replace(/["~!@#$%^&*\(\)_+=`{}\[\]\|\\:;'<>,.\/?"\- \t\r\n]+/g, '_');    
});

myDropzone.on("addedfile", function(file) {

}); 

</script>

@endsection