@extends('front.template')
<?php
$image = 'assets/img/logo1-default.png';
?>
@section('title')
<title>Tour du lịch 30 tháng 4</title>
@stop
@section('meta')
<meta name="keywords" content="tour 30 thang 4 gia re, tour 30/4, tour khuyen mai"/>
<meta name="description" content="Tour 30 tháng 4 giá rẻ, sale off 50% cho các tour trong và nước tại Haidangtravel" />
<meta name="og:image" content="{!!asset('assets/img/logo1-default.png')!!}"/>
<meta name="og:description" content="{!! $seodescription !!}"/>
<meta name="DC.title" content="Tout du lịch 30 tháng 4">
<meta name="DC.subject" content="Tout du lịch 30 tháng 4">
@stop

@section('main')
    <?php
    $style_filter  = '';
    $class_filter  = 'homepage-02';
    if($agent->isMobile()){
        $img = imgageMobile('Top-Home-hinh-1.jpg' , 600 , 400);
        $class_filter = '';
        $style_filter = 'background-image: url('.asset('/').'image/'.$img.');';
    }
    $filtered = $subjecthome->filter(function ($value, $key) {
        return $value->isOutbound == 2;
    });
	if($filtered->count()==0){
        $filtered = \App\Models\SubjectTour::where('homepage','=',1)->orderBy('priority', 'ASC')->get();
        $filtered = $filtered->filter(function ($value, $key) {
            return $value->isOutbound == 2;
        });
	}
    $current_subjecttour = $filtered->first();
    ?>
<style>
	.notifications {
		position: fixed;
		right: 0;
		top: 76px;
		z-index: 2;
		padding: 0;
		margin: 0;
	}
	.notifications li {
		background: #68a42b;
		color: white;
		max-width: 320px;
		display: block;
		position: relative;
		padding: 6px 10px;
		box-shadow: -2px 2px 2px rgba(0, 0, 0, 0.5);
		border-top: 1px solid rgba(255, 255, 255, 0.3); }
	.notifications li:first-child {
		border-top: 0; }
</style>
<section  class="page-banner-2" style="{!! $style_filter !!}" >
	<div class="container">
		<div class="wpb_wrapper" style="padding-top: 14px;">
			<div class="slz-shortcode block-title-15697673325a9214119ae4d ">
				<div class="group-title">
					<div class="sub-title">
						<p class="text">Du lịch giá rẻ</p><i class="icons flaticon-people"></i></div>
					<h2 class="main-title">{!! $current_subjecttour->title !!}</h2>
				</div>
			</div>
		</div>
		<div class="tab-search tab-search-condensed slz-shortcode ">
			<ul role="tablist" class="nav nav-tabs">
				<li role="presentation" class="tab-btn-wrapper active">
					<a href="#tourtrongnuoc" aria-controls="tourtrongnuoc" role="tab" data-toggle="tab" class="tab-btn">
						<i class="flaticon-people"></i><span>TRONG NƯỚC</span>
					</a>
				</li>
				<li role="presentation" class="tab-btn-wrapper">
					<a href="#tournuocngoai" aria-controls="tournuocngoai" role="tab" data-toggle="tab" class="tab-btn">
						<i class="flaticon-people"></i><span>NƯỚC NGOÀI</span>
					</a>
				</li>
				<li role="presentation" class="tab-btn-wrapper">
					<a href="#cruise4126939905a92141189a7a" class="tab-btn">
						<i class="flaticon-transport-4"></i><span> {!! $current_subjecttour->title !!}</span>
					</a>
				</li>

			</ul>
			<div class="tab-content-bg">
				<div class="tab-content" data-placeholder="Chọn nơi đến">
					<div role="tabpanel" id="tourtrongnuoc" class="tab-pane fade active in">
						<div class="find-widget find-hotel-widget widget">
							<h4 class="title-widgets">TÌM KIẾM TOUR</h4>
							<form class="content-widget" action="{{ asset('tour-trong-nuoc') }}" method="GET">
								<div class="text-input small-margin-top">
									<div class="place text-box-wrapper">
										<label class="tb-label">Bạn Đi Đâu Trong Nước VIỆT NAM?</label>
										<div class="input-group">
											<select class="tb-input select2 select2-hidden-accessible" name="tour_dest" tabindex="-1" aria-hidden="true">
												<option value="" selected="selected">Chọn điểm đến</option>
												@foreach($diemden_trongnuoc as $dp)
													<option value="{{ $dp->id }}">{{ $dp->title }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<button type="button" data-hover="SEARCH NOW" class="btn btn-slide small-margin-top search_cheaptour">
										<span class="text">TÌM KIẾM</span>
										<span class="icons fa fa-long-arrow-right"></span>
									</button>

								</div>
							</form>
						</div>
					</div>
					<div role="tabpanel" id="tournuocngoai" class="tab-pane fade">
						<div class="find-widget find-tours-widget widget">
							<h4 class="title-widgets">TÌM KIẾM TOUR</h4>
							<form class="content-widget" action="{{ asset('tour-nuoc-ngoai') }}" method="GET">
								<div class="text-input small-margin-top">
									<div class="place text-box-wrapper">
										<label class="tb-label">Hãy chọn đất nước bạn muốn đến</label>
										<div class="input-group">
											<select class="tb-input select2 select2-hidden-accessible" name="tour_dest" tabindex="-1" aria-hidden="true">
												<option value="" selected="selected">Chọn điểm đến</option>
												@foreach($diemden_nuocngoai as $dp)
													<option value="{{ $dp->id }}">{{ $dp->title }}</option>
												@endforeach
											</select>
										</div>
									</div>


									<button type="button" data-hover="SEARCH NOW" class="btn btn-slide small-margin-top search_cheaptour">
										<span class="text">TÌM KIẾM</span>
										<span class="icons fa fa-long-arrow-right"></span>
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="tour-result" class="col-md-12 main-right col-xs-12">
			<div class="col-md-6 col-xs-12 tour_item">
				<div class="col-md-4">
					<a href="" class="item_link">
						<img src="" class="item_image">
					</a>
				</div>
				<div class="col-md-8">
					<div class="col-md-12"><span class="item_name"></span></div>
					<div class="col-md-4 col-xs-12">Giá :<span class="item_price"></span></div>
					<div class="col-md-4 col-xs-12">Tiêu chuẩn : <span class="item_starhotel"></span></div>
					<div class="col-md-4 col-xs-12">Phương tiện :<span class="item_traffic"></span></div>
					<div class="col-md-12">
						<a href="" class="btn btn-maincolor item_link">Xem tour</a>
						<a href="" class="btn btn-maincolor btn-book hdbtn-consult item_contact" data-toggle="modal"
						   data-target="#consultModal" data-tour-id="">TÔI CẦN TƯ VẤN <span
									class="glyphicon glyphicon-question-sign"></span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="vc_row wpb_row vc_row-fluid vc_custom_1463096648310">
		<div class="container">
			<div class="slz_col-sm-12 wpb_column vc_column_container vc_col-sm-12">
				<div class="vc_column-inner vc_custom_1463109325289" style="padding-bottom: 0px !important;">
					<div class="wpb_wrapper">
						<div class="wpb_single_image wpb_content_element vc_align_left  wpb_appear appear"style="margin: 0px;">
							<figure class="wpb_wrapper vc_figure">
								<div class="vc_single_image-wrapper  vc_box_border_grey">
									<div class="owl-carousel tourxemnhieu-carousel most_wanted_tour">
                                        <?php foreach($homesubjectbanner as $subjectbanner) : ?>
                                        <?php
                                        if($agent->isMobile()){
                                            $subjectbanner->images = imgageMobile($subjectbanner->images , 600 , 400);
                                        }
                                        ?>
										<div class="item">
											<a href="{{ $subjectbanner->url }}">
												<img src="{{ asset('image/'.$subjectbanner->images) }}" class="vc_single_image-img attachment-full" alt="about-us-1" srcset="{{ asset('image/'.$subjectbanner->images) }} 450w, {{ asset('image/'.$subjectbanner->images) }} 300w" sizes="(max-width: 100%) 100vw, 100%" />
											</a>
										</div>
                                        <?php endforeach; ?>
									</div>
								</div>
							</figure>
						</div>
					</div>
				</div>
			</div>
		</div>
	<div id="consultModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content ">
				{!! Form::open([]) !!}
				<div class="modal-body ">
					<input type="hidden" name="tour_id" id="tour_contact_id" value="">
					<div class="count">
						<p>Nhập SĐT chúng tôi sẽ liên lạc với bạn trong 5 phút !!!</p>
						<span class="countdown-consult"></span>
						<div class="form-group">
							<input type="text" class="form-control" name="phone" id="ConsultPhone"
								   placeholder="Điện thoại liên lạc">
						</div>
						<div class="alert alert-danger" style="display: none;">
							<strong>Có lỗi !</strong>
							<ul>
								<li class="ErrorConssult"></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button"  class="btn btn-default" onclick="SubmitAdvice(this)">Gửi</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				</div>
				{!! Form::close() !!}
			</div>

		</div>
	</div>
</section>
	<ul class="notifications"></ul>
@stop
@section('scripts')
	<script type='text/javascript'>
        $(document).ready(function(e){
            var $result = $('#tour-result');
            var $tour_item = $result.find('.tour_item').first().clone();
            $result.find('.tour_item').remove();
		    $('.search_cheaptour').click(function(e){
		        $(this).prop('disabled',true);
		        var node  = $(this);
                var token = _globalObj._token;
                var form = $(this).closest('form');
                var tour_dest  = form.find('select[name="tour_dest"]').val();
                var url  = location.origin + '/';
                //if(tour_dest !== ''){
                    $.ajax({
                        url: '{!! asset('/function/getLoadAjaxCheapTour') !!}',
                        type: "POST",
                        data: { tour_dest : tour_dest ,_token:token },
						dataType : "JSON",
                        success: function(data, textStatus, jqXHR) {
                            $result.empty();
                            $(node).prop('disabled',false);
                            if(data.length == 0){
                                $result.append('<div class="no-result">Không tìm thấy</div>');
                                return;
							}
                            $.each(data,function(index , item){
                                var images_arr  = item.images.split(';');
								var $new_item  =  $tour_item.clone();
								$new_item.find('.item_link').attr('href',url+item.slug);
								$new_item.find('.item_contact').attr('data-tour-id',item.id);
								$new_item.find('.item_image').attr('src',url+'image/'+images_arr[0] );
								$new_item.find('.item_name').text(item.title);
								$new_item.find('.item_price').text(numbertomoney(item.adultprice));
								$new_item.find('.item_starhotel').text(item.starhotel);
								$new_item.find('.item_traffic').text(item.traffic);
								$result.append($new_item);
							});
                        }
                    });
				/*} else {
                    notify('Xin hãy chọn điểm đến !');
                    $(this).prop('disabled',false);
				}*/
			});
            $("#consultModal").on('shown.bs.modal', function (event) {
                var button = $(event.relatedTarget) //
                $('#tour_contact_id').val(button.attr('data-tour-id'));
                $('#ConsultPhone')[0].focus();
                $(this).find('.alert.alert-danger').hide();
            });
            $('.search_cheaptour').click();
		});
        function notify(text) {
            var $notifications = $('.notifications');
            var $notification = $('<li />').text(text).css({
                left: 320
            })
            $notifications.append($notification)
            $notification.animate({
                left: 0
            }, 300, function() {
                $(this).delay(3000).animate({
                    left: 320
                }, 200, function() {
                    $(this).slideUp(100, function() {
                        $(this).remove()
                    })
                })
            })
        }
        function numbertomoney(str){
            var strlen = str.length ;
            var newstr = str;
            if(strlen<4 && strlen >0){
                newstr += " đ";
                return newstr;
            }
            if(strlen<=6 && strlen >=4){
                newstr = reverse(newstr);
                newstr = newstr.substr(0, 3) + "," + newstr.substr(3);
                newstr = reverse(newstr);
                newstr += " đ";
                return newstr;
            }
            if(strlen<=9 && strlen >=7){
                newstr = reverse(newstr);
                newstr = newstr.substr(0, 3) + "," + newstr.substr(3);
                newstr = newstr.substr(0, 7) + "," + newstr.substr(7);
                newstr = reverse(newstr);
                newstr += " đ";
                return newstr;
            }
            if(strlen<=12 && strlen >=10){
                newstr = reverse(newstr);
                newstr = newstr.substr(0, 3) + "," + newstr.substr(3);
                newstr = newstr.substr(0, 7) + "," + newstr.substr(7);
                newstr = newstr.substr(0, 11) + "," + newstr.substr(11);
                newstr = reverse(newstr);
                newstr += " đ";
                return newstr;
            }
            if(strlen>12){
                return newstr = "Số quá lớn";
            }
        }
        function reverse(s){
            return s.split("").reverse().join("");
        }
        function SubmitAdvice(node) {
            var phone = $('#ConsultPhone').val();
            var form = $('#ConsultPhone').closest('form');
            if(validatePhone(phone)){
                var data = {};
                data.tour_id = $('#tour_contact_id').val();
                $(form).find('input').each(function(index,element){
                    data[$(element).attr('name')] = $(element).val();
                });
                $.ajax({
                    url:  '{!! asset('/') !!}consult/send',
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        if(response === 'Ok'){
                            $('.countdown-consult').show();
                            // Set the date we're counting down to
                            var now = new Date().getTime();
                            var countDownDate = now+(60*5*1000); // add 5 mins
                            var x = setInterval(function() {
                                now = new Date().getTime();
                                // Get todays date and time
                                // Find the distance between now and the count down date
                                var distance = countDownDate - now;
                                console.log(countDownDate,now,distance);
                                // Time calculations for days, hours, minutes and seconds
                                //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                //var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                // Display the result in the element with id="demo"
                                $('.countdown-consult').html( minutes + " phút " + seconds + " giây ");
                                // If the count down is finished, write some text
                                if (distance < 0) {
                                    clearInterval(x);
                                    $('.countdown-consult').html('Xin lỗi có vẻ như mọi tư vấn đều bận ! Gọi trực tiếp tới HOTLINE : <a href="tel:19002011">1900 2011</a>');
                                }
                            }, 1000);
                        }
                        //$(node).prop('disabled',false);
                    }
                });
                $(node).prop('disabled',true);
            } else {
                $(form).find('.alert.alert-danger').show();
                $('.ErrorConssult').text('Số điện thoại không hợp lệ !');
            }
        }
        function validatePhone(txtPhone) {
            var a = txtPhone;
            var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
            if (filter.test(a)) {
                return true;
            }
            else {
                return false;
            }
        }
	</script>
@stop


