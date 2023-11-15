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
use Illuminate\Support\Facades\Redirect;
session_start();

class PostController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
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
    	$all_post = Post::orderBy('post_id')->paginate(10);
    	
    	return view('admin.post.list_post')->with(compact('all_post',$all_post));

    }
    public function save_post(Request $request){
        $this->AuthLogin();
    	$data = $request->all();
        $post = new Post();
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
      
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('/public/uploads/post',$new_image);
            $post->post_image = $new_image;
            $post->save();
            Session::put('message','Thêm bài viết thành công');
            return redirect()->back();
        }
            // $post->save();
            Session::put('message','Thêm bài viết thành công');
            return redirect()->back();

            // $this->AuthLogin();
            // $data = array();
            // $data['post_title'] = $request->post_title;
            // $data['post_slug'] = $request->post_slug;
            // $data['post_content'] = $request->post_content;
            // $data['post_meta_keywords'] = $request->post_meta_keywords;
            // $data['post_meta_desc'] = $request->post_meta_desc;
            // $data['post_desc'] = $request->post_desc;
            // $data['cate_post_id'] = $request->cate_post_id;
            // $data['post_status'] = $request->post_status;
            // $data['post_image'] = $request->post_image;
           
            // $get_image = $request->file('post_image');
          
            // if($get_image){
            //     $get_name_image = $get_image->getClientOriginalName();
            //     $name_image = current(explode('.',$get_name_image));
            //     $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            //     $get_image->move('public/uploads/post',$new_image);
            //     $data['post_image'] = $new_image;
            //     DB::table('tbl_posts')->insert($data);
            //     Session::put('message','Thêm bài viết thành công');
            //     return Redirect::to('add-post');
            // }
            // $data['post_image'] = '';
            // DB::table('tbl_posts')->insert($data);
            // Session::put('message','Thêm bài viết thành công');
            // return Redirect::to('all-post');
    } 
    
    // public function edit_product($product_id){
    //      $this->AuthLogin();
    //     $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get(); 
    //     $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get(); 

    //     $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();

    //     $manager_product  = view('admin.edit_product')->with('edit_product',$edit_product)->with('cate_product',$cate_product)->with('brand_product',$brand_product);

    //     return view('admin_layout')->with('admin.edit_product', $manager_product);
    // }
    // public function update_product(Request $request,$product_id){
    //      $this->AuthLogin();
    //     $data = array();
    //     $data['product_name'] = $request->product_name;
    //     $data['product_quantity'] = $request->product_quantity;
    //     $data['product_slug'] = $request->product_slug;
    //     $data['product_price'] = $request->product_price;
    //     $data['product_desc'] = $request->product_desc;
    //     $data['product_content'] = $request->product_content;
    //     $data['category_id'] = $request->product_cate;
    //     $data['brand_id'] = $request->product_brand;
    //     $data['product_status'] = $request->product_status;
    //     $get_image = $request->file('product_image');
        
    //     if($get_image){
    //                 $get_name_image = $get_image->getClientOriginalName();
    //                 $name_image = current(explode('.',$get_name_image));
    //                 $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
    //                 $get_image->move('public/uploads/product',$new_image);
    //                 $data['product_image'] = $new_image;
    //                 DB::table('tbl_product')->where('product_id',$product_id)->update($data);
    //                 Session::put('message','Cập nhật sản phẩm thành công');
    //                 return Redirect::to('all-product');
    //     }
            
    //     DB::table('tbl_product')->where('product_id',$product_id)->update($data);
    //     Session::put('message','Cập nhật sản phẩm thành công');
    //     return Redirect::to('all-product');
    // }
    public function delete_post($post_id){
        $this->AuthLogin();
        $post = Post::find($post_id);
        $post_image=$post->post_image;
        if($post_image){
            $path='public/uplads/post/'.$post_image;
        }
        $post->delete();

        Session::put('message','Xóa bài viết thành công');
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
         $url_canonical = $request->url();
         //--seo
         }
 
         return view('pages.baiviet.baiviet')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
         ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)
         ->with('post',$post)->with('category_post',$category_post);
    }
}
