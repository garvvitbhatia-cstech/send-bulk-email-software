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
use App\Models\InnerPages;
use App\Models\Tags;
use App\Models\FooterNavigations;
use App\Models\HeaderNavigations;
use App\Models\Cms;
 
class CmsManagementController extends Controller{

	public function inner_pages(Request $request){
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
		$pages = InnerPages::where($conditions)->latest()->paginate(PAGE_LIMIT);	
		return view('admins.cms_management.inner_pages',compact('pages'));
	}
	
	public function edit_inner_page(Request $request, $id){
		$innerpage = InnerPages::where('id',Crypt::decrypt($id))->first();				
		$postData = $request->all();
				
		if(!empty($postData)){
			$request->validate([
				'title' => 'required|unique:inner_pages,title,'.$innerpage->id,
				'description' => 'required',
			],[
				'title.required' => 'Please enter title',
				'title.unique' => 'Title already exists',
				'description.required' => 'Please enter description',
			]);
			
			try {
				$status = 0;
				if(isset($request->status)){
					$status = 1;	
				}
				$banner_status = 0;
				if(isset($request->banner_status)){
					$banner_status = 1;	
				}
				
				$banner = NULL;
				if(!empty($request->file('banner'))){
					$actual_image_name2 = time().rand().'.'.$request->banner->extension();  
					$destination2 = base_path().'/public/assets/images/admin/banners/';
					if($request->banner->move($destination2, $actual_image_name2)){
						if($request->input('old_banner') != ""){
							if(file_exists($destination2.$request->input('old_banner'))){
								unlink($destination2.$request->input('old_banner'));
							}
						}
						$banner = $actual_image_name2;
					}
				}					
							
				$innerpage = InnerPages::find($innerpage->id);
				$innerpage->title = $request->title;
				$innerpage->description = trim($request->description);
				$innerpage->banner = $banner;
				$innerpage->banner_status = $request->banner_status;
				$innerpage->heading = $request->heading;
				$innerpage->sub_heading = $request->sub_heading;
				$innerpage->edit_heading = $request->edit_heading;
				$innerpage->edit_sub_heading = $request->edit_sub_heading;
				$innerpage->edit_description = $request->edit_description;
				$innerpage->seo_title = $request->seo_title;
				$innerpage->seo_description = $request->seo_description;
				$innerpage->seo_keyword = $request->seo_keyword;
				$innerpage->robot_tags = $request->robot_tags;
				$innerpage->status = $status;
				$innerpage->save();
				return back()->with('success','Inner page has been updated successfully');	
			}
			catch(\Exception $e){
				return back()->with('error','Something went wrong');
			}	
		}
		if(!empty($innerpage)){
			return view('admins.cms_management.edit_inner_page',compact('innerpage'));
		}else{
			return redirect('admins/inner_pages');
		}
		
	}
	
	public function tags(Request $request){
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
		$pages = Tags::where($conditions)->latest()->paginate(PAGE_LIMIT);	
		return view('admins.cms_management.tags',compact('pages'));
	}
	
	public function add_tag(Request $request){			
		$postData = $request->all();				
		if(!empty($postData)){
			$request->validate([
				'title' => 'required|unique:tags,title',
			],[
				'title.required' => 'Please enter title',
				'title.unique' => 'Title already exists',
			]);
			
			try {
				$status = 0;
				if(isset($request->status)){
					$status = 1;	
				}
				$banner_status = 0;
				if(isset($request->banner_status)){
					$banner_status = 1;	
				}	
							
				$tag = new Tags();
				$tag->title = $request->title;
				$tag->status = $status;
				$tag->save();
				return redirect('admins/tags')->with('success','Tag has been created successfully');
			}
			catch(\Exception $e){
				return back()->with('error','Something went wrong');
			}
		}	
		return view('admins.cms_management.add_tag');	
	}
	
	public function edit_tag(Request $request, $id){
		$tag = Tags::where('id',Crypt::decrypt($id))->first();				
		$postData = $request->all();
				
		if(!empty($postData)){
			$request->validate([
				'title' => 'required|unique:tags,title,'.$tag->id,
			],[
				'title.required' => 'Please enter title',
				'title.unique' => 'Title already exists',
			]);
			
			try {
				$status = 0;
				if(isset($request->status)){
					$status = 1;	
				}				
							
				$tag = Tags::find($tag->id);
				$tag->title = $request->title;
				$tag->status = $status;
				$tag->save();
				return back()->with('success','Tag has been updated successfully');		
			}
			catch(\Exception $e){
				return back()->with('error','Something went wrong');
			}
		}
		
		if(!empty($tag)){
			return view('admins.cms_management.edit_tag',compact('tag'));
		}else{
			return redirect('admins/tags');
		}
		
	}
	
	public function headerNavigations(Request $request){
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
		$pages = HeaderNavigations::where($conditions)->latest()->paginate(PAGE_LIMIT);	
		return view('admins.cms_management.header_navigations',compact('pages'));
	}
	
	public function addHeaderNavigation(Request $request){			
		$postData = $request->all();				
		if(!empty($postData)){ 					
			try {
				$status = 0;
				if(isset($request->status)){
					$status = 1;	
				}
				
				$slug = NULL;
				$title = $request->title;
				if(isset($request->type) && $request->type == 'cms'){
					if(isset($request->menu_page_id) && $request->menu_page_id != ''){
						$cms_data = Cms::select(['title','id'])->where('status',1)->where('id',$request->menu_page_id)->first();
						if(isset($cms_data->id)){
							$slug = Str::slug($cms_data->title);
							if($request->title == ''){
								$title = trim($cms_data->title);
							}
						}
					}
				}							
				$navigation = new HeaderNavigations;				
				$navigation->parent_id = $request->parent_id;
				$navigation->target_window = trim($request->target_window);
				$navigation->menu_type = $request->type;
				$navigation->menu_page_id = $request->menu_page_id;				
				$navigation->title = $title;
				$navigation->slug = $slug;
				$navigation->url = $request->url;
				$navigation->seo_title = $request->seo_title;
				$navigation->seo_description = $request->seo_description;
				$navigation->seo_keyword = $request->seo_keyword;
				$navigation->robot_tags = $request->robot_tags;
				$navigation->status = $status;
				$navigation->save();
				return redirect('admins/header-navigations')->with('success','Header Navigation page has been created successfully');
			}
			catch(\Exception $e){
				return back()->with('error','Something went wrong');
			}
		}
		$cmsPageList = $this->getCmsPages();
        $headerNavigationList = $this->getHeaderNavigations();
		return view('admins.cms_management.add_header_navigation',compact('cmsPageList','headerNavigationList'));
	}
	
	public function editHeaderNavigation(Request $request, $id){
		$navigation = HeaderNavigations::where('id',Crypt::decrypt($id))->first();				
		$postData = $request->all();			
		if(!empty($postData)){		
			try {
				$status = 0;
				if(isset($request->status)){
					$status = 1;	
				}
				
				$slug = $navigation->slug;
				$title = $request->title;
				if(isset($request->type) && $request->type == 'cms'){
					if(isset($request->menu_page_id) && $request->menu_page_id != ''){
						$cms_data = Cms::select(['title','id'])->where('status',1)->where('id',$request->menu_page_id)->first();
						if(isset($cms_data->id)){
							$slug = Str::slug($cms_data->title);
							if($request->title == ''){
								$title = trim($cms_data->title);
							}
						}
					}
				}							
				$navigation = HeaderNavigations::find($navigation->id);		
				$navigation->parent_id = $request->parent_id;
				$navigation->target_window = trim($request->target_window);
				$navigation->menu_type = $request->type;
				$navigation->menu_page_id = $request->menu_page_id;				
				$navigation->title = $title;
				$navigation->slug = $slug;
				$navigation->url = $request->url;
				$navigation->seo_title = $request->seo_title;
				$navigation->seo_description = $request->seo_description;
				$navigation->seo_keyword = $request->seo_keyword;
				$navigation->robot_tags = $request->robot_tags;
				$navigation->status = $status;
				$navigation->save();
				return back()->with('success','Header Navigation page has been updated successfully');	
			}
			catch(\Exception $e){
				return back()->with('error','Something went wrong');
			}						
		}
		if(!empty($navigation)){
			$cmsPageList = $this->getCmsPages();
			$headerNavigationList = $this->getHeaderNavigations();
			return view('admins.cms_management.edit_header_navigation',compact('cmsPageList','headerNavigationList','navigation'));
		}else{
			return redirect('admins/inner_pages');
		}		
	}
	
	public function footerNavigations(Request $request){
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
		$pages = FooterNavigations::where($conditions)->latest()->paginate(PAGE_LIMIT);	
		return view('admins.cms_management.footer_navigations',compact('pages'));
	}
	
	public function addFooterNavigation(Request $request){			
		$postData = $request->all();				
		if(!empty($postData)){ 					
			try {
				$status = 0;
				if(isset($request->status)){
					$status = 1;	
				}
				
				$slug = NULL;
				$title = $request->title;
				if(isset($request->type) && $request->type == 'cms'){
					if(isset($request->menu_page_id) && $request->menu_page_id != ''){
						$cms_data = Cms::select(['title','id'])->where('status',1)->where('id',$request->menu_page_id)->first();
						if(isset($cms_data->id)){
							$slug = Str::slug($cms_data->title);
							if($request->title == ''){
								$title = trim($cms_data->title);
							}
						}
					}
				}							
				$navigation = new FooterNavigations;				
				$navigation->parent_id = $request->parent_id;
				$navigation->target_window = trim($request->target_window);
				$navigation->menu_type = $request->type;
				$navigation->menu_page_id = $request->menu_page_id;				
				$navigation->title = $title;
				$navigation->slug = $slug;
				$navigation->url = $request->url;
				$navigation->seo_title = $request->seo_title;
				$navigation->seo_description = $request->seo_description;
				$navigation->seo_keyword = $request->seo_keyword;
				$navigation->robot_tags = $request->robot_tags;
				$navigation->status = $status;
				$navigation->save();
				return redirect('admins/footer-navigations')->with('success','Footer Navigation page has been created successfully');
			}
			catch(\Exception $e){
				print_r($e->getMessage());
				die;
				return back()->with('error','Something went wrong');
			}
		}
		$cmsPageList = $this->getCmsPages();
        $footerNavigationList = $this->getFooterNavigations();
		return view('admins.cms_management.add_footer_navigation',compact('cmsPageList','footerNavigationList'));
	}
	
	public function editFooterNavigation(Request $request, $id){
		$navigation = FooterNavigations::where('id',Crypt::decrypt($id))->first();				
		$postData = $request->all();			
		if(!empty($postData)){		
			try {
				$status = 0;
				if(isset($request->status)){
					$status = 1;	
				}
				
				$slug = $navigation->slug;
				$title = $request->title;
				if(isset($request->type) && $request->type == 'cms'){
					if(isset($request->menu_page_id) && $request->menu_page_id != ''){
						$cms_data = Cms::select(['title','id'])->where('status',1)->where('id',$request->menu_page_id)->first();
						if(isset($cms_data->id)){
							$slug = Str::slug($cms_data->title);
							if($request->title == ''){
								$title = trim($cms_data->title);
							}
						}
					}
				}							
				$navigation = FooterNavigations::find($navigation->id);		
				$navigation->parent_id = $request->parent_id;
				$navigation->target_window = trim($request->target_window);
				$navigation->menu_type = $request->type;
				$navigation->menu_page_id = $request->menu_page_id;				
				$navigation->title = $title;
				$navigation->slug = $slug;
				$navigation->url = $request->url;
				$navigation->seo_title = $request->seo_title;
				$navigation->seo_description = $request->seo_description;
				$navigation->seo_keyword = $request->seo_keyword;
				$navigation->robot_tags = $request->robot_tags;
				$navigation->status = $status;
				$navigation->save();
				return back()->with('success','Footer Navigation page has been updated successfully');	
			}
			catch(\Exception $e){
				return back()->with('error','Something went wrong');
			}						
		}
		if(!empty($navigation)){
			$cmsPageList = $this->getCmsPages();
			$footerNavigationList = $this->getFooterNavigations();
			return view('admins.cms_management.edit_footer_navigation',compact('cmsPageList','footerNavigationList','navigation'));
		}else{
			return redirect('admins/inner_pages');
		}		
	}
	
	public function cms(Request $request){
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
		$pages = Cms::where($conditions)->latest()->paginate(PAGE_LIMIT);	
		return view('admins.cms_management.cms',compact('pages'));
	}
	
	public function addCms(Request $request){			
		$postData = $request->all();				
		if(!empty($postData)){ 
			try {
				$status = 0;
				if(isset($request->status)){
					$status = 1;	
				}	
				$cms = new Cms;
				$cms->title = $request->title;
				$cms->description = trim($request->description);
				$cms->seo_title = $request->seo_title;
				$cms->seo_description = $request->seo_description;
				$cms->seo_keyword = $request->seo_keyword;
				$cms->robot_tags = $request->robot_tags;
				$cms->status = $status;
				$cms->save();
				return redirect('admins/cms')->with('success','Cms page has been created successfully');
			}
			catch(\Exception $e){
				return back()->with('error','Something went wrong');
			}
		}
		$cmsPageList = $this->getCmsPages();
        $headerNavigationList = $this->getHeaderNavigations();
		return view('admins.cms_management.add_cms',compact('cmsPageList','headerNavigationList'));
	}
	
	public function editCms(Request $request, $id){
		$cms = Cms::where('id',Crypt::decrypt($id))->first();				
		$postData = $request->all();				
		if(!empty($postData)){		
			try {
				$status = 0;
				if(isset($request->status)){
					$status = 1;	
				}	
				$cms = Cms::find($cms->id);
				$cms->title = $request->title;
				$cms->description = trim($request->description);
				$cms->seo_title = $request->seo_title;
				$cms->seo_description = $request->seo_description;
				$cms->seo_keyword = $request->seo_keyword;
				$cms->robot_tags = $request->robot_tags;
				$cms->status = $status;
				$cms->save();
				return back()->with('success','Cms page has been updated successfully');	
			}
			catch(\Exception $e){
				return back()->with('error','Something went wrong');
			}	
		}
		if(!empty($cms)){
			$cmsPageList = $this->getCmsPages();
			$headerNavigationList = $this->getHeaderNavigations();
			return view('admins.cms_management.edit_cms',compact('cmsPageList','headerNavigationList','cms'));
		}else{
			return redirect('admins/cms');
		}		
	}
	
	function getCmsPages() {        
        return Cms::where('status',1)->orderBy('id','desc')->pluck('title','id');
	}
	
    function getHeaderNavigations() {
		$headerNavigationList = HeaderNavigations::where('status',1)->where('parent_id',0)->orderBy('id')->pluck('title','id');
        return $headerNavigationList;
    }
	
	function getFooterNavigations() {
		$footerNavigationList = FooterNavigations::where('status',1)->where('parent_id',0)->orderBy('id')->pluck('title','id');
        return $footerNavigationList;
    }

}