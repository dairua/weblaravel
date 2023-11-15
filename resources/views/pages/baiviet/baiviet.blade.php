@extends('layout')
@section('content')
<div class="features_items">
                        <h2 style="margin:0;position:inherit;font-size:22px" class="title text-center">{{$meta_title}}</h2>  
                            <div class="product-image-wrapper" style="border:none;">
                            @foreach($post as $key => $p)
                                <div class="single-products" style="margin: 10px 0;padding: 2px">
                                        {!!$p->post_content!!}
                                </div>
                                <div class="clearfix"></div>
                            @endforeach
                            </div>
                    </div>
@endsection