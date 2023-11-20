<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Social;
use Socialite;
use App\Login;
use Auth;
use Toastr;
use Carbon\Carbon;
use App\Order;
use App\Post;
use App\Product;
use App\Customer;
use App\Statistic;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Rules\Captcha; 
class AdminController extends Controller
{
    public function login_google(){
        return Socialite::driver('google')->redirect();
    }
    public function callback_google(){
            $users = Socialite::driver('google')->stateless()->user(); 
            // // return $users->id;
            // return $users->name;
            // return $users->email;
            $authUser = $this->findOrCreateUser($users,'google');
            if($authUser){
            $account_name = Login::where('admin_id',$authUser->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('login_normal',true);
            Session::put('admin_id',$account_name->admin_id);
            }elseif($customer_new){
                $account_name = Login::where('admin_id',$authUser->user)->first();
                Session::put('admin_name',$account_name->admin_name);
                Session::put('login_normal',true);
                Session::put('admin_id',$account_name->admin_id);
            }
            Toastr::success('Đăng nhập Admin thành công','Thành công');
            return redirect('/dashboard');  
    }
    public function findOrCreateUser($users, $provider){
            $authUser = Social::where('provider_user_id', $users->id)->first();
            if($authUser){

                return $authUser;
            }else{
            $customer_new = new Social([
                'provider_user_id' => $users->id,
                'provider' => strtoupper($provider)
            ]);

            $orang = Login::where('admin_email',$users->email)->first();

                if(!$orang){
                    $orang = Login::create([
                        'admin_name' => $users->name,
                        'admin_email' => $users->email,
                        'admin_password' => '',
                        'admin_phone' => '',
                        'admin_status' => 1
                        
                    ]);
                }

            $customer_new->login()->associate($orang);
                
            $customer_new->save();
            return $customer_new;

            }

    }


    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
            //login in vao trang quan tri  
            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            Toastr::success('Đăng nhập Admin thành công','Thành công');
            return redirect('/dashboard');
        }else{

            $hieu = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_phone' => ''
                    
                ]);
            }
            $hieu->login()->associate($orang);
            $hieu->save();

            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            Toastr::success('Đăng nhập Admin thành công','Thành công');
            return redirect('/dashboard');
        } 
    }

    public function AuthLogin(){
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

    public function index(){
    	return view('admin_login');
    }
    public function show_dashboard(){
        $this->AuthLogin();
        //dashboard-backend
        $app_product = Product::all()->count();
        $app_post = Post::all()->count();
        $app_order = Order::all()->count();
        $app_customer = Customer::all()->count();
        
        $product_views = Product::orderBy('product_views','DESC')->take(20)->get();
        
        $post_views=Post::orderBy('post_views','DESC')->take(5)->get();
        
    	return view('admin.dashboard')->with(compact('app_product','app_post','app_order','app_customer','product_views','post_views'));
    }

    public function dashboard_filter(Request $request){
        $data = $request->all();
        $dauthangnay= Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc= Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc= Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days= Carbon::now('Asia/Ho_Chi_Minh')->subMonth(7)->toDateString();
        $sub365days= Carbon::now('Asia/Ho_Chi_Minh')->subMonth(365)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        if($data['dashboard_value']=='7ngay'){
            $get = Statistic::whereBetween('order_date',[$sub7days,$now])->orderBy('order_date','ASC')->get();
        }elseif($data['dashboard_value']=='thangtruoc'){
            $get = Statistic::whereBetween('order_date',[$dau_thangtruoc,$cuoi_thangtruoc])->orderBy('order_date','ASC')->get();
        }elseif($data['dashboard_value']=='thangnay'){
            $get = Statistic::whereBetween('order_date',[$dauthangnay,$now])->orderBy('order_date','ASC')->get();
        }else{
            $get = Statistic::whereBetween('order_date',[$sub365days,$now])->orderBy('order_date','ASC')->get();
        }

        foreach($get as $key =>$val){
            $chart_data[]= array(
                'period'=>$val->order_date,
                'order'=>$val->total_order,
                'sales'=>$val->sales,
                'profit'=>$val->profit,
                'quantity'=>$val->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function days_order(){
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(30)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistic::whereBetween('order_date',[$sub30days,$now])->orderBy('order_date','ASC')->get();

        foreach($get as $key =>$val){
            $chart_data[]= array(
                'period'=>$val->order_date,
                'order'=>$val->total_order,
                'sales'=>$val->sales,
                'profit'=>$val->profit,
                'quantity'=>$val->quantity
            );
        }
        echo $data = json_encode($chart_data);

    } 

    public function filter_by_date(Request $request){
        $data = $request->all();
        $form_date = $data['form_date'];
        $to_date = $data['to_date'];

        $get=Statistic::whereBetween('order_date',[$form_date,$to_date])->orderBy('order_date','ASC')->get();
        foreach($get as $key =>$val){
            $chart_data[]= array(
                'period'=>$val->order_date,
                'order'=>$val->total_order,
                'sales'=>$val->sales,
                'profit'=>$val->profit,
                'quantity'=>$val->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }
    public function order_date(Request $request){
        $order_date = $_GET['date'];
        $order = Order::where('order_date',$order_date)->orderBy('created_at','DESC')->get();
        return view('admin.order_date')->with(compact('order'));
    }
    public function dashboard(Request $request){
        //$data = $request->all();
        $data = $request->validate([
            //validation laravel 
            'admin_email' => 'required',
            'admin_password' => 'required',
            'g-recaptcha-response' => new Captcha(),    //dòng kiểm tra Captcha
        ]);

        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);
        $login = Login::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($login){
            $login_count = $login->count();
            if($login_count>0){
                Session::put('admin_name',$login->admin_name);
                Session::put('admin_id',$login->admin_id);
                return Redirect::to('/dashboard');
            }
        }else{
                Toastr::error('Mật khẩu hoặc tài khoản bị sai.Làm ơn nhập lại','Thất bại');
                return Redirect::to('/admin');
        }
       

    }
    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        Toastr::success('Đăng xuất admin thành công','Thành công');
        return Redirect::to('/admin');
    }
}
