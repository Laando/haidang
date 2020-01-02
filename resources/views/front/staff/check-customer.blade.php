@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">                            
                            <p class="category">Nhập số điện thoại khách hàng</p>
                            <form class="searchform cf" action="" method="GET" style="padding-bottom: 20px">
                                <input type="text" name="phone" placeholder="Tìm khách hàng" value="{{Request::get('phone') ? Request::get('phone') : ''}}">
                                <button type="submit">Search</button>
                            </form>
                        </div>
                        @if($user)
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>TÊN</th>
                                            <th>ĐIỆN THOẠI</th>
                                            <th>ĐIỂM THƯỞNG</th>
                                            <th>TỔNG NGƯỜI</th>
                                            <th>EMAIL</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$user->fullname}}</td>
                                                <td>{{$user->phone}}</td>
                                                <td>{{$user->point}} điểm</td>
                                                <td>{{$user->totalseat()}} NGƯỜI</td>
                                                <td>{{$user->email}}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                @if(count($orders))
                                    <div class="pull-right link">{{ $orders->appends(Request::all())->links() }}</div>
                                    <div class="content table-responsive table-full-width"><p style="padding: 10px">QUÝ KHÁCH ĐÃ ĐĂNG KÝ {{count($orders)}} CHƯƠNG TRÌNH</p>
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>TÊN TOUR</th>
                                                    <th>NGÀY ĐẶT</th>
                                                    <th>NGÀY KHỞI HÀNH</th>
                                                    <th>MÃ ĐƠN HÀNG</th>
                                                    <th>TÌNH TRẠNG</th>
                                                    <th>CHI TIẾT</th>
                                                </tr></thead>
                                                <tbody>
                                                    @foreach($orders as $index => $order)
                                                    <tr>
                                                        <td>{{$index + 1}}</td>
                                                        <td><a href="{{asset($order->tourstaff->slug)}}"> {{$order->tourstaff->title}} </a></td>
                                                        <td>
                                                            <?php 
                                                                $created_at = date_format(date_create($order->created_at),'d/m/Y');
                                                                $now = date_format(\Carbon\Carbon::now(),'d/m/Y');
                                                                if($created_at == $now): 
                                                                    $created_at = $order->created_at->diffInHours(\Carbon\Carbon::now(), false);
                                                            ?>
                                                                    {{ $created_at == 0 ? 'Vừa xong' : $created_at . 'h trước' }}
                                                            <?php
                                                                else: 
                                                            ?>
                                                                    {{ $created_at }}
                                                            <?php
                                                                endif;
                                                            ?>
                                                            <br/>
                                                        </td>
                                                        <td>{!! date_format(date_create($order->startdate->startdate),'d/m/Y') !!}</td>
                                                        <td>{{$order->order_code}}</td>
                                                        <td>{!! getStatusOrder($order->status) !!}</td>
                                                        <td><a href="{{route('processOrder') . '?order_id=' . $order->id}}"> XEM</a><a></a></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="pull-right link">{{ $orders->appends(Request::all())->links() }}</div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}
@stop
