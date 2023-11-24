<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Mail;
use Carbon\Carbon;
use App\Slider;
use App\Customer;
use App\Catepost;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

session_start();

class HomeController extends Controller
{
    public function error_page(){
        return view('errors.404');
    }
    public function index(Request $request){
        //CategoryPost
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();

        //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        //seo 
        $meta_desc = "Chuyên bán các sản phẩm handmade chính hãng"; 
        $meta_keywords = "handmade phương anh, handmade phuong anh";
        $meta_title = "Handmade Phương Anh";
        $url_canonical = $request->url();
        //--seo
        
    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

        
        $all_product = DB::table('tbl_product')->where('product_status','0')->orderby(DB::raw('RAND()'))->paginate(6); 

    	return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)->with('slider',$slider)->with('category_post',$category_post); //1
        // return view('pages.home')->with(compact('cate_product','brand_product','all_product')); //2
    }

    public function search(Request $request){
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();
         //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        //seo 
        $meta_desc = "Tìm kiếm sản phẩm"; 
        $meta_keywords = "Tìm kiếm sản phẩm";
        $meta_title = "Tìm kiếm sản phẩm";
        $url_canonical = $request->url();
        //--seo
        $keywords = $request->keywords_submit;

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get(); 


        return view('pages.sanpham.search')->with('category_post',$category_post)->with('category',$cate_product)->with('brand',$brand_product)->with('search_product',$search_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider);

    }
    public function autocomplete_ajax(Request $request){
        $data = $request->all();
        if($data['query']){
            $product=Product::where('product_status',0)->where('product_name','LIKE','%'.$data['query'].'%')->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach($product as $key => $val){
                $output .= '
                <li><a href="#">'.$val->product_name.'</a></li>
                ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
}
