<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\City;
use App\Province;
use App\Wards;
use App\Feeship;
use App\Slider;
use App\Shipping;
use App\Order;
use Carbon\Carbon;
use App\Catepost;
use App\OrderDetails;
use App\Coupon;

class CheckoutController extends Controller
{
    public function vnpay_payment(Request $request){
        $data = $request->all();
        $code_cart=rand(00,9999);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/Laravel/Mylaravel/checkout";
        $vnp_TmnCode = "SU9IZWJM";
        $vnp_HashSecret = "HGKOAOOEVDXKWLQWDYVPELUQWWADLHLF";

        $vnp_TxnRef = $code_cart; 
        $vnp_OrderInfo = 'Thanh toán đơn hàng Test';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $data['total_vnpay'] * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
            }
    public function confirm_order(Request $request){
         $data = $request->all();

         $shipping = new Shipping();
         $shipping->shipping_name = $data['shipping_name'];
         $shipping->shipping_email = $data['shipping_email'];
         $shipping->shipping_phone = $data['shipping_phone'];
         $shipping->shipping_address = $data['shipping_address'];
         $shipping->shipping_notes = $data['shipping_notes'];
         $shipping->shipping_method = $data['shipping_method'];
         $shipping->save();
         $shipping_id = $shipping->shipping_id;
         
         $checkout_code = substr(md5(microtime()),rand(0,26),5);
         
         $coupon = Coupon::where('coupon_code', '=', $data['order_coupon'])->first();
         if ($coupon && $coupon->coupon_number > 0) {
            $coupon->coupon_number -= 1;
            $coupon->save();
         }
         
         $order = new Order;
         $order->customer_id = Session::get('customer_id');
         $order->shipping_id = $shipping_id;
         $order->order_status = 1;
         $order->order_code = $checkout_code;

         date_default_timezone_set('Asia/Ho_Chi_Minh');
         $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
         $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
         $order->created_at = $today;
         $order->order_date = $order_date;
         $order->save();

         if(Session::get('cart')==true){
            foreach(Session::get('cart') as $key => $cart){
                $order_details = new OrderDetails;
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon =  $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
         }

         Session::forget('coupon');
         Session::forget('fee');
         Session::forget('cart');
    }
    public function del_fee(){
        Session::forget('fee');
        return redirect()->back();
    }

     public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function calculate_fee(Request $request){
        $data = $request->all();
        if($data['matp']){
            $feeship = Feeship::where('fee_matp',$data['matp'])->where('fee_maqh',$data['maqh'])->where('fee_xaid',$data['xaid'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship>0){
                     foreach($feeship as $key => $fee){
                        Session::put('fee',$fee->fee_feeship);
                        Session::save();
                    }
                }else{ 
                    Session::put('fee',25000);
                    Session::save();
                }
            }
           
        }
    }
    public function select_delivery_home(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                    $output.='<option>---Chọn quận huyện---</option>';
                foreach($select_province as $key => $province){
                    $output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }

            }else{

                $select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                $output.='<option>---Chọn xã phường---</option>';
                foreach($select_wards as $key => $ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                }
            }
            echo $output;
        }
    }
    public function view_order($orderId){
        $this->AuthLogin();
        
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_details.*')->first();

        $manager_order_by_id  = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
        
    }
    public function login_checkout(Request $request){
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();
         //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        //seo 
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 

    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

    	return view('pages.checkout.login_checkout')->with('category_post', $category_post)->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider);
    }
    public function add_customer(Request $request){

        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();

    	$data = array();
    	$data['customer_name'] = $request->customer_name;
    	$data['customer_phone'] = $request->customer_phone;
    	$data['customer_email'] = $request->customer_email;
    	$data['customer_password'] = md5($request->customer_password);

    	$customer_id = DB::table('tbl_customers')->insertGetId($data);

    	Session::put('customer_id',$customer_id);
    	Session::put('customer_name',$request->customer_name);
    	return Redirect::to('/checkout')->with('category_post', $category_post);


    }
    public function checkout(Request $request){
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();
         //seo 
         //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 

    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        $city = City::orderby('matp','ASC')->get();

    	return view('pages.checkout.show_checkout')->with('category_post', $category_post)->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('city',$city)->with('slider',$slider);
    }
    public function save_checkout_customer(Request $request){
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();
    	$data = array();
    	$data['shipping_name'] = $request->shipping_name;
    	$data['shipping_phone'] = $request->shipping_phone;
    	$data['shipping_email'] = $request->shipping_email;
    	$data['shipping_notes'] = $request->shipping_notes;
    	$data['shipping_address'] = $request->shipping_address;

    	$shipping_id = DB::table('tbl_shipping')->insertGetId($data);

    	Session::put('shipping_id',$shipping_id);
    	
    	return Redirect::to('/payment')->with('category_post', $category_post);
    }
    public function payment(Request $request){
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();
        //seo 
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        return view('pages.checkout.payment')->with('category_post', $category_post)->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);

    }
    public function order_place(Request $request){
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();
        //insert payment_method
        //seo 
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //insert order_details
        $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }
        if($data['payment_method']==1){

            echo 'Thanh toán thẻ ATM';

        }elseif($data['payment_method']==2){
            Cart::destroy();

            $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
            return view('pages.checkout.handcash')->with('category_post', $category_post)->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);

        }else{
            echo 'Thẻ ghi nợ';

        }
        
        //return Redirect::to('/payment');
    }
    public function logout_checkout(){
    	Session::forget('customer_id');
    	return Redirect::to('/dang-nhap');
    }
    public function login_customer(Request $request){
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();

    	$email = $request->email_account;
    	$password = md5($request->password_account);
    	$result = DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();
    	
    	
    	if($result){
    		Session::put('customer_id',$result->customer_id);
    		return Redirect::to('/');
    	}else{
    		return Redirect::to('/dang-nhap');
    	}
        Session::save();
        return view('pages.checkout.login_checkout')->with('category_post', $category_post);

    }
    public function manage_order(){
        
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->select('tbl_order.*','tbl_customers.customer_name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manager_order  = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order', $manager_order);
    }
}
