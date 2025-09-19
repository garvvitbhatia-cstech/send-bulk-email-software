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
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Contacts;
use App\Models\Products;
use App\Models\ProductImages;
 
class DropdownsController extends Controller{

	public function categories(Request $request){
		$conditions = array();
		$cond = array();
		if($request->input('title') != ''){
			$cond['title'] = array('title', 'like', '%'.$request->input('title').'%');
		}
		if($request->input('status') != ''){
			$cond['status'] = array('status', $request->input('status'));
		}
		$i = 0;
		foreach($cond as $value){
			$conditions[$i] = $value;
			$i++;
		}
		$pages = Category::where($conditions)->latest()->paginate(PAGE_LIMIT);
		return view('admins.dropdowns.categories',compact('pages'));
	}

	public function add_category(Request $request){
		$postData = $request->all();
		if(!empty($postData)){
			$request->validate([
				'type' => 'required',
				'title' => 'required|unique:categories',
				'parent_id' => 'required',
				//'category_banner' => 'required|mimes:jpg,png,jpeg|max:2048',
				//'category_icon' => 'required|mimes:jpg,png,jpeg|max:2048'
			],[
				'type.required' => 'Please select category type',
				'title.required' => 'Please enter category title.',
				'title.unique' => 'Category already exists.',
				'parent_id.required' => 'Please choose parent category',
				//'category_banner.required' => 'Please choose category banner.',
				//'category_banner.mimes' => 'Please choose only jpg,png,jpeg image',
				//'category_icon.required' => 'Please choose category icon.',
				//'category_icon.mimes' => 'Please choose only jpg,png,jpeg image'				
			]);
			
			try {
				$category_banner = $category_icon = NULL;
				if(!empty($request->file('category_banner'))){
					$actual_image_name = time().rand().'.'.$request->category_banner->extension();  
					$destination = base_path().'/public/assets/images/admin/categories/';
					if($request->category_banner->move($destination, $actual_image_name)){
						$category_banner = $actual_image_name;
					}
				}
				if(!empty($request->file('category_icon'))){
					$actual_image_name2 = time().rand().'.'.$request->category_icon->extension();  
					$destination2 = base_path().'/public/assets/images/admin/categories/';
					if($request->category_icon->move($destination2, $actual_image_name2)){
						$category_icon = $actual_image_name2;
					}
				}
				$status = 0;
				if(isset($request->status)){
					$status = 1;	
				}
	
				$category = new Category;
				$category->type = $request->type;
				$category->title = $request->title;
				$category->parent_id = $request->parent_id;
				$category->slug = Str::slug($request->title);
				$category->category_banner = $category_banner;
				$category->category_icon = $category_icon;
				$category->status = $status;
				$category->save();	
				return redirect('admins/category')->with('success','Category has been created successfully');	
			}
			catch(\Exception $e){
				return back()->with('error','Something went wrong');
			}			
		}
		$categories = $this->categoryTypeList();
		$categoryList = Category::where(['status' => 1, 'parent_id' => 0])->get(['id','title']);
		return view('admins.dropdowns.add_category',compact('categoryList','categories'));	
	}
	
	public function edit_category(Request $request, $id){
		$category = Category::where('id',Crypt::decrypt($id))->first();				
		$postData = $request->all();
		if(!empty($postData)){
			$request->validate([
				'type' => 'required',
				'parent_id' => 'required',
				'title' => 'required|unique:categories,title,'.$category->id
			],[
				'type.required' => 'Please select category type',
				'parent_id.required' => 'Please enter category title',
				'title.required' => 'Please enter category title',
				'title.unique' => 'Category already exists.'
			]);
			
			try {
				$category_banner = $category->category_banner;
				$category_icon = $category->category_icon;
				if(!empty($request->file('category_banner'))){
					$actual_image_name = time().rand().'.'.$request->category_banner->extension();  
					$destination = base_path().'/public/assets/images/admin/categories/';
					if($request->category_banner->move($destination, $actual_image_name)){
						if($request->input('old_banner') != ""){
							if(file_exists($destination.$request->input('old_banner'))){
								unlink($destination.$request->input('old_banner'));
							}
						}
						$category_banner = $actual_image_name;
					}
				}
				
				if(!empty($request->file('category_icon'))){
					$actual_image_name2 = time().rand().'.'.$request->category_icon->extension();  
					$destination2 = base_path().'/public/assets/images/admin/categories/';
					if($request->category_icon->move($destination2, $actual_image_name2)){
						if($request->input('old_icon') != ""){
							if(file_exists($destination2.$request->input('old_icon'))){
								unlink($destination2.$request->input('old_icon'));
							}
						}
						$category_icon = $actual_image_name2;
					}
				}
				$status = 0;
				if(isset($request->status) && $request->status == 1){
					$status = 1;
				}
				$category_row = Category::find($category->id);
				$category_row->type = $request->type;
				$category_row->title = $request->title;
				$category_row->parent_id = $request->parent_id;
				$category_row->slug = Str::slug($request->title);
				$category_row->category_banner = $category_banner;
				$category_row->category_icon = $category_icon;
				$category_row->status = $status;
				$category_row->save();
				return back()->with('success','Category has been updated successfully');
			}
			catch(\Exception $e){
				return back()->with('error','Something went wrong');
			}
		}
		
		if(!empty($category)){
			$categories = $this->categoryTypeList();
			$categoryList = Category::where(['status' => 1, 'parent_id' => 0])->get(['id','title']);
			return view('admins.dropdowns.edit_category',compact('category','categoryList','categories'));
		}else{
			return redirect('admins/category');
		}			
	}
	
	public function products(Request $request){
		$conditions = array();
		$cond = array();
		if($request->input('product_name') != ''){
			$cond['product_name'] = array('product_name', 'like', '%'.$request->input('product_name').'%');
		}
		if($request->input('status') != ''){
			$cond['status'] = array('status', $request->input('status'));
		}
		$i = 0;
		foreach($cond as $value){
			$conditions[$i] = $value;
			$i++;
		}
		$pages = Products::where($conditions)->latest()->paginate(PAGE_LIMIT);
		return view('admins.dropdowns.products',compact('pages'));
	}
	
	public function add_product(Request $request){
		$postData = $request->all();
		if(!empty($postData)){
			$request->validate([
				'price' => 'required',
				'product_name' => 'required|unique:products',
				'quantity' => 'required',
				'keywords' => 'required'
			],[
				'price.required' => 'Please enter product price',
				'product_name.required' => 'Please enter product name.',
				'product_name.unique' => 'Product already exists.',
				'quantity.required' => 'Please enter product quantity',
				'keywords.required' => 'Please enter product keywords.'
			]);
			
			try {				
				$status = 0;
				if(isset($request->status)){
					$status = 1;	
				}
	
				$product = new Products;
				$product->category_id = $request->parent_id;
				$product->product_name = $request->product_name;
				$product->description = $request->description;
				$product->price = $request->price;
				$product->slug = Str::slug($request->product_name);
				$product->quantity = $request->quantity;
				$product->keywords = $request->keywords;
				$product->seo_title = $request->seo_title;
				$product->seo_keywords = $request->seo_keywords;
				$product->seo_description = $request->seo_description;
				$product->robot_tags = $request->robot_tags;
				$product->status = $status;
				$product->save();	
				return redirect('admins/products')->with('success','Product has been created successfully');	
			}
			catch(\Exception $e){
				//print_r($e->getMessage());die;
				return back()->with('error','Something went wrong');
			}			
		}
		$categories = $this->categoryTypeList();
		$categoryList = Category::where(['status' => 1, 'parent_id' => 0])->get(['id','title']);
		return view('admins.dropdowns.add_product',compact('categoryList','categories'));	
	}
	
	public function edit_product(Request $request, $id){
		$product = Products::where('id',Crypt::decrypt($id))->first();
		$postData = $request->all();
		if(!empty($postData)){
			$request->validate([
				'price' => 'required',
				'product_name' => 'required|unique:products,product_name,'.$product->id,
				'quantity' => 'required',
				'keywords' => 'required'
			],[
				'price.required' => 'Please enter product price',
				'product_name.required' => 'Please enter product name.',
				'product_name.unique' => 'Product already exists.',
				'quantity.required' => 'Please enter product quantity',
				'keywords.required' => 'Please enter product keywords.'
			]);
			try {
				$status = 0;
				if(isset($request->status)){
					$status = 1;	
				}
				if(isset($postData['ordering']) && !empty($postData['ordering'])){
					foreach($postData['ordering'] as $keys => $vals){
						$productImage = ProductImages::find($postData['orderingEditId'][$keys]);
						$productImage->ordering = $vals;
						$productImage->save();
					}
				}
	
				$product = Products::find($product->id);
				$product->category_id = $request->parent_id;
				$product->product_name = $request->product_name;
				$product->description = $request->description;
				$product->price = $request->price;
				$product->slug = Str::slug($request->product_name);
				$product->quantity = $request->quantity;
				$product->keywords = $request->keywords;
				$product->seo_title = $request->seo_title;
				$product->seo_keywords = $request->seo_keywords;
				$product->seo_description = $request->seo_description;
				$product->robot_tags = $request->robot_tags;
				$product->status = $status;
				if(empty($product->sku)){
					$sku = $this->productCode($product->product_name, $product->id);
					$product->sku = $sku;
				}
				$product->save();
				return back()->with('success','Product has been updated successfully');
			}
			catch(\Exception $e){
				//print_r($e->getMessage());die;
				return back()->with('error','Something went wrong');
			}			
		}
		if(isset($product->id)){
			$productImages = ProductImages::where('product_id',$product->id)->orderBy('ordering','asc')->get();
			if($productImages->count() > 0){
				$i=1;
				foreach($productImages as $key=> $image){
					$productImage = ProductImages::find($image->id);
					$productImage->image_alt = ucwords($product->product_name).' '.$key+1;
					$productImage->image_title = ucwords($product->product_name).' '.$key+1;
					$productImage->save();
				}
			}						
			$productImages = ProductImages::where(['product_id' => $product->id])->get();
			$categories = $this->categoryTypeList();
			$categoryList = Category::where(['status' => 1, 'parent_id' => 0])->get(['id','title']);
			return view('admins.dropdowns.edit_product',compact('categoryList','categories','product','productImages'));
		}else{
			return redirect('admins/products');
		}
	}
	
				
	public function upload_product_images(Request $request){
		if($request->ajax()){
			$postData = $request->all();
			$msg = '';
            if(!empty($_FILES)){
                $msg = "Error";
                $fileName = $_FILES['file']['name']; //Get the image
                $file_full = base_path().'/public/assets/images/admin/products/';
				$actual_image_name2 = time().rand().'.'.$request->file->extension();  
                $file_temp_name = $_FILES['file']['tmp_name'];
                $pathInfo = pathinfo(basename($fileName));
                $ext = $pathInfo['extension'];
                $checkImage = getimagesize($file_temp_name);				
                if($checkImage !== false){
                    if($request->file->move($file_full, $actual_image_name2)){
						$max_order = ProductImages::where('product_id', $_REQUEST['pid'])->max('ordering');
						if($max_order == ''){
							$ordering = 1;
						}else{
							$ordering = $max_order+1;
						}						
                        $saveData = new ProductImages;
						$saveData->product_id = $_REQUEST['pid'];
                        $saveData->image_name = $actual_image_name2;
						$saveData->ordering = $ordering;
						$saveData->save();	
                        $msg = $actual_image_name2;
                    }
                }
            }
            echo $msg;
        }
        exit;
	}
	
	public function delete_product_image(Request $request){
		if($request->ajax()){
			$postData = $request->all();
			$msg = '';
			if(isset($postData) && !empty($postData)){
				$ids = Crypt::decrypt($request->input('rowId'));
				$data = ProductImages::where('id',$ids)->first();				
				$destination = base_path().'/public/assets/images/admin/products/';
				if(file_exists($destination.$data->image_name)){
					unlink($destination.$data->image_name);
				}
				ProductImages::where('id',$ids)->delete();
				$msg = "success";
			}			
			echo $msg;
		}
		exit;
	}
	
	public function contacts(Request $request){
		$conditions = array();
		$cond = array();
		if($request->input('read_status') != ''){
			$cond['read_status'] = array('read_status', $request->input('read_status'));
		}
		$i = 0;
		foreach($cond as $value){
			$conditions[$i] = $value;
			$i++;
		}
		$pages = Contacts::where($conditions)->latest()->paginate(PAGE_LIMIT);
		return view('admins.dropdowns.contacts',compact('pages'));
	}

	public function view_contact(Request $request, $id){
		$contact = Contacts::where('id',Crypt::decrypt($id))->first();
				
		if(!empty($contact)){
			Contacts::where('id', $contact->id)->update(['read_status' => 1]);
			return view('admins.dropdowns.view_contact',compact('contact'));
		}else{
			return redirect('admins/contacts');
		}			
	}
	
	public function categoryTypeList(){
		return CategoryType::where('status',1)->pluck('title','id');
	}

}