<a class="pull-left hide-form" data-group="{!!isset($order)?$seat->order->id:'empty' !!}">
    <i  class="fa fa-remove fa-2x" ></i>
</a>
<a class="pull-right save-form"  data-group="{!!isset($order)?$seat->order->id:'empty' !!}" data-seat="{!! $seat->number  !!}">
    <i  class="fa fa-save fa-2x" ></i>
</a>
<div class="input-group input-group-sm">
    <span class="input-group-addon" id="sizing-addon3">Tên</span>
    <input type="text" class="form-control fullname" name="fullname" placeholder="Nhập tên khách" aria-describedby="sizing-addon3" value="{!! $seat->fullname !!}">
</div>
<div class="input-group input-group-sm">
    <input type="text" class="form-control phone" name="phone" placeholder="Nhập số điện thoại" aria-describedby="sizing-addon3" value="{!! $seat->phone !!}">
    <?php
    $dt = \Carbon\Carbon::now();
    $min = $dt->year-80;
    $max = $dt->year;
    ?>
    <input type="text" max="{!! $max!!}" min="{!! $min !!}" class="form-control dob" name="dob" placeholder="Năm sinh" aria-describedby="sizing-addon3" value="{!! $seat->DOB==0?'':$seat->DOB !!}" style="width: 50%">
    <input type="text" class="form-control dealcode" name="dealcode" value="{!!$seat->dealcode!!}" style="width: 50%" placeholder="Mã deal" />
    @if($is_outbound)
        <input type="text" class="form-control ppno" name="ppno" value="{!!$seat->ppno!!}" style="width: 50%" placeholder="PP NO" />
        <input type="text" class="form-control ppexpired" name="ppexpired" value="{!!$seat->ppexpired!!}" style="width: 50%" placeholder="PP EXPIRED" />
    @else
        <input type="text" class="form-control cmnd" name="cmnd" value="{!!$seat->cmnd!!}" style="width: 50%" placeholder="CMND" />
    @endif

</div>