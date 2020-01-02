@extends('front.login_template')

@section('main')
    <div class="register-table rlp-table">
        <a class="btn-close" href="{{ asset('') }}">&times;</a>
        <a href="{{ asset('') }}"><img src="{{ asset('') }}images/Logo.png" class="login" alt="logo"/></a>				<div class="register-title rlp-title">
            Tạo tài khoản để sử dụng các tính năng cao cấp
        </div>
        <form method="post" class="register" id="register_member" >
            {{ csrf_field() }}
            <div class="register-form bg-w-form rlp-form">
                <div class="row">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Lỗi đăng ký</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <label for="regfullname" class="control-label form-label">
                            Họ và tên
                            <span class="required">*</span>
                        </label>
                        <input id="regfullname" type="text" placeholder="" class="form-control form-input"
                               value="{{ old('regfullname') }}" name="regfullname"
                               data-validation-error-msg-required="Vui lòng nhập họ và tên"
                        />
                        <label for="regfullname" class="error regfullname"></label>
                    </div>
                    <div class="col-md-6">
                        <label for="regphone" class="control-label form-label">
                            Số điện thoại
                            <span class="required">*</span>
                        </label>
                        <input id="regphone" type="text" placeholder="" class="form-control form-input"
                               value="{{ old('regphone') }}" name="regphone"
                               data-validation-error-msg-required="Vui lòng nhập số điện thoại"
                               data-validation-error-msg-number="Số điện thoại phải là chữ số"
                               data-validation-error-msg-minlength="Số điện thoại ít nhất 8 ký tự"
                               data-validation-error-msg-maxlength="Số điện thoại nhiều nhất 12 ký tự"/>
                        <label for="regphone" class="error regphone"></label>
                    </div>
                    <div class="col-md-6">
                        <label for="regaddress" class="control-label form-label">
                            Địa chỉ
                        </label>
                        <input id="regaddress" type="text" placeholder="" class="form-control form-input"
                               value="{{ old('regaddress') }}" name="regaddress"
                        <label for="regaddress" class="error regaddress"></label>
                    </div>
                    <div class="col-md-6">
                        <label for="regemail" class="control-label form-label">
                            Email
                            <span class="required">*</span>
                        </label>
                        <input id="regemail" type="email" placeholder="" class="form-control form-input"
                               value="{{ old('email') }}" name="email"
                               data-validation-error-msg-required="Vui lòng nhập email"
                               data-validation-error-msg-format="Vui lòng nhập email đúng định dạng" />
                        <label for="regemail" class="error regemail"></label>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="control-label form-label">
                            Password
                            <span class="required">*</span>
                        </label>
                        <input id="password" type="password" placeholder="" class="form-control form-input" name="password" 
                               data-validation-error-msg-required="Xin vui lòng đánh password" 
                               data-validation-error-msg-minlength="Password ít nhất 8 chữ số"/>
                        <label for="password" class="error password"></label>
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="control-label form-label">
                            Confirm Password
                            <span class="required">*</span>
                        </label>
                        <input id="password_confirmation" type="password" placeholder="" class="form-control form-input" name="password_confirmation"
                               data-validation-error-msg-required="Xin vui lòng đánh password" 
                               data-validation-error-msg-minlength="Password ít nhất 8 chữ số" 
                               data-validation-error-msg-equalTo="Vui lòng đánh password giống như trên"/>
                        <label for="password_confirmation" class="error password_confirmation"></label>
                    </div>
                    <div class="col-md-6">
                        <div class="register-captcha">
                            <div class="g-recaptcha" data-sitekey="6Le_ftoSAAAAAFNCt4-_loDEf7iorzSshg0EYYjU"></div>
                            <input id="regrecaptcha" type="hidden" name="recaptcha" value="" data-validation-error-msg-required="Please authentication I&#039;m not a robot."/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="register-terms">
                            <div class="checkbox-terms">
                                <input type="checkbox" value="yes" name="agree" id="agree" class="" aria-invalid="false" data-validation-error-msg-required="To register for membership, you must agree to the terms and conditions of our.">
                                <div class="content">
                                    Tôi đồng ý với các  <a href="{!! asset('tro-giup/dieu-khoan-chung') !!}" target="_blank">điều khoản</a> này.										</div>
                                <label for="agree" class="error"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="register-submit">
                <input type="hidden" id="_wpnonce" name="_wpnonce" value="7ea22fa472" /><input type="hidden" name="_wp_http_referer" value="/exploore/shop/register/" />						<a href="http://wp.swlabs.co/exploore/accommodations/edemil-hotel/" class="btn btn-cancel">Cancel</a>						<input type="submit" class="btn btn-register btn-maincolor" name="register" value="Create Account"/>
            </div>
        </form>
    </div>
@endsection
