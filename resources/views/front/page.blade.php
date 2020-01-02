@extends('front.template')
@section('title')
    <title>{!! $configpage->title !!}</title>
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
    <h3 style="text-align: center;text-transform: uppercase;padding: 10px 0px;color: #f4a622;">
    	{!! $configpage->title !!}
	</h3>
    {!! $configpage->content !!}
@stop
@section('ready')

@stop
@section('scripts')

@stop