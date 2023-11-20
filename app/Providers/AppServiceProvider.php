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
            $app_product = Product::all()->count();
            $app_post = Post::all()->count();
            $app_order = Order::all()->count();
            $app_customer = Customer::all()->count();

            $view->with('app_product',$app_product)->with('app_post',$app_post)->with('app_order',$app_order)->with('app_customer',$app_customer);
        });
    }
}
