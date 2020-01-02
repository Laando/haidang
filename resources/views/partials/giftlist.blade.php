<div class="col-md-12">Các khách hàng được chọn</div>
<div>
@foreach($customers as $cus)
    <strong>{!! $cus->fullname==''?$cus->phone:$cus->fullname !!}</strong> ;
    <input type="hidden" name="customerid" value="{!! $customer->id !!}"/>
@endforeach
</div>
<input type="hidden" name="isMulti" value="{!! $customers->count()>1?'1':'0'  !!}"/>
<input type="hidden" name="less" value="{!! $customer->point  !!}"/>
<div class="clearfix"></div>
<div class="col-md-12">Danh sách quà</div>
<div class="row">
    <div class="col-md-6">Tên</div><div class="col-md-3">Điểm</div> <div class="col-md-3">Số lượng</div>
    @foreach($gifts as $gift)
        <div class="col-md-6">{!! $gift->title !!}</div>
        <div class="col-md-3">{!! $gift->point !!}</div>
        <div class="col-md-3"><input class="form-control" name="amount" value="" placeholder="0" type="number" data-point="{!! $gift->point !!}"/></div>
    @endforeach
</div>
<div class="alert-danger notice"></div>