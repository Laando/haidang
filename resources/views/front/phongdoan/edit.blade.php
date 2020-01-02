@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#startDate" ).datepicker({dateFormat:'yy-mm-dd'});
  } );
  </script>
    <style>
        .event a {
            background-color: #42B373 !important;
            background-image :none !important;
            color: #ffffff !important;
        }
    </style>
<div id="page-wrapper">

    <div class="timkiem-tour-ql clearfix">
        {!! Form::open(['url' => 'staff', 'method' => 'post', 'class' => 'form-horizontal panel sky-form']) !!}
        <div class="col-sm-3  bs-example" data-example-ids="select-form-control">
                <select name="staff" class="form-control">
                    <option value="">Người phụ trách</option>
                    {{--@foreach($staffs as $staff)--}}
                        {{--<option value="{!! $staff->id !!}" {!! $request!=null&&$request['staff']==$staff->id?'selected="selected"':'' !!}>{!! $staff->fullname !!}</option>--}}
                    {{--@endforeach--}}
                </select>
        </div><!-- /.bs-example -->
        <div class="col-sm-3 bs-example" data-example-ids="select-form-control">
                <select name="destinationpoint" class="form-control">
                    <option value="">Tất Cả Đơn Đặt Hàng</option>
                    {{--@foreach($tour as $t )--}}
                    {{--<option value="{!! $t->idself_tour !!}" {!! $request!=null&&$request['destinationpoint']==$destinationpoint->id?'selected="selected"':'' !!}>{!! $destinationpoint->title !!}</option>--}}
                    {{--@endforeach--}}
                </select>
        </div><!-- /.bs-example -->
        <div class="col-sm-2 bs-example" data-example-ids="select-form-control">
            <fieldset>
                <div class="row">
                    <section>
                        <label class="input">
                            <i class="icon-append fa fa-calendar"></i>
                            {{--<input type="text" name="start" id="start" placeholder="Chọn lịch khởi hành" {!! $request!=null?'value="'.$request['start'].'"':'' !!}>--}}
                        </label>
                    </section>
                </div>
            </fieldset>
        </div><!-- /.bs-example -->
        <button type="submit" class="btn btn-warning">TÌM</button>
        {!! Form::close() !!}
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                       
     <form method="post" action="{{ url('/phong-doan/update/idself_tour='.$tour[0]->idself_tour )}}" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        @if(session('thongbao'))
        <div class="alert alert-success">{{session('thongbao')}}</div>
        @endif
        <div class="form-group">
          <label for="ma">Mã Self Tour</label>
          <input type="text" name="ma" disabled="disabled" value="{{$tour[0]->idself_tour}}" class="form-control" id="ma" placeholder="Mã Self Tour">
        </div>
        <div class="form-group">
          <label for="ten">Tên Khách Hàng</label>
          <input type="text" name="ten" disabled="disabled" value="{{$tour[0]->name}}" class="form-control" id="ten" placeholder="Tên Khách Hàng">
        </div>
        <div class="form-group">
          <label for="ten">Số Điện Thoại</label>
          <input type="text" name="phone" value="{{$tour[0]->phone}}" class="form-control" id="phone" placeholder="SĐT">
        </div>
        <div class="form-group">
          <label for="ten">Email</label>
          <input type="text" name="email" value="{{$tour[0]->mail}}" class="form-control" id="email" placeholder="Email">
        </div>
        <div class="form-group">
          <label for="ten">Địa Chỉ</label>
          <input type="text" name="address" value="{{$tour[0]->address}}" class="form-control" id="address" placeholder="Địa Chỉ">
        </div>
        <div class="form-group">
          <label for="ten">Điểm đến</label>
          <input type="text" name="des" value="{{$tour[0]->destination}}" class="form-control" id="des" placeholder="Điểm đến">
        </div>
        <div class="form-group">
          <label for="ten">Số Sao Dịch Vụ</label>
          <input type="text" name="star" value="{{$tour[0]->star}}" class="form-control" id="star" placeholder="Sao">
        </div>
        <div class="form-group">
          <label for="ten">Ngày khởi hành</label>
          <input type="text" name="startDate" value="{{$tour[0]->start_date}}" class="form-control" id="startDate" placeholder="Ngày khởi hành">
        </div>
        <div class="form-group">
          <label for="ten">Ngày Nhận Thông Tin</label>
          <input readonly type="text" name="receiveDate" value="{{$tour[0]->receive_date}}" class="form-control" id="receiveDate" placeholder="Ngày Nhận Thông Tin">
        </div>
        <div class="form-group">
          <label for="ten">Số Lượng Người Lớn</label>
          <input type="text" name="nguoiLon" value="{{$tour[0]->nguoiLon}}" class="form-control" id="nguoiLon" placeholder="Người Lớn">
        </div>
        <div class="form-group">
          <label for="ten">Số Lượng Trẻ Em</label>
          <input type="text" name="treEm" value="{{$tour[0]->treEm}}" class="form-control" id="treEm" placeholder="Trẻ Em">
        </div>
        <div class="form-group">
          <label for="ten">Phương Tiện</label>
            <select class="form-control" name="phuongTien" id="">
                <option value="{{$tour[0] -> idtypeVehicle}}">{{$tour[0]->vehicle}}</option>
                @foreach ($vehicle as $v)
                    <option  value="{{$v -> idtypeVehicle}}"> {{ $v->vehicle }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
          <label for="ten">Số Lượng Xe</label>
          <input type="text" name="countXe" value="{{$tour[0]->countXe}}" class="form-control" id="countXe" placeholder="Số Lượng Xe">
        </div>

        <div class="form-group">
          <label for="ten" style="color: red;">Tổng Giá tiền (*)</label>
          <input type="text" name="totalPrice" value="{{$tour[0]->totalPrice}}" class="form-control" id="totalPrice" placeholder="Số tiền">
        </div>
        <div class="form-group">
          <label for="ten">Tổng số lượng khách</label>
          <input type="text" name="totalSeat" value="{{$tour[0]->totalCount}}" class="form-control" id="totalSeat" placeholder="Ngày khởi hành">
        </div>
        <div class="form-group">
          <label for="ten">Nhân Viên Phụ Trách</label>
          <input type="hidden" name="idemployee" value="{{$user->id}}">
          <input readonly type="text" name="employee" value="{{$user->username}}" class="form-control" id="employee" placeholder="Nhân Viên">
        </div>

        <button type="submit" name="gui" class="btn btn-success">Sửa</button>
        <a href="{{url('/phong-doan/')}}"  class="btn btn-danger">Bỏ qua</a>
      </form>


                    </div>

                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->

        
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div> 
<!-- /#wrapper -->

@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}
    {!! HTML::script('js/jquery.inputmask.min.js') !!}
    {!! HTML::script('js/jquery.inputmask.numeric.extensions.min.js') !!}
    {!! HTML::script('js/staff.js') !!}
@stop
