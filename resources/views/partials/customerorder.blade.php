<div class="col-md-12">Khách hàng : <strong>{!! $customer->fullname==''?$customer->phone:$customer->fullname !!}</strong></div>
<div class="clearfix"></div>
<div class="col-md-12">Danh sách quà</div>
<div class="row">
    <?php $orders = $customer->orders()->where('status','!=',0)->latest()->get()?>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Tên tour</th>
                <th>Mã đơn hàng</th>
                <th class="text-center">Ngày đặt</br>Ngày khởi hành</th>
                <th>Số lượng</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td><a href="{!! asset('staff/editorder/'.$order->id) !!}" target="_blank">{!! $order->startdate->tour->title !!}</a></td>
                    <td>HD{!! $order->id !!}</td>
                    <td class="text-center">{!! date_format(date_create($order->created_at),'d/m/Y') !!}
                        <br/>
                        <strong class="alert-danger">{!! date_format(date_create($order->startdate->startdate),'d/m/Y') !!}</strong>
                    </td>
                    <td>NL : {!! $order->adult !!}<br/>TE : {!! $order->childlist!=''?count(explode(';',trim($order->childlist,';'))):'0' !!}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
</div>
<div class="alert-danger notice"></div>