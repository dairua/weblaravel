@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê đơn hàng
    </div>
    <div class="row w3-res-tb">
     
     
    
    </div>
    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
           
            <th>Thứ tự</th>
            <th>Mã đơn hàng</th>
            <th>Ngày tháng đặt hàng</th>
            <th>Tình trạng đơn hàng</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php 
          $i = 0;
          @endphp
          @foreach($order as $key => $ord)
            @php 
            $i++;
            @endphp
          <tr>
            <td><i>{{$i}}</i></label></td>
            <td>{{ $ord->order_code }}</td>
            <td>{{ $ord->created_at }}</td>
            <td>@if($ord->order_status==1)
                    Đơn hàng mới
                @else 
                    Đã xử lý - Đang giao hàng
                @endif
            </td>
           
           
            <td>
              <a href="{{URL::to('/view-order/'.$ord->order_code)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-eye text-success text-active"></i></a>
              <a onclick="return confirm('Bạn có chắc là muốn xóa đơn đặt hàng này không?')" href="{{URL::to('/delete-order/'.$ord->order_code)}}" class="active styling-edit" ui-toggle-class=""></a>
              <div style='cursor:pointer' data-id="{{$ord->order_code}}" class="active styling-edit" ui-toggle-class="" id="delete">
                <i class="fa fa-times text-danger text"></i>
              </div>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            {!!$order->links()!!}
          </ul>
        </div>
      </div>
    </footer>
   
  </div>
</div>
@endsection

@push('js')
<script>
  $(document).ready(function() {
   $(document).on('click', '#delete', function() {
    let id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");
    if (confirm('Bạn chắc chắn muốn xoá?') == false) {
      return;
    } 
   $.ajax(
   {
       url: "/delete-order",
       type: 'POST',
       data: {
           "id": id,
           "_token": "{{ csrf_token() }}",
       },
       success: function (){
           console.log("deleted");
           location.reload();
       }
   });
   })

  })
</script>
@endpush