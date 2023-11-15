@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
<a href="{{URL::to('/')}}" style ="color:#00adc4"class="btn btn-default fa fa-heart-o" aria-hidden="true" >Trang chủ</a>
                        <h2 class="title text-center">Liên hệ với shop của chúng tôi</h2>
                        @foreach($contact as $key => $val)
                        <div class="row">
                            <div class="col-md-12">
                                {!!$val->info_contact!!}
                                {!!$val->info_fanpage!!}
                            </div>
                            <div class="col-md-12">
                                <h4>Bản đồ</h4>
                                {!!$val->info_map!!}
                            </div>
                        </div>
                        @endforeach
</div>                     
@endsection