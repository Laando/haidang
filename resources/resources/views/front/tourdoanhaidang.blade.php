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


<section>
  <div class="container">
    <div class="row">
      <div class="bannertop30thang4">
        <img src="./tourle/30thang4khuyenmaki.gif">
      </div>
      
    </div>
  </div>
</section>
@stop


