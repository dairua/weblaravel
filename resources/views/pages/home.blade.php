@extends('layout')

@section('slider')
 @include('pages.include.slider');
@endsection

@section('content')
<div class="features_items"><!--features_items-->
<a href="{{URL::to('/')}}" style ="color:#00adc4"class="btn btn-default fa fa-heart-o" aria-hidden="true" >Trang chủ</a>
                        <h2 class="title text-center">Sản phẩm mới nhất</h2>
                        @foreach($all_product as $key => $product)
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                           
                                <div class="single-products">
                                        <div class="productinfo text-center">
                                            <form>
                                                @csrf
                                            <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                            <input type="hidden" id="viewed_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                          
                                            <input type="hidden" value="{{$product->product_quantity}}" class="cart_product_quantity_{{$product->product_id}}">
                                            
                                            <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                            <input type="hidden" id="viewed_productprice{{$product->product_id}}" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                            <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">

                                            <a id="viewed_producturl{{$product->product_id}}" href="{{URL::to('/chi-tiet/'.$product->product_slug)}}">
                                                <img id="viewed_productimage{{$product->product_id}}" src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                                <h2>{{number_format($product->product_price,0,',','.').' '.'VNĐ'}}</h2>
                                                <p>{{$product->product_name}}</p> 
                                             </a>
                                            <input type="button" value="Thêm giỏ hàng" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">
                                            </form>
                                            <style type="text/css">
                                                p.qrcode_style{
                                                    position: absolute;
                                                    top:2%;
                                                    left:3%;
                                                }
                                            </style>

                                            @php
                                            $qrcode_url = url('chi-tiet/'.$product->product_slug);
                                            @endphp
                                            <p class="qrcode_style">{{QrCode::size(50)->generate($qrcode_url)}}</p>
                                        </div>
                                      
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div><!--features_items-->
                      <ul class="pagination pagination-sm m-t-none m-b-none">
                       {!!$all_product->links()!!}
                      </ul>
        <!--/recommended_items-->
@endsection