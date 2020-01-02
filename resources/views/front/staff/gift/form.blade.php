@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Thông tin khách</h4>
                        </div>
                        <div class="content">
                            <form>
                                <div class="form-group">
                                    <div class="col-md-12" style="padding-left: 6px !important">
                                        <label>Số điện thoại</label>
                                        <input type="text" class="form-control" placeholder="Số điện thoại" id="phone" value="{{$customer->phone}}" disabled >
                                    </div>
                                    <div class="col-md-12">
                                        <label>Tên</label>
                                        <input type="text" class="form-control" placeholder="Tên" id="username" value="{{$customer->fullname}}" disabled>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Mail</label>
                                        <input type="text" class="form-control" placeholder="Mail" id="email" value="{{$customer->email}}" disabled >
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Địa chỉ</label>
                                            <input type="text" class="form-control" placeholder="Địa chỉ" id="address" value="{{$customer->email}}" disabled >
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <label>Giới tính</label>
                                        <input type="text" class="form-control" placeholder="Giới Tính" id="gender" name="gender" value="{{$customer->gender==1?'Nam':'Nữ'}}" disabled >
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--THONGTINDONGHANG-->
                <div class="col-sm-7">
                    <input type="hidden" value="0" name="id">
                    <div class="panel panel-default" id="order-information">
                        <input type="hidden" value="" name="user" id="user">
                        <div class="panel-heading">
                            Thông tin quà tặng 
                            <div class="print" style="float: right;"><a href=""><i class="fa fa-print"></i></a></div>
                        </div>
                        <!-- /.panel-heading -->
                        @if(!Request::get('gift_id') || (Request::get('gift_id') && $giftuser->status != 0 && $giftuser->status != 3))
                            <div class="panel-body">
                                <form action="{{route('editProcessGift', ['id' => Request::get('gift_id')])}}" method="POST" >
                                    {{ csrf_field() }}
                                    <input type="hidden" name="email" id="email_order" value="{{Request::get('gift_id') ? $customer->email : ''}}">
                                    <div class="col-sm-12 nopadding">
                                        <div class="form-group">
                                            <label>Tên Quà Tặng</label>
                                            <input type="text" class="form-control" placeholder="Tên Quà Tặng" id="giftTitle" value="{{$gift->title}}" disabled >
                                        </div>
                                       
                                        <div class="form-group">
                                            <h5 class="text-success"><b >Số điểm : {!! $gift->point !!}</b></h5>
                                        </div>
                                        <div class="form-group">
                                            <select name="status" id="status" class="form-control">
                                                <option value="4" {{Request::get('gift_id') && $giftuser->status == 4 ? 'selected' : ''}}>Xác Nhận</option>
                                            </select>
                                        </div>
                                        <button type="submit">Xác nhận</button>
                                        @if(Request::get('gift_id'))
                                            <a href="{{route('cancelGift', ['id' => Request::get('gift_id')])}}" style="text-decoration: none"><button type="button" style="float: right;">Huỷ quà tặng</button></a>
                                        @endif
                                    </div>
                                </form>
                            </div> 
                        @endif
                    </div>
                </div>
                <!--END THONGTINDONHANG-->
            </div>
        </div>
    </div>
@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}
    {!! HTML::script('js/jquery.inputmask.min.js') !!}
    {!! HTML::script('js/jquery.inputmask.numeric.extensions.min.js') !!}
    <script type="text/javascript"> 
    loadTourData();
        function loadTourData(){
            var tour_id = document.getElementById('tour').value;
            if(tour_id){
                $.ajax({
                    type: 'GET',
                    dataType: 'html',
                    url: '/staff/order/ajax-tour?tour_id=' + tour_id + '&gift_id=' + '<?php echo(Request::get('gift_id'))?>',
                    success: function (response) {
                        $('#loadTourData').html(response);
                        getStarDate(null);
                    }
                });
            }
        }
    </script>
@stop