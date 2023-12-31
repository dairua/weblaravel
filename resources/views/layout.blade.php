<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!---------Seo--------->
    <meta name="description" content="{{$meta_desc}}">
    <meta name="keywords" content="{{$meta_keywords}}"/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <link  rel="canonical" href="{{$url_canonical}}" />
    <meta name="author" content="">
    <link  rel="icon" type="image/x-icon" href="{{asset('public/frontend/images/Handmade.png')}}" size="16x16" />
    
    {{--   <meta property="og:image" content="{{$image_og}}" />  
      <meta property="og:site_name" content="http://localhost/Laravel/Mylaravel" />
      <meta property="og:description" content="{{$meta_desc}}" />
      <meta property="og:title" content="{{$meta_title}}" />
      <meta property="og:url" content="{{$url_canonical}}" />
      <meta property="og:type" content="website" /> --}}
      <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!--//-------Seo--------->
    <title>{{$meta_title}}</title>
    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/jquery-ui.min.css')}}" rel="stylesheet">

    

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{('public/frontend/images/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>

    <header id="header"><!--header-->
        <div class="header_top"><!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-phone"></i>0832905658</a></li>
                                <li><a href="#"><i class="fa fa-envelope"></i>phamdai2032k1@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header_top-->
        
        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href="index.html"><img src="{{('public/frontend/images/logohm.png')}}" alt="" /></a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
                               
                                <?php
                                   $customer_id = Session::get('customer_id');
                                   $shipping_id = Session::get('shipping_id');
                                   if($customer_id!=NULL && $shipping_id==NULL){ 
                                 ?>
                                  <li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                                
                                <?php
                                 }elseif($customer_id!=NULL && $shipping_id!=NULL){
                                 ?>
                                 <li><a href="{{URL::to('/payment')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                                 <?php 
                                }else{
                                ?>
                                 <li><a href="{{URL::to('/dang-nhap')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                                <?php
                                 }
                                ?>
                                
                                <li class="cart-hover"><a href="{{url('gio-hang')}}"><i class="fa fa-shopping-cart"></i> 
                                    Giỏ hàng
                                <span class="show-cart"></span>
                                </a></li>      
                                
                                <?php
                                   $customer_id = Session::get('customer_id');
                                   if($customer_id!=NULL){ 
                                ?>
                                <li><a href="{{URL::to('/history')}}"><i class="fa fa-history" aria-hidden="true"></i> Lịch sử đơn hàng</a></li>
                                <?php
                                }
                                ?>
                                
                                <?php
                                   $customer_id = Session::get('customer_id');
                                   if($customer_id!=NULL){ 
                                 ?>
                                  <li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-lock"></i> Đăng xuất</a>
                                <img width="15%" src="{{Session::get('customer_picture')}}">{{Session::get('customer_name')}}
                                </li>
                                
                                <?php
                                }else{
                                 ?>
                                 <li><a href="{{URL::to('/dang-nhap')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                                 <?php 
                                }
                                 ?>
                               
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-middle-->
    
        <div class="header-bottom"><!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="{{URL::to('/trang-chu')}}" class="active">Trang chủ</a></li>
                                <li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach($category as $key => $cate)
                                           @if($cate->category_parent==0)
                                           <li><a href="{{URL::to('/danh-muc/'.$cate->slug_category_product)}}">{{$cate->category_name}}</a></li>
                                           @foreach($category as $key => $cate_sub)
                                               @if($cate_sub->category_parent==$cate->category_id)
                                                  <ul class="cate_sub">
                                                    <li><a href="{{URL::to('/danh-muc/'.$cate_sub->slug_category_product)}}">{{$cate_sub->category_name}}</a></li>
                                                  </ul>
                                               @endif
                                           @endforeach
                                           @endif
                                        @endforeach
                                    </ul>
                                </li> 
                                <li class="dropdown"><a href="#">Tin tức<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach($category_post as $key => $danhmucbaiviet)
                                        <li><a href="{{URL::to('/danh-muc-bai-viet/'.$danhmucbaiviet->cate_post_slug)}}">{{$danhmucbaiviet->cate_post_name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li> 
                                <li><a href="{{URL::to('/gio-hang')}}">Giỏ hàng<span class="show-cart"></span></a></li>
                                <li><a href="{{URL::to('/lien-he')}}">Liên hệ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <form action="{{URL::to('/tim-kiem')}}" autocomplete="off" method="POST">
                            {{csrf_field()}}
                        <div class="search_box pull-right">
                            <input type="text" name="keywords_submit" id="keywords" placeholder="Tìm kiếm sản phẩm"/>
                            <div id="search_ajax">
                            <input type="submit" style="margin-top:0;color:#666" name="search_items" class="btn btn-primary btn-sm" value="Tìm kiếm">
                            </div> 
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/header-bottom-->
    </header><!--/header-->
    
    <!---slider--->
    @yield('slider')
    
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Danh mục sản phẩm</h2>
                        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                          @foreach($category as $key => $cate)
                           
                            <div class="panel panel-default">
                                @if($cate->category_parent==0)
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordian" href="#{{$cate->slug_category_product}}">
                                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                            {{$cate->category_name}}
                                        </a>
                                    </h4>
                                </div>

                                <div id="{{$cate->slug_category_product}}" class="pannel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>
                                            @foreach($category as $key => $cate_sub)
                                            @if($cate_sub->category_parent==$cate->category_id)
                                            <li><a href="{{URL::to('/danh-muc/'.$cate_sub->slug_category_product)}}">{{$cate_sub->category_name}}</a></li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif
                            </div>

                        @endforeach
                        </div><!--/category-products-->
                    
                        <div class="brands_products"><!--brands_products-->
                            <h2>Thương hiệu sản phẩm</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    @foreach($brand as $key => $brand)
                                    <li><a href="{{URL::to('/thuong-hieu/'.$brand->brand_slug)}}"> <span class="pull-right"></span>{{$brand->brand_name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div><!--/brands_products-->
                        
                        <!-- <div class="brands_products">
                            <h2>Sản phẩm đã xem</h2>
                            <div class="brands-name">
                                <div id="row_viewed" class="row"></div>
                            </div>
                        </div> -->
                    
                    </div>
                </div>
                
                <div class="col-sm-9 padding-right">

                   @yield('content')
                    
                </div>
            </div>
        </div>
    </section>
    
    <footer id="footer"><!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                @foreach($contact_footer as $key => $logo)
                    <div class="col-sm-3">
                        <div class="companyinfo">
                            <p><img width="50%"src="{{asset('public/uploads/contact/'.$logo->info_logo)}}" alt=""></p>
                            <p>{{$logo->slogan_logo}}</p>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        
        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Dịch vụ</h2>
                            <ul class="nav nav-pills nav-stacked">
                                @foreach($post_footer as $key =>$post_foot) 
                                <li><a href="{{url('/bai-viet/'.$post_foot->post_slug)}}">{{$post_foot->post_title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @foreach($contact_footer as $key => $contact_foo)
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2>Thông tin Shop</h2>
                            <div class="information_footer">
                                {!! $contact_foo-> info_contact!!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2>Fanpage</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li>{!! $contact_foo-> info_fanpage!!}</li>
                            </ul>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-sm-3 col-sm-offset-1">
                        <div class="single-widget">
                            <h2>EMAIL</h2>
                            <form action="#" class="searchform">
                                <input type="text" placeholder="Điền email của bạn..." />
                                <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                                <p>Điền Email của bạn để nhận được những thông báo mới nhất...</p>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </footer><!--/Footer-->
    
                
  
    <script src="{{asset('public/frontend/js/jquery.js')}}"></script>
    <script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/price-range.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('public/frontend/js/main.js')}}"></script>


    <script src="{{asset('public/frontend/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery-ui.min.js')}}"></script>
   {{--<script src="https://www.paypal.com/sdk/js?client-id=sb"></script>
    <script>paypal.Buttons().render('body');</script>--}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v6.0&appId=2339123679735877&autoLogAppEvents=1"></script>


<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
<script type="text/javascript">
    
    function viewed(){
        if(localStorage.getItem('viewed')!=null){
            var data=JSON.parse(localStorage.getItem('viewed'));
            data.reverse();
            document.getElementById('row_viewed').style.overflow='scroll';
            document.getElementById('row_viewed').style.height='500px';

            for(i=0;i<data.length;i++){
                var name=data[i].name;
                var price=data[i].price;
                var image=data[i].image;
                var url=data[i].url;

                $('#row_viewed').append('
                <div class="row" style="margin:10px 0">
                    <div class="col-sm-4">
                        <img width="100%" src="'+image+'">
                    </div>
                    <div class="col-sm-4 info_wishlist">
                        <p>'+name+'</p>
                        <p style="color:#FE980F">'+price+'</p>
                        <a href="'+url+'">Đặt hàng</a>
                    </div> 
                                      
                ');
                
            }
        }
    }
    viewed();
    product_viewed();
    function product_viewed(){
        var id_product = $('#product_viewed_id').val();
        if(id_product != undefined){
        var id=id_product; 
        var name=documnet.getElementById('viewed_productname'+id).value;
        var price=documnet.getElementById('viewed_productprice'+id).value;
        var image=documnet.getElementById('viewed_productimage'+id).value;
        var url=documnet.getElementById('viewed_producturl'+id).value;

        var newItem={
            'url':url,
            'id':id,
            'name':name,
            'price':price,
            'image':image
        }

        var old_data = JSON.parse(localStorage.getItem('viewed'));

        if(localStorage.getItem('viewed')==null){
            localStorage.setItem('viewed','[]');
        }

        var matches = $.grep(old_data, function(obj){
            return obj.id==id;
        });

        if(matches.length){
            
        }else{
            old_data.push(newItem);
            $('#row_viewed').append('
                <div class="row" style="margin:10px 0">
                    <div class="col-sm-4">
                        <img width="100%" src="'+newItem.image+'">
                    </div>
                    <div class="col-sm-4 info_wishlist">
                        <p>'+newItem.name+'</p>
                        <p style="color:#FE980F">'+newItem.price+'</p>
                        <a href="'+newItem.url+'">Đặt hàng</a>
                    </div>                  
                ');
        }
        localStorage.setItem('viewed',JSON.stringify(old_data));
    }
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#slider-range" ).slider({
        orientation: "horizontal",
        range: true,
        min:{{$min_price}},
        max:{{$max_price_range}},
        step:10000,
        values: [ {{$min_price}},{{$max_price}} ],
        slide: function( event, ui ) {
            $( "#amount" ).val( "đ" + ui.values[ 0 ] + " - đ" + ui.values[ 1 ] );
            $( "#start_price" ).val(ui.values[ 0 ]);
            $( "#end_price" ).val(ui.values[ 1 ] );
        }
    });
    $( "#amount" ).val( "đ" + $( "#slider-range" ).slider( "values", 0 ) +
      " - đ" + $( "#slider-range" ).slider( "values", 1 ) );
    });
</script>
<script type="text/javascript">
    $('#keywords').keyup(function(){
        var query = $(this).val();
        if(query != ''){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/autocomplete-ajax')}}",
                method:"POST",
                data:{query:query,_token:_token},
                success:function(data){
                    $('#search_ajax').fadeIn();
                    $('#search_ajax').html(data);
                }
            });
        }else(
            $('#search_ajax').fadeOut();
        )
    });
    $(document).on('click','li',function(){
        $('#keywords').val($(this).text());
        $('#search_ajax').fadeOut();
    });
</script>

    <script type="text/javascript">

          $(document).ready(function(){
            $('.send_order').click(function(){
                swal({
                  title: "Xác nhận đơn hàng",
                  text: "Đơn hàng sẽ không được hoàn trả khi đặt,bạn có muốn đặt không?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Cảm ơn, Mua hàng",

                    cancelButtonText: "Đóng,chưa mua",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                     if (isConfirm) {
                        var shipping_email = $('.shipping_email').val();
                        var shipping_name = $('.shipping_name').val();
                        var shipping_address = $('.shipping_address').val();
                        var shipping_phone = $('.shipping_phone').val();
                        var shipping_notes = $('.shipping_notes').val();
                        var shipping_method = $('.payment_select').val();

                        if (!shipping_email || !shipping_name || !shipping_address || !shipping_phone || !shipping_notes || !shipping_method) {
                            return swal("Cảnh báo", "Làm ơn hoàn thành đầy đủ các trường", "warning");
                        }
                        var order_fee = $('.order_fee').val();
                        var order_coupon = $('.order_coupon').val();
                        var _token = $('input[name="_token"]').val();

                        $.ajax({
                            url: '{{url('/confirm-order')}}',
                            method: 'POST',
                            data:{shipping_email:shipping_email,shipping_name:shipping_name,shipping_address:shipping_address,shipping_phone:shipping_phone,shipping_notes:shipping_notes,_token:_token,order_fee:order_fee,order_coupon:order_coupon,shipping_method:shipping_method},
                            success:function(){
                               swal("Đơn hàng", "Đơn hàng của bạn đã được gửi thành công", "success");
                            }
                        });

                        window.setTimeout(function(){ 
                            location.reload();
                        } ,3000);

                      } else {
                        swal("Đóng", "Đơn hàng chưa được gửi, làm ơn hoàn tất đơn hàng", "error");

                      }
              
                });

               
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
    
            //show cart
            show_cart();
            function show_cart(){
                $.ajax({
                    url:'{{url('/show-cart')}}',
                    method:"GET",

                    success:function(data){
                        $('.show-cart').html(data);
                    }
                });
            }

            $('.add-to-cart').click(function(){

                var id = $(this).data('id_product');
                // alert(id);
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
                if(parseInt(cart_product_qty)>parseInt(cart_product_quantity)){
                    alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
                }else{

                    $.ajax({
                        url: '{{url('/add-cart-ajax')}}',
                        method: 'POST',
                        data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_image:cart_product_image,cart_product_price:cart_product_price,cart_product_qty:cart_product_qty,_token:_token,cart_product_quantity:cart_product_quantity},
                        success:function(){

                            swal({
                                    title: "Đã thêm sản phẩm vào giỏ hàng",
                                    text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                    showCancelButton: true,
                                    cancelButtonText: "Xem tiếp",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Đi đến giỏ hàng",
                                    closeOnConfirm: false
                                },
                                function() {
                                    window.location.href = "{{url('/gio-hang')}}";
                                });
                                show_cart();
                                hover_cart();
                        }

                    });
                }

                
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.choose').on('change',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';
           
            if(action=='city'){
                result = 'province';
            }else{
                result = 'wards';
            }
            $.ajax({
                url : '{{url('/select-delivery-home')}}',
                method: 'POST',
                data:{action:action,ma_id:ma_id,_token:_token},
                success:function(data){
                   $('#'+result).html(data);     
                }
            });
        });
        });
          
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.calculate_delivery').click(function(){
                var matp = $('.city').val();
                var maqh = $('.province').val();
                var xaid = $('.wards').val();
                var _token = $('input[name="_token"]').val();
                if(matp == '' && maqh =='' && xaid ==''){
                    alert('Làm ơn chọn để tính phí vận chuyển');
                }else{
                    $.ajax({
                    url : '{{url('/calculate-fee')}}',
                    method: 'POST',
                    data:{matp:matp,maqh:maqh,xaid:xaid,_token:_token},
                    success:function(){
                       location.reload(); 
                    }
                    });
                } 
        });
    });
    </script>

<script type="text/javascript">
    $(document).ready(function(){   
        $('#sort').on('change',function(){
            var url=$(this).val();
            // alert(url);
            if(url){
                window.location=url;
            }
            return false;
        });
    });
</script>
  
</body>
</html>