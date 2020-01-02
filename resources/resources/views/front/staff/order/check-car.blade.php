    @if($car)
    <?php 
        $checked = '';
        $order_id = Request::get('order_id');
        if(count($order_info)){
            foreach ($order_info as $index => $value) {
                if($index == count($order_info) - 1){
                    $checked .= $value;
                }else{
                    $checked .= $value . ', ';
                }
            }
        }
        $otherSeat = [];
        $currentSeat = [];
        foreach($car->order_info as $index => $value){
            if($index != 'order_' . $order_id ){
                $otherSeat = array_merge((array) $value, $otherSeat);
            }else{
                $currentSeat = array_merge((array) $value, $currentSeat);   
            }
        }
    ?>    
    <?php $isChecked = $car->isChecked;?>
    @if($isBed)
        <p class="text-success" id="seatChecked">Xe còn {{40 - count($car->isChecked)}} ghế ngồi {{$checked ? '(Đơn hàng đã chọn: ' . $checked . ')' : ''}}</p>
        <div id="giuongnam">
            <div class="soghegiuongnam">
                @for($i = 1; $i <= 30; $i++)
                    <div id="seat_button_{{ convertBedTransport($i) }}">
                        @if(in_array(convertBedTransport($i), $currentSeat))
                            <button type="button" class="btn btn-info btn-fill pull-right opacity" onclick="deleteSeat('{{ convertBedTransport($i) }}');">{{ convertBedTransport($i) }}</button>
                        @elseif(in_array(convertBedTransport($i), $otherSeat))
                            <button type="button" class="btn btn-info btn-fill pull-right" disabled>{{ convertBedTransport($i) }}</button>
                        @else
                            <button type="button" class="btn btn-info btn-fill pull-right" onclick="getSeat('{{ convertBedTransport($i) }}');">{{ convertBedTransport($i) }}</button>
                        @endif
                    </div>
                @endfor
                <div class="ghehangd" style="width: 260px;">
                    @for($i = 31; $i <= 40; $i++)
                        <div id="seat_button_{{ convertBedTransport($i) }}">
                            @if(in_array(convertBedTransport($i), $currentSeat))
                                <button type="button" class="btn btn-info btn-fill pull-right opacity" onclick="deleteSeat('{{ convertBedTransport($i) }}');">{{ convertBedTransport($i) }}</button>
                            @elseif(in_array(convertBedTransport($i), $otherSeat))
                                <button type="button" class="btn btn-info btn-fill pull-right" disabled>{{ convertBedTransport($i) }}</button>
                            @else
                                <button type="button" class="btn btn-info btn-fill pull-right" onclick="getSeat('{{ convertBedTransport($i) }}');">{{ convertBedTransport($i) }}</button>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    @else
        <p class="text-success" id="seatChecked">Xe còn {{$car->seat_amount - count($car->isChecked)}} ghế ngồi {{$checked ? '(Đơn hàng đã chọn: ' . $checked . ')' : ''}}</p>
        <div id="ghengoi">
            <div class="soghe">
                @for($i = 1; $i <= $car->seat_amount; $i++)
                    <div id="seat_button_{{$i}}">
                        @if(in_array($i, $currentSeat))
                            <button type="button" class="btn btn-info btn-fill pull-right opacity" onclick="deleteSeat('{{ $i }}');">{{ $i }}</button>
                        @elseif(in_array($i, $otherSeat))
                            <button type="button" class="btn btn-info btn-fill pull-right" disabled>{{ $i }}</button>
                        @else
                            <button type="button" class="btn btn-info btn-fill pull-right" onclick="getSeat('{{ $i }}');">{{ $i }}</button>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    @endif
    @if(count($order_info))
        @foreach($order_info as $value)
           <input type="hidden" name="seats[]" id="seat_{{$value}}" value="{{$value}}"> 
        @endforeach
    @endif
    <div id="getSeat"></div>
    <script type="text/javascript">
        var seatLength = '<?php echo(count($order_info)); ?>';
        function getSeat(seat_value) {
            calculateTotal();
            var adult = $('#adult').val() ? parseInt($('#adult').val()) : 0;            
            var underTwoAmount = $('#underTwoAmount').val() ? parseInt($('#underTwoAmount').val()) : 0;
            var sixToTenAmount = $('#sixToTenAmount').val() ? parseInt($('#sixToTenAmount').val()) : 0;
            var twoToSixAmount = $('#twoToSixAmount').val() ? parseInt($('#twoToSixAmount').val()) : 0;
            var seatPriceAmount = $('#seatPriceAmount').val() ? parseInt($('#seatPriceAmount').val()) : 0;
            var maxChair = adult+moreChair;
            if(parseInt($('#underTwo').val()) > 0){
                maxChair = maxChair + underTwoAmount;
            }
            if(parseInt($('#twoToSix').val()) > 0){
                maxChair = maxChair + twoToSixAmount;
            }
            if(parseInt($('#sixToTen').val()) > 0){
                maxChair = maxChair + sixToTenAmount;
            }
            maxChair = maxChair + seatPriceAmount;
            if(seatLength < maxChair){
                var html = '';
                html += '<input type="hidden" name="seats[]" id="seat_'+ seat_value +'" value="' + seat_value +'">';
                document.getElementById('getSeat').insertAdjacentHTML("beforebegin", html);
                document.getElementById('seat_button_' + seat_value).innerHTML = "<button type='button' class='btn btn-info btn-fill pull-right opacity' onclick='deleteSeat(`" + seat_value +"`);'>" + seat_value + "</button>";
                seatLength++;
            }else{
                confirm('Đã đủ số lượng người đăng ký');
            }
        }

        function deleteSeat(seat_value){
            document.getElementById("seat_" + seat_value).remove();
            document.getElementById('seat_button_' + seat_value).innerHTML = ' <button type="button" class="btn btn-info btn-fill pull-right" onclick="getSeat(`' + seat_value + '`);">' + seat_value + '</button>'
            seatLength--;
        }
    </script>
    <style>
        .opacity{
            opacity: 0.5 !important;   
        }
    </style>
@endif
