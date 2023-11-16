@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhật thông tin liên hệ
                        </header>
                         <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
                        <div class="panel-body">

                            <div class="position-center">
                                @foreach($contact as $key => $val)
                                <form role="form" action="{{URL::to('/update-infor/'.$val->info_id)}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thông tin liên hệ</label>
                                    <textarea style="resize: none" data-validation="length" data-validation-length="min10" data-validation-error-msg="Làm ơn điền ít nhất 10 ký tự" rows="8" id="ckeditor"class="form-control" name="info_contact" id="exampleInputPassword1" placeholder="Thông tin liên hệ">{{$val->info_contact}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bản đồ</label>
                                    <textarea style="resize: none" data-validation="length" data-validation-length="min10" data-validation-error-msg="Làm ơn điền ít nhất 10 ký tự" rows="8" class="form-control" name="info_map" id="exampleInputPassword1" placeholder="Bản đồ">{{$val->info_map}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fanpage</label>
                                    <textarea style="resize: none" data-validation="length" data-validation-length="min10" data-validation-error-msg="Làm ơn điền ít nhất 10 ký tự" rows="8" class="form-control" name="info_fanpage" id="exampleInputPassword1" placeholder="Fanpage">{{$val->info_fanpage}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh logo</label>
                                    <input type="file" name="info_image"  class="form-control" id="exampleInputEmail1">
                                    <img src="{{URL::to('public/uploads/contact/'.$val->info_logo)}}" height="100" width="100">
                                </div>
                               
                                <button type="submit" name="add_category_product" class="btn btn-info">Cập Nhật liên hệ</button>
                                </form>
                                @endforeach
                            </div>

                        </div>
                    </section>

            </div>
@endsection