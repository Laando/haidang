@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!---->
                <div class="card">
                    <div class="lichkhoihanh-content">
                        @if(session('thongbao'))
                            <div class="alert alert-success">{{session('thongbao')}}</div>
                        @endif
                        <div class="lichkhoihanh-header">
                            <h4 class="modal-title" id="myModalLabel">Lịch khởi hàng tour:<br>{{$tour->title}}</h4>
                        </div>
                        <form method="POST" action="{{url('staff/start-date/save/idTour='.$tour->id) }}">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group input-group">
                                    <span class="input-group-addon">Ngày khởi hành</span>
                                    <input type="text" class="form-control" id="startdate" placeholder="Chọn ngày khởi hành" value="" name="startdate"  autocomplete="off" required readonly style="background: white; cursor: pointer;">
                                    <button onclick="weekends(true)">Show Weekends</button>
                                    <button onclick="weekends(false)">Hide Weekends</button>
                                </div>
                                <input type="hidden" name="seatLength" id="seatLength" value="1">
                                <div id="seatIndex_1">
                                    <div class=" col-md-7">
                                        <div id="seat_1">
                                            <div class="form-group input-group adding">
                                                <span class="input-group-addon">Phụ thu cuối tuần</span>
                                                <input type="hidden" name="adding_label[]" value="Phụ thu cuối tuần">
                                                <input type="number" class="form-control price percentmask" placeholder="nhập Số tiền" name="adding_price[]" required="" style="text-align: right;">
                                            </div>
                                        </div>
                                        <div id="validateSeat_1"></div>
                                    </div>

                                </div>
                                <div id="addSeat"></div>
                                <div class="clearfix"></div>


                                <div class="adding-field">

                                    <div class="">
                                        <input type="hidden" name="adding_price_length" id="adding_price_length" value="0">

                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="hidden" name="isSeat[]" id="isSeat_value_0" value="0">
                                                <div id="isSeatInput_0">
                                                    <input id="isSeat_" type="checkbox" >
                                                    <label for="isSeat_">CÓ GHẾ NGỒI</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="hidden" name="isBed[]" id="isBed_value_0" value="0">
                                                <div id="isBedInput_0">
                                                    <input id="isBed_0" type="checkbox" >
                                                    <label for="isBed_0">MẶC ĐỊNH</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="">

                                            </div>
                                        </div>

                                        <button onclick="addingPrice();" type="button" class="btn btn-default adding add"><i class="fa fa-plus fa-2 add"></i></button> Thêm phụ thu
                                    </div>
                                    <div id="adding_price">
                                    </div>
                                </div>



                            </div>
                            <!-- XE -->
                            @foreach($vehicle as $v)
                                <div class="col-md-4">
                                    <div class="form-group input-group adding">
                                        <span class="input-group-addon">{{$v->vehicle}}</span>
                                        <input type="hidden" name="vehicle{{$v->idtypeVehicle}}" value="{{$v->vehicle}}">
                                        <input type="number" class="form-control price percentmask" placeholder="nhập Số tiền" name="adding_seat{{$v->idtypeVehicle}}" value="0" required="" style="text-align: right;">
                                    </div>
                                </div>
                            @endforeach

                        <!-- END XE -->

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default" data-dismiss="modal">Lưu</button>
                        </form>
                    </div>
                </div>
                <!---->
            </div>
        </div>
    </div>
    <!-- /#wrapper -->
@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}
    {!! HTML::script('js/jquery.inputmask.min.js') !!}
    {!! HTML::script('js/jquery.inputmask.numeric.extensions.min.js') !!}
    {!! HTML::script('assets/js/plugins/multidatepicker/jquery-ui.multidatespicker.js') !!}

    <!-- {!! HTML::script('js/staff.js') !!} -->
    <script type="text/javascript">
        var myPicker = $("#startdate");
        myPicker.multiDatesPicker({
            dateFormat: 'dd-mm-yy',

        });
        function weekends(action) {
            if (action == false) { // Hide weekends
                myPicker.focus(function() { $(".ui-datepicker-week-end").hide(); });
                myPicker.blur(function() { $(".ui-datepicker-week-end").hide(); });
            }
            else {  // Show weekends
                myPicker.focus(function() { $(".ui-datepicker-week-end").show(); });
                myPicker.blur(function() { $(".ui-datepicker-week-end").show(); });
            }
        }
        // $("#startdate").datepicker( "option", "dateFormat", 'dd/mm/yy' );
        function addSeat(index) {
            var seat_amount = document.getElementById('seat_value_' + index).value;
            var htmlString = '';
            var validateHtml = '' ;
            if(seat_amount == 45){
                document.getElementById('seatLength').value = parseInt($('#seatLength').val()) + 1;
                var nextIndex = document.getElementById('seatLength').value;
                htmlString += '<div id="seatIndex_'+ nextIndex +'">';
                htmlString += '<div class=" col-md-7">';
                htmlString += '<div id="seat_'+ nextIndex +'">'
                htmlString += '<div class="form-group input-group">';
                htmlString += '<span class="input-group-addon">Số chỗ</span>';
                htmlString += '<input type="number" class="form-control" placeholder="Số chỗ mở tour" name="seat[]" required onchange="addSeat('+ nextIndex +');" id="seat_value_'+ nextIndex +'">';
                htmlString += '</div>'
                htmlString += '</div>';
                htmlString += '<div id="validateSeat_'+ nextIndex +'"></div>';
                htmlString += '</div>';
                htmlString += '<div class=" col-md-3">';
                htmlString += '<div class="">';
                htmlString += '<input type="hidden" name="isBed[]" id="isBed_value_'+ nextIndex +'" value="1">';
                htmlString += '<div id="isBedInput_'+ nextIndex +'">'
                htmlString += '<input id="isBed_'+ nextIndex +'" type="checkbox" checked="true" onclick="checkBed('+ nextIndex +')">';
                htmlString += '<label for="isBed_'+ nextIndex +'">Giường nằm</label>';
                htmlString += '</div>'
                htmlString += '</div>';
                htmlString += '</div>';
                htmlString += '<div class=" col-md-2">';
                htmlString += '<div id="deleteSeat_'+ nextIndex +'">';
                htmlString += '<i class="fa fa-close adding" style="margin-top: 10px" onclick="deleteSeat('+ nextIndex +');"></i>';
                htmlString += '</div>';
                htmlString += '</div>';
                htmlString += '</div>';
                document.getElementById('addSeat').insertAdjacentHTML("beforebegin", htmlString);
                document.getElementById('validateSeat_' + index ).innerHTML = '';
            }else{
                validateHtml += '<div class="text-danger">Số chỗ tối thiểu là 45</div>';
                document.getElementById('validateSeat_' + index).innerHTML = validateHtml;
            }
        }

        function deleteSeat(index){
            if(index > 1){
                var seatLength = parseInt($('#seatLength').val());
                document.getElementById("seatIndex_" + index).remove();
                for(var i = index + 1; i <= seatLength; i++){
                    document.getElementById('seatIndex_' + i).id = 'seatIndex_' + (i-1);
                    document.getElementById('validateSeat_' + i).id = 'validateSeat_' + (i-1);
                    document.getElementById('seat_' + i).innerHTML = '<div class="form-group input-group"><span class="input-group-addon">Số chỗ</span><input type="number" class="form-control" placeholder="Số chỗ mở tour" name="seat[]" required onchange="addSeat('+ (i-1) +');" id="seat_value_'+ (i-1) +'" value="'+ document.getElementById('seat_value_' + i).value +'"></div>';
                    document.getElementById('seat_' + i).id = 'seat_' + (i-1);
                    document.getElementById('deleteSeat_' + i).innerHTML = '<i class="fa fa-close adding" style="margin-top: 10px" onclick="deleteSeat('+ (i-1) +');"></i>';
                    document.getElementById('deleteSeat_' + i).id = 'deleteSeat_' + (i-1);
                    if($('#isBed_' + i).is(":checked")){
                        document.getElementById('isBedInput_' + i).innerHTML = '<input id="isBed_'+ (i-1) +'" type="checkbox" checked="true" onclick="checkBed('+ (i-1) +')"> <label for="isBed_'+ (i-1) +'">Giường nằm</label>';
                    }else{
                        document.getElementById('isBedInput_' + i).innerHTML = '<input id="isBed_'+ (i-1) +'" type="checkbox" onclick="checkBed('+ (i-1) +')"> <label for="isBed_'+ (i-1) +'">Giường nằm</label>';
                    }
                    document.getElementById('isBedInput_' + i).id = 'isBedInput_' + (i-1);
                    document.getElementById('isBed_value_' + i).id = 'isBed_value_' + (i-1);
                }
                document.getElementById("seatLength").value = seatLength - 1;
            }
        }

         function addingPrice(){
            document.getElementById('adding_price_length').value = parseInt($('#adding_price_length').val()) + 1;
            var index = document.getElementById('adding_price_length').value;
            var htmlString = '';
            htmlString += '<div id="priceIndex_'+ index +'">'
            htmlString += '<div class="col-md-12 form-group input-group adding">';
            htmlString += '<span id="adding_price_inputs_'+ index +'">'
            htmlString += '<input style="width: 40%" placeholder="Nhập tên phụ thu" type="text" name="adding_label[]" required id="adding_label_'+ index +'">';
            htmlString += '<input style="width: 40%" placeholder="Nhập số tiền phụ thu" type="number" name="adding_price[]" required id="adding_price_'+ index +'">';
            htmlString += '<div class="col-md-3">\n' +
                '                                            <div class="">\n' +
                '                                                <input type="hidden" name="isSeat[]" id="isSeat_value_'+index+'" value="0">\n' +
                '                                                <div id="isSeatInput_1">\n' +
                '                                                    <input id="isSeat_'+index+'"  type="checkbox" onclick="checkSeat('+index+')">\n' +
                '                                                    <label for="isSeat_'+index+'">CÓ GHẾ NGỒI</label>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="col-md-3">\n' +
                '                                            <div class="">\n' +
                '                                                <input type="hidden" name="isBed[]" id="isBed_value_'+index+'" value="0">\n' +
                '                                                <div id="isBedInput_1">\n' +
                '                                                    <input id="isBed_'+index+'" type="checkbox" onclick="checkBed('+index+')">\n' +
                '                                                    <label for="isBed_'+index+'">MẶC ĐỊNH</label>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>';
            htmlString += '</span>';
            htmlString += '<span id="deleteIndex_'+ index +'">';
            htmlString += '<i class="fa fa-close adding" onclick="deletePrice('+ index +')"></i>';
            htmlString += '</span>';
            htmlString += '</div>';
            htmlString += '</div>';
            document.getElementById('adding_price').insertAdjacentHTML("beforebegin", htmlString);
        }

function deletePrice(index){
            var priceLength = parseInt($('#adding_price_length').val());
            document.getElementById("priceIndex_" + index).remove();
            for(var i = index +  1; i <= priceLength; i++){
                document.getElementById('priceIndex_' + i).id = 'priceIndex_' + (i-1);
                document.getElementById('deleteIndex_' + i).innerHTML = '<i class="fa fa-close adding" onclick="deletePrice('+ (i-1) +')"></i>';
                document.getElementById('deleteIndex_' + i).id = 'deleteIndex_' + (i-1);
                document.getElementById('adding_price_inputs_' + i).innerHTML = '<input style="width: 40%" placeholder="Nhập tên phụ thu" type="text" name="adding_label[]" required id="adding_label_'+ (i-1) +'" value="'+ $('#adding_label_' + i).val() +'"><input style="width: 40%" placeholder="Nhập số tiền phụ thu" type="number" name="adding_price[]" required id="adding_price_'+ (i-1) +'" value="'+ $('#adding_price_' + i).val() +'"><div class="col-md-3">\n' +
                    '                                         <div class="">\n' +
                '                                                <input type="hidden" name="isSeat[]" id="isSeat_value_'+index+'" value="0">\n' +
                '                                                <div id="isSeatInput_1">\n' +
                '                                                    <input id="isSeat_'+index+'"  type="checkbox" onclick="checkSeat('+index+')">\n' +
                '                                                    <label for="isSeat_'+index+'">CÓ GHẾ NGỒI</label>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                    '                                        <div class="col-md-3">\n' +
                    '                                            <div class="">\n' +
                    '                                                <input type="hidden" name="isBed[]" id="isBed_value_'+index+'" value="0">\n' +
                    '                                                <div id="isBedInput_1">\n' +
                    '                                                    <input id="isBed_'+index+'" type="checkbox" onclick="checkBed('+index+')">\n' +
                    '                                                    <label for="isBed_'+index+'">MẶC ĐỊNH</label>\n' +
                    '                                                </div>\n' +
                    '                                            </div>\n' +
                    '                                        </div>';
                document.getElementById('adding_price_inputs_' + i).id = 'adding_price_inputs_' + (i-1);
            }
            document.getElementById("adding_price_length").value = priceLength - 1;
        }

        function checkBed(index){
            if($('#isBed_' + index).is(":checked")){
                $('#isBed_value_' + index).val(1);
            }else{
                $('#isBed_value_' + index).val(0);
            }
        }
        function checkSeat(index){
            if($('#isSeat_' + index).is(":checked")){
                $('#isSeat_value_' + index).val(1);
            }else{
                $('#isSeat_value_' + index).val(0);
            }
        }
    </script>



@stop
