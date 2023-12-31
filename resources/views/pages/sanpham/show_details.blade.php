@extends('layout')
@section('content')
@foreach($product_details as $key => $value)
<input type="hidden" id="product_viewed_id" value="{{$value->product_id}}">
<input type="hidden" id="viewed_productname{{$value->product_id}}" value="{{$value->product_name}}">
<input type="hidden" id="viewed_producturl{{$value->product_id}}" value="{{url('/chi-tiet/'.$value->product_slug)}}">
<input type="hidden" id="viewed_productimage{{$value->product_id}}" value="{{asset('public/uploads/product/'.$value->product_image)}}">
<input type="hidden" id="viewed_productprice{{$value->product_id}}" value="{{number_format($value->product_price,0,',','.').' '.'VNĐ'}}">
<div class="product-details"><!--product-details-->
<a href="{{URL::to('/')}}" style ="color:#00adc4"class="btn btn-default fa fa-heart-o" aria-hidden="true" >Trang chủ</a>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb" style="background:none">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Trang chủ</a></li>
		<li class="breadcrumb-item"><a href="{{url('/danh-muc/'.$cate_slug)}}">{{$product_cate}}</a></li>
		<li class="breadcrumb-item active" aria-current="page">{{$meta_title}}</li>
    </ol>
</nav>
						<div class="col-sm-5">
							<div class="view-product">
								<img src="{{URL::to('/public/uploads/product/'.$value->product_image)}}" alt="" />
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">

										<div class="item active">
										  <a href=""><img src="{{URL::to('public/frontend/images/cat1.jpg')}}" alt=""></a>
										  <a href=""><img src="{{URL::to('public/frontend/images/cat2.jpg')}}" alt=""></a>
										</div>
										
									</div>

								  <!-- Controls -->
								  <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div>

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
								<h2>{{$value->product_name}}</h2>
								<p>Mã ID: {{$value->product_id}}</p>
								<img src="images/product-details/rating.png" alt="" />
								
								<form action="{{URL::to('/save-cart')}}" method="POST">
									@csrf
									<input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">

                                            <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">

                                            <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">

                                            <input type="hidden" value="{{$value->product_quantity}}" class="cart_product_quantity_{{$value->product_id}}">

                                            <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">
                                          
								<span>
									<span>{{number_format($value->product_price,0,',','.').'VNĐ'}}</span>
								
									<label>Số lượng:</label>
									<input name="qty" type="number" min="1" class="cart_product_qty_{{$value->product_id}}"  value="1" />
									<input name="productid_hidden" type="hidden"  value="{{$value->product_id}}" />
								</span>
								<input type="button" value="Thêm giỏ hàng" class="btn btn-primary btn-sm add-to-cart" data-id_product="{{$value->product_id}}" name="add-to-cart">
								</form>

								<p><b>Tình trạng:</b> Còn hàng</p>
								<p><b>Điều kiện:</b> Mơi 100%</p>
								<p><b>Số lượng kho còn:</b> {{$value->product_quantity}}</p>
								<p><b>Thương hiệu:</b> {{$value->brand_name}}</p>
								<p><b>Danh mục:</b> {{$value->category_name}}</p>
								<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
						</div>
</div><!--/product-details-->

					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#chitiet" data-toggle="tab">Chi tiết sản phẩm</a></li>
								<li><a href="#mota" data-toggle="tab">Mô tả sản phẩm</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="chitiet" >
								<p>{!!$value->product_desc!!}</p>
								
							</div>
							
							<div class="tab-pane fade" id="mota" >
								<p>{!!$value->product_content!!}</p>
								
						
							</div>
							

						</div>
					</div><!--/category-tab-->
	@endforeach
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">Sản phẩm liên quan</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">
							@foreach($relate as $key => $lienquan)
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
		                                        <div class="productinfo text-center product-related">
												<form>
                                                @csrf
                                                <input type="hidden" value="{{$lienquan->product_id}}" class="cart_product_id_{{$lienquan->product_id}}">
                                                <input type="hidden" id="viewed_productname{{$lienquan->product_id}}" value="{{$lienquan->product_name}}" class="cart_product_name_{{$lienquan->product_id}}">
                                              
                                                <input type="hidden" value="{{$lienquan->product_quantity}}" class="cart_product_quantity_{{$lienquan->product_id}}">
                                                
                                                <input type="hidden" value="{{$lienquan->product_image}}" class="cart_product_image_{{$lienquan->product_id}}">
                                                <input type="hidden" id="viewed_productprice{{$lienquan->product_id}}" value="{{$lienquan->product_price}}" class="cart_product_price_{{$lienquan->product_id}}">
                                                <input type="hidden" value="1" class="cart_product_qty_{{$lienquan->product_id}}">
    
                                                <a id="viewed_producturl{{$lienquan->product_id}}" href="{{URL::to('/chi-tiet/'.$lienquan->product_slug)}}">
                                                    <img id="viewed_productimage{{$lienquan->product_id}}" src="{{URL::to('public/uploads/product/'.$lienquan->product_image)}}" alt="" />
                                                    <h2>{{number_format($lienquan->product_price,0,',','.').' '.'VNĐ'}}</h2>
                                                    <p>{{$lienquan->product_name}}</p> 
                                                 </a>
                                                <input type="button" value="Thêm giỏ hàng" class="btn btn-default add-to-cart" data-id_product="{{$lienquan->product_id}}" name="add-to-cart">
                                                </form>
		                                            <!-- <img src="{{URL::to('public/uploads/product/'.$lienquan->product_image)}}" alt="" />
		                                            <h2>{{number_format($lienquan->product_price,0,',','.').' '.'VNĐ'}}</h2>
		                                            <p>{{$lienquan->product_name}}</p>
													<input type="button" value="Thêm giỏ hàng" class="btn btn-default add-to-cart" data-id_product="{{$lienquan->product_id}}" name="add-to-cart"> -->
		                                        </div> 
                                			</div>
										</div>
									</div>
							@endforeach		

								
								</div>
									
							</div>
									
						</div>
					</div><!--/recommended_items-->
					{{--   <ul class="pagination pagination-sm m-t-none m-b-none">
                       {!!$relate->links()!!}
                      </ul> --}}

@endsection