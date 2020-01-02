@extends('front.template')
@section('title')
    <title>{!! $seotitle !!}</title>
@stop
@section('meta')
    <meta name="keywords" content="{!! $seokeyword !!}" />
    <meta name="description" content="{!! $seodescription !!}" />
    <meta name="og:title" content="{!! $seotitle !!}"/>
    <meta name="og:image" content="{!!asset('assets/img/logo1-default.png')!!}"/>
    <meta name="og:description" content="{!! $seodescription !!}"/>
    <meta name="DC.title" content="{!! $seotitle !!}">
    <meta name="DC.subject" content="{!! $seodescription !!}">
@stop
@section('styles')

@stop
@section('main')
    <main class="text-center" style="background-color:#ff1a1a">
        <img src="/images/gio-vang.png" class="img-fluid" style="width:80%" alt="tour-gio-vang">
        @if(!$inEvent)
        <h1 class="text-uppercase text-white font-weight-bolder fs-20 mt-3">tour giờ vàng sẽ diễn ra sau</h1>
        <div class="col-lg-6 col-md-10 col-12 row container mb-5 m-auto">
            <div class="col-sm-3 col-9 mx-sm-0 mx-auto p-3">
                <div class="circle-150 border-gv rounded-circle pt-4 pb-4 bg-white">
                    <h2 class="mb-0" id="eventDay">66</h2>
                    <h4>Ngày</h4>
                </div>
            </div>
            <div class="col-sm-3 col-4 p-sm-3 p-1">
                <div class="circle-150 border-gv rounded-circle py-4 py-2 bg-white">
                    <h2 class="mb-0" id="eventHour">03</h2>
                    <h4>Giờ</h4>
                </div>
            </div>
            <div class="col-sm-3 col-4 p-sm-3 p-1">
                <div class="circle-150 border-gv rounded-circle py-4 py-2 bg-white">
                    <h2 class="mb-0" id="eventMinute">19</h2>
                    <h4>Phút</h4>
                </div>
            </div>
            <div class="col-sm-3 col-4 p-sm-3 p-1">
                <div class="circle-150 border-gv rounded-circle py-4 py-2 bg-white">
                    <h2 class="mb-0" id="eventSecond">00</h2>
                    <h4>Giây</h4>
                </div>
            </div>
        </div>
        @else
            <h1 class="text-uppercase text-white font-weight-bolder fs-20 mt-3">tour giờ vàng sẽ diễn ra trong</h1>
            <div class="col-lg-6 col-md-10 col-12 row container mb-5 m-auto">
                <div class="col-sm-3 col-9 mx-sm-0 mx-auto p-3">
                    <div class="circle-150 border-gv rounded-circle pt-4 pb-4 bg-white">
                        <h2 class="mb-0" id="eventDay">66</h2>
                        <h4>Ngày</h4>
                    </div>
                </div>
                <div class="col-sm-3 col-4 p-sm-3 p-1">
                    <div class="circle-150 border-gv rounded-circle py-4 py-2 bg-white">
                        <h2 class="mb-0" id="eventHour">03</h2>
                        <h4>Giờ</h4>
                    </div>
                </div>
                <div class="col-sm-3 col-4 p-sm-3 p-1">
                    <div class="circle-150 border-gv rounded-circle py-4 py-2 bg-white">
                        <h2 class="mb-0" id="eventMinute">19</h2>
                        <h4>Phút</h4>
                    </div>
                </div>
                <div class="col-sm-3 col-4 p-sm-3 p-1">
                    <div class="circle-150 border-gv rounded-circle py-4 py-2 bg-white">
                        <h2 class="mb-0" id="eventSecond">00</h2>
                        <h4>Giây</h4>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-11 col-12 container mt-5" style="padding-bottom: 30%;">
            <div class="card-deck mb-3 text-center">
                @if(count($tours)>0 && $inEvent)
                    @foreach($tours as $index=>$tour)
                        @include('partials.tourpartial' ,['tour'=> $tour , 'isGold'=>true])
                    @endforeach
                @endif
            </div>
            <div class="text-left text-white mb-3 mt-5 text-uppercase">
                <h4>danh sách dặt tour giờ vàng</h4>
            </div>
            <table class="text-left table table-bordered bg-white">
                <thead>
                <tr>
                    <th style="width: 33%;" scope="col">Tên Khách</th>
                    <th style="width: 33%;" scope="col">Tour</th>
                    <th style="width: 33%;" scope="col">Thời gian đặt</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $index=>$order)
                <tr>
                    <td>{{ $order->customer->fullname }}</td>
                    <td>{{ $order->tour ? $order->tour->title : 'Tour đã bị xóa'}}</td>
                    <td>{{ $order->created_at }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <div class="bg-efefef p-2 d-sm-none d-block">
            <div class="text-center w-100">
                <p class="font-weight-bold flex-nowrap">Ưu đãi khi sử dụng Haidangtravel App</p>
            </div>
            <div class="row mx-0">
                <div class="col-4 px-2 text-center">
                    <img src="images/icon-45.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                    <p class="font-weight-bold">Mua sắm & thanh toán thuận tiện</p>
                </div>
                <div class="col-4 px-2 text-center">
                    <img src="images/icon-46.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                    <p class="font-weight-bold">Nhiều ưu đãi hơn trên app</p>
                </div>
                <div class="col-4 px-2 text-center">
                    <img src="images/icon-47.png" class="px-sm-5 mb-2" style="height:35px" alt="icon-01">
                    <p class="font-weight-bold">Theo dõi đơn hàng dễ dàng</p>
                </div>
            </div>
            <div class="my-2">
                <button class="btn w-100 btn-wanning btn-block bg-color-line text-light rounded-0" type="button">Tải App</button>
            </div>
        </div>
        <div class="bg-oganre p-2 d-sm-none d-block">
            <div class="my-2">
                <button class="btn w-100 btn-wanning btn-block bg-ed1c24 text-light rounded-0 text-uppercase" type="button">Xem thông tin haidangtravel</button>
            </div>
        </div>
    </main>
@stop
@section('scripts')
    {!! HTML::script('js/jquery.countdown.min.js') !!}
    <script type="text/javascript">
        @if($inEvent)
        let eventTime = '{{ $eventtimeend->format('Y/m/d H:i:s')  }}';
        @else
        let eventTime = '{{ $eventtime->format('Y/m/d H:i:s') }}';
        @endif
        $(document).ready(function() {
            $("#eventDay")
                .countdown(eventTime, function(event) {
                    $(this).text(
                        event.strftime('%D')
                    );
                });
            $("#eventHour")
                .countdown(eventTime, function(event) {
                    $(this).text(
                        event.strftime('%H')
                    );
                });
            $("#eventMinute")
                .countdown(eventTime, function(event) {
                    $(this).text(
                        event.strftime('%M')
                    );
                });
            $("#eventSecond")
                .countdown(eventTime, function(event) {
                    $(this).text(
                        event.strftime('%S')
                    );
                });
            $(".eventTime")
                .countdown(eventTime, function(event) {
                    $(this).text(
                        event.strftime('Còn %D Ngày %H:%M:%S')
                    );
                });
        });
        function goSearch(){
            $form = $('#MenuSearch');
            let model = FormProvider.BindToModel($form);
            let link = '/search?';
            // find standard
            let standards= [] ;
            let transports= [] ;
            $('[data-name="standard"]:checked').each(function(index,item){
                standards = [...standards ,$(item).val()];
            })
            $('[data-name="transport"]:checked').each(function(index,item){
                transports = [...transports ,$(item).val()];
            })
            for (let [key,value] of Object.entries(model)){
                link += key+'='+value + '&';
            }
            link += 'standard='+ standards.join(',')+ '&';
            link += 'transport='+ transports.join(',',)+ '&';
            link = trim(link,'&');
            location = link;
            return false;
        }
    </script>
@stop