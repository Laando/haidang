<div class="col-md-12">Khách hàng : <strong>{!! $customer->fullname==''?$customer->phone:$customer->fullname !!}</strong></div>
<div class="clearfix"></div>
<div class="col-md-12">Danh sách quà</div>
<div class="row">
    <?php $gifts = $customer->gifts?>
    <div class="col-md-6">Tên</div><div class="col-md-2">Điểm</div> <div class="col-md-2">Số lượng</div><div class="col-md-2">Ngày</div>
    @foreach($gifts as $gift)
        <div class="col-md-6">{!! $gift->title !!}</div>
        <div class="col-md-2">{!! $gift->point !!}</div>
        <div class="col-md-2">{!! $gift->pivot->amount !!}</div>
        <div class="col-md-2">{!! date_format(date_create($gift->pivot->create_at ),'d/m/Y') !!}</div>
    @endforeach
</div>
<div class="alert-danger notice"></div>