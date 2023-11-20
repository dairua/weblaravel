<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Slider;
use CategoryProductModel;
use Session;
use Auth;
use App\CatePost;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CategoryPost extends Controller
{
    public function AuthLogin(){
        // $admin_id = Auth::id();
        if(Session::get('login_normal')){
        $admin_id=Session::get('admin_id');
        }else{
            $admin_id = Auth::id();
        }
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_category_post(){
        $this->AuthLogin();
    	return view('admin.categorypost.add_category');
    }
    public function all_category_post(){
        $this->AuthLogin();
        $category_post = CatePost::orderBy('cate_post_id','DESC')->paginate(5);
    	
    	return view('admin.categorypost.list_category')->with(compact('category_post'));


    }
    public function save_category_post(Request $request){
        $this->AuthLogin();
    	$data = $request->all();
        $category_post = new CatePost();
        $category_post->cate_post_name= $data['cate_post_name'];
        $category_post->cate_post_slug= $data['cate_post_slug'];
        $category_post->cate_post_desc= $data['cate_post_desc'];
        $category_post->cate_post_status= $data['cate_post_status'];
        $category_post->save();
    	Toastr::success('Thêm danh mục bài viết thành công','Thành công');
    	return redirect()->back();
    }
    public function edit_category_post($category_post_id){
        $this->AuthLogin();
        $category_post = CatePost::find($category_post_id);
        return view('admin.categorypost.edit_category')->with(compact('category_post'));
    }
        
    public function update_category_post(Request $request,$cate_id){
        $data = $request->all();
        $category_post = CatePost::find($cate_id);
        $category_post->cate_post_name= $data['cate_post_name'];
        $category_post->cate_post_slug= $data['cate_post_slug'];
        $category_post->cate_post_desc= $data['cate_post_desc'];
        $category_post->save();
    	Toastr::success('Cập Nhật danh mục bài viết thành công','Thành công');
    	Session::put('message','Cập Nhật danh mục bài viết thành công');
    	return redirect('/all-category-post');
    }
    public function unactive_category_post($cate_post_id){
        $this->AuthLogin();
        DB::table('tbl_category_post')->where('cate_post_id',$cate_post_id)->update(['cate_status'=>1]);
        Toastr::error('Không kích hoạt danh mục sản phẩm thành công','Thất bại');
        return Redirect::to('all-category-post');

    }
    public function active_category_post($cate_post_id){
        $this->AuthLogin();
        DB::table('tbl_category_post')->where('cate_post_id',$cate_post_id)->update(['cate_status'=>0]);
        Toastr::success('Kích hoạt danh mục sản phẩm thành công','Thành công');
        return Redirect::to('all-category-post');

    }
    
    public function delete_category_post($cate_id){
        $category_post = CatePost::find($cate_id);
        $category_post->delete();
    	Toastr::success('Xóa danh mục bài viết thành công','Thành công');
    	return redirect()->back();
    }

    //Home
    public function danh_muc_bai_viet($cate_post_slug){

    }

}
