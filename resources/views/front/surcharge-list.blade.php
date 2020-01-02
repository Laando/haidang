<?php
$firstcheck = true;
$name = explode("|", $startdate->ten_phu_thu);
$price_charges = explode("|", $startdate->gia_phu_thu);
$is_show = explode("|", $startdate->phuthu_show);
?>
@foreach($name as $key => $value)
    @if($is_show[$key]==1 && $value!="Phụ thu cuối tuần")
        <div class="count text-box-wrapper" >
            <label class="tb-label">{{$value}} / {{numbertomoney($price_charges[$key])}} <span class=""></span></label>
                <div class="input-group">
                    <input class="tb-input count" min="0" max="100" type="number" value="0" name="amount{{$key}}" id="amount{{$key}}" onchange="calculateTotal()" />
            </div>
        </div>
    @endif
@endforeach
<script>
name_charges=<?php echo json_encode($name ); ?>;
price_charges=<?php echo json_encode($price_charges ); ?>;
is_show=<?php echo json_encode($is_show ); ?>;
</script>
                                   
                      
