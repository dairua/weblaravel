<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Mail;
use Carbon\Carbon;
use App\Slider;
use App\Customer;
use App\Catepost;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
class MailController extends Controller
{

    public function send_mail(){
        //send mail
               $to_name = "Phạm Đại";
               $to_email = "pdai20032k1@gmail.com";//send to this email
              
            
               $data = array("name"=>"Mail từ tài khoản Khách hàng","body"=>'Mail gửi về vấn về hàng hóa'); //body of mail.blade.php
               
               Mail::send('pages.send_mail',$data,function($message) use ($to_name,$to_email){
                   $message->to($to_email)->subject('Test thử gửi mail google');//send this mail with subject
                   $message->from($to_email,$to_name);//send from this mail
               });
               // return redirect('/')->with('message','');
               //--send mail
   }

   public function recover_pass(Request $request){
    $data=$request->all();
    $now= Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
    $title_mail="Lấy lại mật khẩu Handmade Shop".' '.$now;
    $customer =Customer::where('customer_email','=',$data['email_account'])->get();

    foreach($customer as $key=>$value){
        $customer_id=$value->customer_id;
    }
    if($customer){
        $count_customer = $customer->count();
        if($count_customer==0){
            return redirect()->back()->with('error','Email chưa được đăng kí');
        }else{
            $token_random = Str::random();
            $customer = Customer::find($customer_id);
            $customer->customer_token = $token_random;
            $customer->save();

            $to_email = $data['email_account'];
            $link_reset_pass = url('/update-new-pass?email='.$to_email.'&token='.$token_random);

            $data = array("name"=>$title_mail,"body"=>$link_reset_pass,'email'=>$data['email_account']);

            Mail::send('pages.checkout.forget_pass_notify',['data'=>$data],function($message) use ($title_mail,$data){
                $message->to($data['email'])->subject($title_mail);
                $message->from($data['email'],$title_mail);
            });
            return redirect()->back()->with('message','Gửi mail thành công. Vui lòng vào email để reset password !');
        }
        
    }
}
public function reset_new_pass(Request $request){
    $data=$request->all();
    $token_random = Str::random();
    $customer =Customer::where('customer_email','=',$data['email'])->where('customer_token','=',$data['token'])->get();
    $count = $customer->count();
    if($count>0){
        foreach($customer as $key => $cus){
            $customer_id=$cus->customer_id;
        }
        
        $reset=Customer::find($customer_id);
        $reset->customer_password=md5($data['password_account']);
        $reset->customer_token=$token_random;
        $reset->save();

        return redirect('dang-nhap')->with('message','Mật khẩu đã được cập nhật');

    }else{

        return redirect('quen-mat-khau')->with('error','Vui lòng nhập lại email');
        
    }
}
public function update_new_pass(Request $request){
    //CategoryPost
    $category_post = CatePost::orderBy('cate_post_id','DESC')->get();

    //slide
    $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
    //seo 
    $meta_desc = "Quên Mật Khẩu"; 
    $meta_keywords = "Quên Mật Khẩu";
    $meta_title = "Quên Mật Khẩu";
    $url_canonical = $request->url();
    //--seo
    
    $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
    $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

    
    $all_product = DB::table('tbl_product')->where('product_status','0')->orderby(DB::raw('RAND()'))->paginate(6); 

    return view('pages.checkout.new_pass')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)
    ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
    ->with('url_canonical',$url_canonical)->with('slider',$slider)->with('category_post',$category_post); 
    
}
public function quen_mat_khau(Request $request){
    //CategoryPost
    $category_post = CatePost::orderBy('cate_post_id','DESC')->get();

    //slide
    $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
    //seo 
    $meta_desc = "Quên Mật Khẩu"; 
    $meta_keywords = "Quên Mật Khẩu";
    $meta_title = "Quên Mật Khẩu";
    $url_canonical = $request->url();
    //--seo
    
    $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
    $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

    
    $all_product = DB::table('tbl_product')->where('product_status','0')->orderby(DB::raw('RAND()'))->paginate(6); 

    return view('pages.checkout.forget_pass')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)
    ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
    ->with('url_canonical',$url_canonical)->with('slider',$slider)->with('category_post',$category_post); 
    
}
}
