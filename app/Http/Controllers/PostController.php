<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use App\Slider;
use App\Post;
use App\CatePost;
use App\Http\Requests;
use App\Product;
use Toastr;
use Illuminate\Support\Facades\Redirect;
session_start();

class PostController extends Controller
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
    public function add_post(){
        $this->AuthLogin();
        $cate_post = CatePost::orderBy('cate_post_id','DESC')->get(); 
        return view('admin.post.add_post')->with(compact('cate_post'));
    	

    }
    public function all_post(){
        $this->AuthLogin();
    	$all_post = Post::with('cate_post')->orderBy('post_id')->paginate(10);
    	
    	return view('admin.post.list_post')->with(compact('all_post',$all_post));

    }
    public function save_post(Request $request){
        $this->AuthLogin();
    	// $data = $request->all();
        // $post = new Post();
        // $post->post_title = $data['post_title'];
        // $post->post_slug = $data['post_slug'];
        // $post->post_content = $data['post_content'];
        // $post->post_meta_keywords = $data['post_meta_keywords'];
        // $post->post_meta_desc = $data['post_meta_desc'];
        // $post->post_desc = $data['post_desc'];
        // $post->cate_post_id = $data['cate_post_id'];
        // $post->post_status = $data['post_status'];
        // $post->post_image = $data['post_image'];
    	
        // $get_image = $request->file('post_image');
      
        // if($get_image){
        //     $get_name_image = $get_image->getClientOriginalName();
        //     $name_image = current(explode('.',$get_name_image));
        //     $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        //     $get_image->move('/public/uploads/post',$new_image);
        //     $post->post_image = $new_image;
        //     $post->save();
        //     Session::put('message','Thêm bài viết thành công');
        //     return redirect()->back();
        // }
        //     // $post->save();
        //     Session::put('message','Thêm bài viết thành công');
        //     return redirect()->back();

        $data=$request->all();
        $post=new Post();
        $post->post_title = $data['post_title'];
        $post->post_slug = $data['post_slug'];
        $post->post_content = $data['post_content'];
        $post->post_meta_keywords = $data['post_meta_keywords'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->post_desc = $data['post_desc'];
        $post->cate_post_id = $data['cate_post_id'];
        $post->post_status = $data['post_status'];
        $post->post_image = $data['post_image'];
    	
        $get_image = $request->file('post_image');
        $path='public/uploads/post';
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $post->post_image = $new_image;
        }
        $post->save();
        Toastr::success('Thêm bài viết thành công','Thành công');
        return redirect()->back();
    } 
    
    public function edit_post($post_id){
        $post=Post::find($post_id);
        $cate_post = CatePost::orderBy('cate_post_id')->get(); 
        return view('admin.post.edit_post')->with(compact('post','cate_post'));
    }
    public function update_post(Request $request,$post_id){
         $this->AuthLogin();
         $data=$request->all();
         $post=Post::find($post_id);
         $post->post_title = $data['post_title'];
         $post->post_slug = $data['post_slug'];
         $post->post_content = $data['post_content'];
         $post->post_meta_keywords = $data['post_meta_keywords'];
         $post->post_meta_desc = $data['post_meta_desc'];
         $post->post_desc = $data['post_desc'];
         $post->cate_post_id = $data['cate_post_id'];
         $post->post_status = $data['post_status'];
         $post->post_image = $data['post_image'];
         
         $get_image = $request->file('post_image');
         $path='public/uploads/post';
         if($get_image){
            $post_image_old = $post->post_image;
            $path1 ='public/uploads/post'.$post_image_old;
            unlink($path1);

             $get_name_image = $get_image->getClientOriginalName();
             $name_image = current(explode('.',$get_name_image));
             $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
             $get_image->move($path,$new_image);
             $post->post_image = $new_image;
         }
         $post->save();
         Toastr::success('Cập nhật bài viết thành công','Thành công');
         return redirect()->back();
    }
    public function delete_post($post_id){
        $this->AuthLogin();
        $post = Post::find($post_id);
        $post_image=$post->post_image;
        if($post_image){
            $path='public/uplads/post/'.$post_image;
        }
        $post->delete();

        Toastr::success('Xóa bài viết thành công','Thành công');
        return redirect()->back();
    }


    public function danh_muc_bai_viet(Request $request,$post_slug){
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();
         //slide
         $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
 
         $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
         $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
 
         $catepost = CatePost::where('cate_post_slug',$post_slug)->take(1)->get();

         //seo 
         foreach($catepost as $key =>$cate){
         $meta_desc = $cate->cate_post_desc; 
         $meta_keywords = $cate->cate_post_slug;
         $meta_title = $cate->cate_post_name;
         $cate_id = $cate->cate_post_id;
         $url_canonical = $request->url();
         //--seo
         }

         $post = Post::where('post_status',0)->where('cate_post_id',$cate_id)->paginate(10);
 
 
         return view('pages.baiviet.danhmucbaiviet')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
         ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)
         ->with('post',$post)->with('category_post',$category_post);
    }

    public function bai_viet(Request $request,$post_slug){
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();
         //slide
         $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
 
         $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
         $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
 
        $post = Post::where('post_status',0)->where('post_slug',$post_slug)->take(1)->get();
         //seo 
         foreach($post as $key =>$p){
         $meta_desc = $p->post_meta_desc; 
         $meta_keywords = $p->post_meta_keywords;
         $meta_title = $p->post_title;
         $cate_id = $p->cate_post_id;
         $post_id = $p->post_id;
         $url_canonical = $request->url();
         //--seo
         }

        $all_post=Post::where('post_id',$post_id)->first();
        $all_post->post_views=$all_post->post_views + 1;
        $all_post->save();
 
         return view('pages.baiviet.baiviet')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
         ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)
         ->with('post',$post)->with('category_post',$category_post)->with('all_post',$all_post);
    }
}
