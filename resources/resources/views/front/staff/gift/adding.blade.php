<div class="addings-list">
    <div class="content table-responsive table-full-width">
        <table class="table table-hover table-striped">
            <?php $adding_childs_price = json_decode($startdate->adding_childs_price);?>
            <thead>
                <tr>
                    <th>Phụ Thu</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Trẻ em dưới 2 tuổi</td>
                    <input type="hidden" id="underTwo" value="{{$adding_childs_price ? $adding_childs_price->underTwo : 0}}">
                    <td>
                        <label class="input">
                            <?php $adding_childs = Request::get('order_id') ? json_decode($order->adding_childs) : '';?>
                            <input type="number" id="underTwoAmount" name="adding_childs[]" min="0" onkeydown="calculateTotal()" onkeyup="calculateTotal()" value="{{$adding_childs ? $adding_childs->underTwo : '' }}">
                        </label>
                    </td>
                    <td id="underTwoTotal"></td>
                </tr>
                <tr>
                    <td>Trẻ em từ 2 đến 6 tuổi</td>
                    <input type="hidden" id="twoToSix" value="{{$adding_childs_price ? $adding_childs_price->twoToSix : 0}}">
                    <td>
                        <label class="input">
                            <input type="number" id="twoToSixAmount" name="adding_childs[]" min="0" onkeydown="calculateTotal()" onkeyup="calculateTotal()" value="{{$adding_childs ? $adding_childs->twoToSix : '' }}">
                        </label>
                    </td>
                    <td id="twoToSixTotal"></td>
                </tr>
                <tr>
                    <td>Trẻ em từ 6 đến 10 tuổi</td>
                    <input type="hidden" id="sixToTen" value="{{$adding_childs_price ? $adding_childs_price->sixToTen : 0}}">
                    <td>
                        <label class="input">
                            <input type="number" id="sixToTenAmount" name="adding_childs[]" min="0" onkeydown="calculateTotal()" onkeyup="calculateTotal()" value="{{$adding_childs ? $adding_childs->sixToTen : '' }}">
                        </label>
                    </td>
                    <td id="sixToTenTotal"></td>
                </tr>
                <tr>
                    <td>Ghế ngồi trẻ em</td>
                    <input type="hidden" id="seatPrice" value="{{$adding_childs_price ? $adding_childs_price->seatPrice : 0}}">
                    <td>
                        <label class="input">
                            <input type="number" id="seatPriceAmount" name="adding_childs[]" min="0" onkeydown="calculateTotal()" onkeyup="calculateTotal()" value="{{$adding_childs ? $adding_childs->seatPrice : '' }}">
                        </label>
                    </td>
                    <td id="seatPriceTotal"></td>
                </tr>
                <tr>
                    <td>Phụ thu cuối tuần </td>
                    <input type="hidden" id="weekendAdd" name="adding_childs[]" value="{{$adding_childs_price ? $adding_childs_price->weekend : 0}}">
                    <td></td>
                    <td>{{ $adding_childs_price ? number_format($adding_childs_price->weekend) . ' đ' : 0 . ' đ'}}</td>
                </tr>
                <?php $adding_price = json_decode($startdate->adding_price);?>
                @if($adding_price && count($adding_price))
                    <?php $price_amount = Request::get('order_id') ? json_decode($order->adding_price) : '';?>
                    @foreach($adding_price as $index => $price)
                    <tr>
                        <td>{{$price->label}}</td>
                        <input type="hidden" id="adding_price_{{$index}}" value="{{$price->price}}">
                        <td><input type="number" id="adding_amount_{{$index}}" name="adding_price[]" min="0" onkeydown="calculateTotal()" onkeyup="calculateTotal()" value="{{$price_amount && isset($price_amount[$index]) ? $price_amount[$index] : '' }}"></td>
                        <td id="show_price_{{$index}}"></td>
                    </tr> 
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>
<div class="row nopadding sky-form check-khoihanh">
    <div class="col-md-3">Tổng cộng</div>
    <div class="col-md-9 text-right" id="total_1">
    </div>
</div>
<div class="form-group input-group">
    <span class="input-group-addon">Thu cọc :</span>
    <input type="number" class="form-control moneymask" placeholder="Nhập số tiền cọc" name="deposit" id="deposit" value="{{Request::get('order_id') ? $order->deposit : ''}}" style="text-align: right;" onkeydown="calculateTotal()" onkeyup="calculateTotal()">
</div>
<div class="form-group input-group">
    <span class="input-group-addon">Giảm giá:</span>
    <input type="number" class="form-control moneymask" placeholder="Nhập số tiền giảm" name="discount" id="discount" value="{{Request::get('order_id') ? $order->discount : ''}}" style="text-align: right;" onkeydown="calculateTotal()" onkeyup="calculateTotal()">
</div>
<div class="row nopadding sky-form check-khoihanh">
    <div class="col-md-3">Còn lại</div>
    <div class="col-md-9 text-right" id="total_2">
    </div>
    <input type="hidden" name="total" id="total">
</div>
<span class="input-group-addon">Cơ cấu phòng</span>
<div class="form-group input-group">
    <?php $room_lists = Request::get('order_id') ? json_decode($order->room_lists): '';?>
    <div class="form-group input-group">
        <span class="input-group-addon">P.ĐƠN:</span>
        <input type="number" class="form-control moneymask" placeholder="Nhập só lượng phòng" name="room_lists[]" style="text-align: right;" value="{{$room_lists ? $room_lists[0] : '' }}">
    </div>
    <div class="form-group input-group">
        <span class="input-group-addon">P.2:</span>
        <input type="number" class="form-control moneymask" placeholder="Nhập só lượng phòng" name="room_lists[]" style="text-align: right;" value="{{$room_lists ? $room_lists[1] : '' }}">
    </div>
    <div class="form-group input-group">
        <span class="input-group-addon">P.3:</span>
        <input type="number" class="form-control moneymask" placeholder="Nhập só lượng phòng" name="room_lists[]" style="text-align: right;" value="{{$room_lists ? $room_lists[2] : '' }}">
    </div>
    <div class="form-group input-group">
        <span class="input-group-addon">P.4:</span>
        <input type="number" class="form-control moneymask" placeholder="Nhập só lượng phòng" name="room_lists[]" style="text-align: right;" value="{{$room_lists ? $room_lists[3] : '' }}">
    </div>
</div>
<div class="form-group input-group">
    <span class="input-group-addon">Ghi chú</span>
    <input type="text" class="form-control" placeholder="Nhập ghi chú" name="note" value="{{Request::get('order_id') ? $order->note : ''}}">
</div>
<div class="form-group">
    <label>Đại lý:</label>
    <?php 
        $deal_config = \App\Models\Config::where('type', 'deal-brand')->first();
        $deals = explode( ';', $deal_config->content);
    ?>
    <select name="deal" class="form-control">
        <option value="KHÁCH LẺ">KHÁCH LẺ</option>
        @foreach($deals as $deal)
            @if($deal)
                <option value="{{$deal}}" {{Request::get('order_id') && $order->deal == $deal ? 'selected' : ''}}>{{$deal}}</option>
            @endif
        @endforeach
    </select>
</div>
<div class="sodoxe col-xs-12">
    <?php $car_lists = json_decode($startdate->car_lists);?>
    <!--xe-->
    @if($car_lists && count($car_lists))
        @foreach($car_lists as $index => $car)
            <div class="col-xs-5">
                <div class="et-train-head et-train-head-selected">
                    <div class="row center-block" style="width: 40%; margin-bottom: 20px;">
                        <div class="et-train-lamp text-center ng-binding">Xe {{$index + 1}}</div>
                    </div>
                    <div class="et-train-head-info">
                        <div class="row et-no-margin">

                            <div class="et-col-50 text-center">
                                <div class="et-text-sm ng-binding">SL chỗ trống</div>
                                <div class="et-text-large et-bold pull-right ng-binding" style="margin-right: 5px">{{$car->seat_amount - count($car->isChecked)}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row et-no-margin">
                        <div class="et-col-50"><span class="et-train-lamp-bellow-left"></span></div>
                        <div class="et-col-50"><span class="et-train-lamp-bellow-right"></span></div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!--end xe-->
</div>
<!--soghe-->
@if($car_lists && count($car_lists))
<div class="form-group">
    <label>Chọn xe</label>
    <select class="form-control" name="car_index" id="car_index" onchange="getCarMap();">
        @foreach($car_lists as $index => $car)
            <option value="{{$index}}" @if(Request::get('order_id') && $index == $order->car_index) {{'selected'}} @endif>Xe {{$index + 1}}</option>
        @endforeach 
    </select>
</div>
@else
    <input type="hidden" id="car_index" value="">
@endif
<div id="carMap"></div>
<script type="text/javascript">
    changeStandard();
    function calculateTotal(){
        var price = parseInt($('#book_standard').val());
        var adult = $('#adult').val() ? parseInt($('#adult').val()) : 0;
        var underTwoAmount = $('#underTwoAmount').val() ? parseInt($('#underTwoAmount').val()) : 0;
        var twoToSixAmount = $('#twoToSixAmount').val() ? parseInt($('#twoToSixAmount').val()) : 0;
        var sixToTenAmount = $('#sixToTenAmount').val() ? parseInt($('#sixToTenAmount').val()) : 0;
        var seatPriceAmount = $('#seatPriceAmount').val() ? parseInt($('#seatPriceAmount').val()) : 0;

        var maxChair = 0;
        if(parseInt($('#underTwo').val()) == 0){
            maxChair = maxChair + underTwoAmount;
        }
        if(parseInt($('#twoToSix').val()) == 0){
            maxChair = maxChair + twoToSixAmount;
        }
        if(parseInt($('#sixToTen').val()) == 0){
            maxChair = maxChair + sixToTenAmount;
        }
        var addingPriceLength = '<?php if($startdate->adding_price): echo(count(json_decode($startdate->adding_price))); endif;?>';
        var addingPrice = 0;
        if(addingPriceLength){
            for(var i = 0; i < addingPriceLength; i++){
                var adding_amount = $('#adding_amount_' + i).val() ? parseInt($('#adding_amount_' + i).val()) : 0;
                document.getElementById('show_price_' + i).innerHTML = '' + formatNumber(adding_amount * parseInt($('#adding_price_' + i).val())) + '';
                if(adding_amount){
                    addingPrice = addingPrice + adding_amount * parseInt($('#adding_price_' + i).val());
                }
            }
        }
        var total_1 = price * adult + (parseInt($('#underTwo').val()) * price / 100) * underTwoAmount + (parseInt($('#twoToSix').val()) * price / 100) * twoToSixAmount + (parseInt($('#sixToTen').val()) * price / 100) * sixToTenAmount  +parseInt($('#seatPrice').val()) * seatPriceAmount + parseInt($('#weekendAdd').val()) +addingPrice;

        document.getElementById('adult_total').innerHTML = '= <strong class="adult_total">'+ formatNumber(price * adult) + '</strong>';
        document.getElementById('underTwoTotal').innerHTML = ''+ formatNumber((parseInt($('#underTwo').val()) * price / 100) * underTwoAmount) +'';
        document.getElementById('twoToSixTotal').innerHTML = ''+ formatNumber((parseInt($('#twoToSix').val()) * price / 100) * twoToSixAmount) +'';
        document.getElementById('sixToTenTotal').innerHTML = ''+ formatNumber((parseInt($('#sixToTen').val()) * price / 100) * sixToTenAmount) +'';
        document.getElementById('seatPriceTotal').innerHTML = ''+ formatNumber(parseInt($('#seatPrice').val()) * seatPriceAmount) +'';
        document.getElementById('total_1').innerHTML = '= <strong class="adult_total">'+ formatNumber(total_1) + '</strong>';
        var deposit = $('#deposit').val() ? parseInt($('#deposit').val()) : 0;
        var discount = $('#discount').val() ? parseInt($('#discount').val()) : 0;
        if(deposit > total_1){
            confirm('Số tiền cọc không được lớn hơn tổng');
            $('#deposit').val(0);
            deposit = 0; 
        }
        if(discount > total_1){
            confirm('Số tiền giảm giá không được lớn hơn tổng');
            $('#discount').val(0);
            discount = 0; 
        }
        var total_2 = total_1 - discount - deposit;
        document.getElementById('total_2').innerHTML = '= <strong class="adult_total">'+ formatNumber(total_2) + '</strong>';
        document.getElementById('total').value = total_2;
    }

    function changeStandard(){
        var price = $('#book_standard').val();
        $('#price').html('= <strong class="adult_total">'+ formatNumber(price) + '</strong>');
        calculateTotal();
    }

    function formatNumber(number, character = ','){
        var thousand_separator = character,
            number_string = number.toString(),
            rest      = number_string.length % 3,
            result    = number_string.substr(0, rest),
            thousands = number_string.substr(rest).match(/\d{3}/gi);
        if (thousands) {
            var separator = rest ? thousand_separator : '';
            result += separator + thousands.join(thousand_separator);
        }
        return result + ' đ';
    }

    function initChildAmount(){
        var childAmount = $('#childAmount').val();
        var htmlString = '';
        var thisYear = parseInt('<?php echo date("Y"); ?>');
        var i = 0
        for(i; i < childAmount; i++){
            htmlString += '<div class="row nopadding sky-form check-khoihanh">';
            htmlString += '<div class="checkyear clearfix">';
            htmlString += '<div class="col-md-2">Năm sinh trẻ ' + (parseInt(i) + 1) + '</div><div class="col-md-3"><fieldset><section><label class="select state-success"><select id="childYear_'+ i +'" name="childYear[]" onchange="checkAddingAge();">'
            for(var j = thisYear; j >=   thisYear - 10; j--){
                htmlString += '<option value="'+ j +'">'+ j +'</option>'
            }
            htmlString += '</select><i></i></label></section></fieldset>';
            htmlString += '</div>';
            htmlString += '<div class="col-md-3">';
            htmlString += '<div class="" style="margin: 0;">';
            htmlString += '<input type="hidden" id="isSeat_'+ i +'" name="isSeat[]" value="1">'
            htmlString += '<input id="check_seat_'+ i +'" checked type="checkbox" onclick="checkSeat();">';
            htmlString += '<label for="check_seat_'+ i +'">Ghế ngồi</label>';
            htmlString += '</div>';
            htmlString += '</div>';
            htmlString += '</div>';
            htmlString += '</div>';
        }
        $('#checkChildAge').html(htmlString);
        $('#sixToTenAmount').val(0);
        $('#underSixAmount').val(childAmount);
        $('#sixToTenAmount2').val(0);
        $('#underSixAmount2').val(childAmount);
        checkSeat();
        calculateTotal();
    }

    function checkAddingAge(){
        var childAmount = $('#childAmount').val();
        var thisYear = parseInt('<?php echo date("Y"); ?>');
        var sixToTenAmount = 0;
        var underSixAmount = 0;
        for(var i = 0; i < childAmount; i ++){
            var age = thisYear - parseInt($('#childYear_' + i).val());            
            if(age < 6){
                $('#check_seat_' + i).attr('disabled', false);
                underSixAmount++;
            }else{
                $('#check_seat_' + i).attr('disabled', true).prop('checked', false);                
                sixToTenAmount++;
            }
        }
        $('#sixToTenAmount').val(sixToTenAmount);
        $('#underSixAmount').val(underSixAmount);
        $('#sixToTenAmount2').val(sixToTenAmount);
        $('#underSixAmount2').val(underSixAmount);
        checkSeat();
        calculateTotal();
    }

    function checkSeat(){
        var childAmount = $('#childAmount').val();
        var sixSeatPriceAmount = 0;
        for(var i = 0; i < childAmount; i ++){
            if($('#check_seat_' + i).is(":checked")){
                sixSeatPriceAmount++;
                $('#isSeat_' + i).val(1);
            }else{
                $('#isSeat_' + i).val(0);
            }
        }
        $('#sixSeatPriceAmount').val(sixSeatPriceAmount);
        $('#sixSeatPriceAmount2').val(sixSeatPriceAmount);
        calculateTotal();
    }
</script>
