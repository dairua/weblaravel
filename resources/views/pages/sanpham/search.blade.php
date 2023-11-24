@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
<a href="{{URL::to('/')}}" style ="color:#00adc4"class="btn btn-default fa fa-heart-o" aria-hidden="true" >Trang chủ</a>
                        <h2 class="title text-center">Kết quả tìm kiếm</h2>
                       @foreach($search_product as $key => $product)
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                             <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_slug)}}">
                                <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                            <h2>{{number_format($product->product_price).' '.'VNĐ'}}</h2>
                                            <p>{{$product->product_name}}</p>
                                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                                        </div>
                                      
                                </div>
                            </a>
                                
                            </div>
                        </div>
                        @endforeach
                    </div><!--features_items--> 
        <!--/recommended_items-->
@endsection