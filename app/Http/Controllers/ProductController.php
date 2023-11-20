<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use App\Slider;
use App\Http\Requests;
use App\Catepost;
use App\Product;
use Toastr;
use Illuminate\Support\Facades\Redirect;
session_start();
class ProductController extends Controller
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
    public function add_product(){
        $this->AuthLogin();
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get(); 
       

        return view('admin.add_product')->with('category_post',$category_post)->with('cate_product', $cate_product)->with('brand_product',$brand_product)->with('category_post', $category_post);
    	

    }
    public function all_product(){
        $this->AuthLogin();
    	$all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->orderby('tbl_product.product_id','desc')->paginate(5);
    	$manager_product  = view('admin.all_product')->with('all_product',$all_product);
    	return view('admin_layout')->with('admin.all_product', $manager_product);

    }
    public function save_product(Request $request){
        $this->AuthLogin();
    	$data = array();
        $product_price=filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $price_cost=filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
    	$data['product_name'] = $request->product_name;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_slug'] = $request->product_slug;
    	$data['product_price'] = $product_price;
        $data['price_cost'] = $price_cost;
    	$data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $data['product_image'] = $request->product_image;
        $data['product_sold'] = 1;
        $get_image = $request->file('product_image');
      
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->insert($data);
            Toastr::success('Thêm sản phẩm thành công','Thành công');
            return Redirect::to('add-product');
        }
        $data['product_image'] = '';
    	DB::table('tbl_product')->insert($data);
    	Toastr::error('Thêm sản phẩm thất bại','Thất bại');
    	return Redirect::to('all-product');
        
        // $sp = new Product;
        // $sp->product_name = $request->product_name;
        // $sp->product_quantity = $request->product_quantity;
        // $sp->product_slug = $request->product_slug;
        // $sp->product_price = $request->product_price;
        // $sp->product_desc = $request->product_desc;
        // $sp->product_content = $request->product_content;
        // $sp->category_id = $request->product_cate;
        // $sp->brand_id = $request->product_brand;
        // $sp->product_status = $request->product_status;
        // $sp->product_sold = 1;
        // $sp->product_image = 'acxcxc';

        // $get_image = $request->file('product_image');
        
        // $sp->save();
        // return Redirect::to('all-product');
    }
    public function unactive_product($product_id){
         $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>1]);
        Toastr::error('Không kích hoạt sản phẩm thành công','Thất bại');
        return Redirect::to('all-product');

    }
    public function active_product($product_id){
         $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>0]);
        Toastr::success('Kích hoạt sản phẩm thành công','Thành công');
        return Redirect::to('all-product');
    }
    public function edit_product($product_id){
         $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get(); 

        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();

        $manager_product  = view('admin.edit_product')->with('edit_product',$edit_product)->with('cate_product',$cate_product)->with('brand_product',$brand_product);

        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }
    public function update_product(Request $request,$product_id){
         $this->AuthLogin();
        $data = array();
        $product_price=filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $price_cost=filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $data['product_name'] = $request->product_name;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_slug'] = $request->product_slug;
        $data['product_price'] = $product_price;
        $data['price_cost'] = $price_cost;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image');
        
        if($get_image){
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.',$get_name_image));
                    $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                    $get_image->move('public/uploads/product',$new_image);
                    $data['product_image'] = $new_image;
                    DB::table('tbl_product')->where('product_id',$product_id)->update($data);
                    // Session::put('message','Cập nhật sản phẩm thành công');
                    Toastr::success('Cập nhật sản phẩm thành công','Thành công');
                    return Redirect::to('all-product');
        }
            
        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        // Session::put('message','Cập nhật sản phẩm thất bại');
        Toastr::error('Cập nhật sản phẩm thất bại','Thất bại');
        return Redirect::to('all-product');
    }
    public function delete_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Toastr::success('Xóa sản phẩm thành công','Thành công');
        return Redirect::to('all-product');
    }
    //End Admin Page
    public function details_product($product_slug , Request $request){
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();
         //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

        $details_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_slug',$product_slug)->get();

        foreach($details_product as $key => $value){
            $category_id = $value->category_id;
            $product_id = $value->product_id;
            $product_cate=$value->category_name;
            $cate_slug=$value->slug_category_product;
                //seo 
                $meta_desc = $value->product_desc;
                $meta_keywords = $value->product_slug;
                $meta_title = $value->product_name;
                $url_canonical = $request->url();
                //--seo
            }

            $product=Product::where('product_id',$product_id)->first();
            $product->product_views=$product->product_views + 1;
            $product->save();
       
        $related_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.product_slug',[$product_slug])->orderby(DB::raw('RAND()'))->paginate(3);


        return view('pages.sanpham.show_details')->with('category_post', $category_post)->with('category',$cate_product)->with('brand',$brand_product)->with('product_details',$details_product)->with('relate',$related_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)
        ->with('product_cate',$product_cate)->with('cate_slug',$cate_slug);

    }
}
