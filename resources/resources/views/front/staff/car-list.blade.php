@if($car)
    @if($car->isBed)
        <!--nếu xe giường nằm thì hiển thị cái này so do ghe danh sach-->
        <div class="panel panel-default">
            <div class=" panel-heading">
                Danh sách Xe {{ $index + 1}}
                <a href="{{route('exportCarExcel', ['id' => $startdate->id, 'index' => $index])}}"><div class="pull-right" style="margin-top: -22px;"><button type="button"><i class="fa fa-print"></i></button></div></a>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{route('updateCarSeat', ['id' => $startdate->id])}}">
                    {{csrf_field()}}
                    <input type="hidden" name="index" value="{{$index}}">
                    <div class="col-md-12">
                        <!--so ghe-->
                        @for($i = 1; $i <= 40; $i++)
                            <div class="soghe_hd">
                                <?php
                                    $user_info = isset($car->user_info->{'seat_' . convertBedTransport($i)}) ? $car->user_info->{'seat_' . convertBedTransport($i)} : '';
                                    
                                    $order = $user_info ? \App\Models\Order::find($user_info->order_id) : '';
                                ?>
                                @if($order)
                                    <a href="{{$order ? route('processOrder') . '?order_id=' . $order->id : ''}}">Ghế <span class="number">{{convertBedTransport($i)}}</span> {{ $user_info && isset($user_info->fullname) ?  ' | ' . $user_info->fullname  : ' | ' . $order->customer_name }} </a>
                                @else
                                    <a href="">Ghế <span class="number">{{convertBedTransport($i)}}</span></a>
                                @endif
                                <input type="hidden" name="seat[]" value="{{convertBedTransport($i)}}">
                                <input type="hidden" name="order_id[]" value="{{$order ? $order->id : ''}}">
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="{{ $order ? '.multi-collapse_' . $order->id : '' }}" aria-expanded="false" aria-controls="multiCollapseExample1">Nhóm {{$order ? $order->customer_name : ''}}</button>
                                <div class="collapse {{ $order ? 'multi-collapse_' . $order->id : '' }}" id="multiCollapseExample1">
                                    <div class="thongtinpax">
                                        <div class="input-group">
                                            <input type="text" class="form-control fullname" name="fullname[]" placeholder="Nhập tên khách" aria-describedby="sizing-addon3" value="{{$user_info && isset($user_info->fullname) ? $user_info->fullname : ''}}">
                                            <input type="text" class="form-control phone" name="phone[]" placeholder="Nhập số điện thoại" aria-describedby="sizing-addon3" value="{{$user_info && isset($user_info->phone) ? $user_info->phone : ''}}">
                                            <input type="text" max="2018" min="1938" class="form-control dob" name="dob[]" placeholder="Năm sinh" aria-describedby="sizing-addon3" value="{{$user_info && isset($user_info->dob) ? $user_info->dob : ''}}" style="width: 50%">
                                            <input type="text" class="form-control dealcode" name="dealcode[]" value="{{$user_info && isset($user_info->dealcode) ? $user_info->dealcode : ''}}" style="width: 50%" placeholder="Mã deal">
                                            <input type="text" class="form-control ppno" name="ppno[]" value="{{$user_info && isset($user_info->ppno) ? $user_info->ppno : ''}}" style="width: 50%" placeholder="Số CMND/ PP">
                                            <input type="text" class="form-control ppexpired" name="ppexpired[]" value="{{$user_info && isset($user_info->ppexpired) ? $user_info->ppexpired : ''}}" style="width: 50%" placeholder="Ngày hết hạn">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                        <!--end so ghe-->
                        <button type="submit" class="btn btn-info">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
        <!--Nếu xe giường nằm thì sẽ hiển thị cái này end so do ghe danh sach-->
    @else
    <div class="panel panel-default">
        <div class=" panel-heading">
            Danh sách xe {{$index + 1}}
            <a href="{{route('exportCarExcel', ['id' => $startdate->id, 'index' => $index])}}"><div class="pull-right" style="margin-top: -22px;"><button type="button"><i class="fa fa-print"></i></button></div></a>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{route('updateCarSeat', ['id' => $startdate->id])}}">
                {{csrf_field()}}
                <input type="hidden" name="index" value="{{$index}}">
                <div class="col-md-12">
                    <!--so ghe-->
                    @for($i = 1; $i <= 45; $i++)
                        <div class="soghe_hd">
                            <?php
                                $user_info = isset($car->user_info->{'seat_' . $i}) ? $car->user_info->{'seat_' . $i} : '';
                                $order = $user_info ? \App\Models\Order::find($user_info->order_id) : '';                                    
                            ?>
                            @if($order)
                                <a href="{{$order ? route('processOrder') . '?order_id=' . $order->id : ''}}">Ghế <span class="number">{{$i}}</span> {{ $user_info && isset($user_info->fullname) ?  ' | ' . $user_info->fullname  : ' | ' . $order->customer_name }} </a>
                            @else
                                <a href="">Ghế <span class="number">{{$i}}</span></a>
                            @endif
                            <input type="hidden" name="seat[]" value="{{$i}}">
                            <input type="hidden" name="order_id[]" value="{{$order ? $order->id : ''}}">
                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="{{ $order ? '.multi-collapse_' . $order->id : '' }}" aria-expanded="false" aria-controls="multiCollapseExample1">Nhóm {{$order ? $order->customer_name : ''}}</button>
                            <div class="collapse {{ $order ? 'multi-collapse_' . $order->id : '' }}" id="multiCollapseExample1">
                                <div class="thongtinpax">
                                    <div class="input-group">
                                        <input type="text" class="form-control fullname" name="fullname[]" placeholder="Nhập tên khách" aria-describedby="sizing-addon3" value="{{$user_info && isset($user_info->fullname) ? $user_info->fullname : ''}}">
                                        <input type="text" class="form-control phone" name="phone[]" placeholder="Nhập số điện thoại" aria-describedby="sizing-addon3" value="{{$user_info && isset($user_info->phone) ? $user_info->phone : ''}}">
                                        <input type="text" max="2018" min="1938" class="form-control dob" name="dob[]" placeholder="Năm sinh" aria-describedby="sizing-addon3" value="{{$user_info && isset($user_info->dob) ? $user_info->dob : ''}}" style="width: 50%">
                                        <input type="text" class="form-control dealcode" name="dealcode[]" value="{{$user_info && isset($user_info->dealcode) ? $user_info->dealcode : ''}}" style="width: 50%" placeholder="Mã deal">
                                        <input type="text" class="form-control ppno" name="ppno[]" value="{{$user_info && isset($user_info->ppno) ? $user_info->ppno : ''}}" style="width: 50%" placeholder="Số CMND/ PP">
                                        <input type="text" class="form-control ppexpired" name="ppexpired[]" value="{{$user_info && isset($user_info->ppexpired) ? $user_info->ppexpired : ''}}" style="width: 50%" placeholder="Ngày hết hạn">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                    <!--end so ghe--> 
                    <button type="submit" class="btn btn-info">Lưu</button>                
                </div>                
            </form>
        </div>
    @endif
@endif