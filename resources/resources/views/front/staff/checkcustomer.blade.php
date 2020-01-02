@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')
    <style> .ui-datepicker {
            z-index: 1004!important;
        }</style>
    <div id="page-wrapper">

        <div class="row">
            {!! Form::open(['url' => 'staff/checkCustomer', 'method' => 'post', 'class' => '']) !!}
            <div class="col-md-3 col-xs-12 input-group panel-heading  pull-left ">
                <input type="text" class="form-control" placeholder="Tên khách hàng" name="string" value="{!! Input::get('string')!!}">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
            </div>
            <div class="col-md-3 col-xs-12 input-group panel-heading  pull-left ">
                <input type="text" class="form-control" placeholder="Năm sinh" name="DOB" value="{!! Input::get('DOB')!!}">
                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
            </div>
            <div class="col-md-3 col-xs-12 input-group panel-heading  pull-left ">
                <input type="text" class="form-control" placeholder="Email" name="email" value="{!! Input::get('email')!!}">
                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
            </div>
            <div class="col-md-3 col-xs-12  input-group panel-heading  pull-left ">
                <input type="text" class="form-control" placeholder="Điên thoại" name="phone" value="{!! Input::get('phone')!!}">
                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>

            </div>

            <!-- /input-group -->
            <div class="col-md-12 panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="panel-heading">
                            Tổng hợp khách hàng
                            <div class="pull-right">

                            </div>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>
                                    STT
                                </th>
                                <th>
                                    Họ tên
                                </th>
                                <th>
                                    Năm sinh
                                </th>
                                <th>
                                    Số điện thoại
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Tour đã đi / Ngày
                                </th>
                                <th>
                                    Tổng cộng (Số lần đi)
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($customers))
                            @foreach($customers as $index=>$customer)
                                @if(property_exists ( $customer  , 'order' ))
                                <tr>
                                    <td>
                                        {!! $index+1 !!}
                                    </td>
                                    <td>
                                        {!! $customer->fullname !!}
                                    </td>
                                    <td>
                                        {!! $customer->DOB !!}
                                    </td>
                                    <td>
                                        {!! $customer->phone !!}
                                    </td>
                                    <td>
                                        {!! $customer->email !!}
                                    </td>
                                    <th>
                                        <a href="{!! asset('staff/editorder/'.$customer->order->id)!!}" title="Đi tới hóa đơn này ">{!! $customer->order->startdate->tour->title !!}</a>
                                         /
                                        <?php echo Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $customer->order->startdate->startdate)->format('d-m-Y');
                                        ?>
                                        /
                                        {!! $customer->order->staff->fullname !!}
                                    </th>
                                    <th>
                                        {!! $customer->total !!}
                                    </th>
                                </tr>
                                @endif
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Chọn quà cho khách hàng </h4>
                </div>
                <div class="modal-body" id="gift-list">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info  reset">Reset</button>
                    <button type="button" class="btn btn-primary" onclick="updateGift(this)">Chọn</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="giftHistory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Lịch sử nhận quà </h4>
                </div>
                <div class="modal-body" id="gift-history">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="customerOrder">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Lịch sử các hóa đơn</h4>
                </div>
                <div class="modal-body" id="customer-order">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- /#page-wrapper -->
@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}
    <script>

    </script>

@stop
@section('ready')
    $('[title]').tooltip();
@stop