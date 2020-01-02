@extends('back.template')

@section('main')

	@include('back.partials.entete', ['title' => trans('back/users.dashboard'), 'icone' => 'user', 'fil' => link_to('user', trans('back/users.Users')) . ' / ' . trans('back/users.card')])

	<p>{{ trans('back/users.name') . ' : ' .  $user->username }}</p>
	<p>{{ trans('back/users.email') . ' : ' .  $user->email }}</p>
	<p>{{ trans('back/users.role') . ' : ' .  $user->role->title }}</p>
    <p>{{ trans('back/users.dob') . ' : ' .  $user->dob }}</p>
    <p>{{ trans('back/users.address') . ' : ' .  $user->address }}</p>
    <p>{{ trans('back/users.gender') . ' : ' .  $user->gender }}</p>
    <p>{{ trans('back/users.stockpoint') . ' : ' .  $user->stockpoint }}</p>
    <p>{{ trans('back/users.lastlogin') . ' : ' .  $user->lastlogin }}</p>
    <p>{{ trans('back/users.createat') . ' : ' .  $user->created_at }}</p>
    <p>{{ trans('back/users.yahoo') . ' : ' .  $user->yahoo }}</p>
    <p>{{ trans('back/users.skype') . ' : ' .  $user->skype }}</p>
    <p>{{ trans('back/users.facebook') . ' : ' .  $user->facebook }}</p>
    <p>{{ trans('back/users.getmail') . ' : ' .  $user->getmail }}</p>
    <p>{{ trans('back/users.status') . ' : ' .  $user->status }}</p>
    <p>{{ trans('back/users.seen') . ' : ' .  $user->seen }}</p>

@stop