<?php

namespace App\Providers;
use App\Order;
use App\Post;
use App\Product;
use App\Customer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*',function($view){
            $product = Product::all()->count();
            $post = Post::all()->count();
            $order = Order::all()->count();
            $customer = Customer::all()->count();

            $view->with('product',$product)->with('post',$post)->with('order',$order)->with('customer',$customer);
        });
    }
}
