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
use App\Models\User;
use App\Models\Gallery;
 
class GalleryController extends Controller{

	public function gallery(Request $request){
		$galleries = Gallery::latest()->paginate(20);	
		return view('admins.gallery.gallery',compact('galleries'));
	}
	
	public function upload_gallery_images(Request $request){
		if($request->ajax()){
            if(!empty($_FILES)){
                $msg = "Error";
                $fileName = $_FILES['file']['name']; //Get the image
                $file_full = base_path().'/public/assets/images/admin/gallery/'; //Image storage path
                $file_temp_name = $_FILES['file']['tmp_name'];
                $pathInfo = pathinfo(basename($fileName));
                $ext = $request->file->extension();
                $checkImage = getimagesize($file_temp_name);
				$actual_image_name = date('d_m_Y_H_i_'.mt_rand(111, 999).'_a.').$request->file->extension();
				$destination2 = base_path().'/public/assets/images/admin/gallery/';
                if($checkImage !== false){
					if($request->file->move($destination2, $actual_image_name)){
						$gallery = new Gallery();
						$gallery->image = $actual_image_name;
						$gallery->save();
						$msg = "Success";
					}
                }
            }
            echo json_encode(array('msg' => $msg));
        }
        exit;
	}

	public function delete_gallery_image(Request $request){
		if($request->ajax()){
			$msg = 'Error';
			$postData = $request->all();
			if(isset($postData) & !empty($postData)){
				$table = $request->input('Gallery');
				$ids = Crypt::decrypt($request->input('rowId'));
				$record = Gallery::where(['id' => $ids])->first();
				if(isset($record->id)){
					$destination = base_path().'/public/assets/images/admin/gallery/';
					if(file_exists($destination.$record->image)){
						unlink($destination.$record->image);
					}
					Gallery::where('id',$ids)->delete();
				}
				$msg = "Success";
			}
			echo json_encode(array('msg' => $msg));
		}
		exit;
	}
	
	public function deleteProductImage(){
		$this->viewBuilder()->setLayout('false');
        if($this->request->is(AJAX)){
            $postData = $this->request->getData();
            if(!empty($postData)){
                $rowId = $this->decryptData($postData['rowId']);
                $table = TableRegistry::get(PRODUCTIMAGES);
                $deleteRecord = $table->find()->where(array(ID => $rowId))->first();
                $imageName = $deleteRecord->image_name;
                if(file_exists(WWW_ROOT.'img/products/'.$imageName)){
                    unlink(WWW_ROOT.'img/products/'.$imageName);
                }
                $record = $table->get($rowId);
                $table->delete($record);
            }
        }
        exit;	
	}

}