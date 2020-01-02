@php
    $backUrl  = isset($_GET['backUrl'])? $_GET['backUrl'] : '';
@endphp
<div class="login-table rlp-table">
    <a class="btn-close" href="{{ asset('') }}">&times;</a>
    <a href="{{ asset('') }}"><img src="{{ asset('') }}images/Logo.png" class="login" alt="logo"/></a>
    <div class="login-title rlp-title">Đăng nhập		</div>
    <form method="post" action="{{ asset('login') }}">
        {{ csrf_field() }}
        <div class="login-form bg-w-form rlp-form">
            <div class="row">
                <input type="hidden" name="backUrl" value="{{ $backUrl }}">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Lỗi đăng nhập</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="col-md-12">
                    <label for="regemail" class="control-label form-label">
                        email
                        <span class="required">*</span>
                    </label>
                    <input id="regemail" type="text" placeholder="" name="email"
                           class="form-control form-input" value="{{ old('email') }}">
                </div>
                <div class="col-md-12">
                    <label for="regpassword" class="control-label form-label">
                        password
                        <span class="required">*</span>
                    </label>
                    <input id="regpassword" type="password" name="password" placeholder="" class="form-control form-input">
                </div>
            </div>
            <div class="">
                <input id="remember" name="rememberme" type="checkbox" class="check"/>
                <label for="remember" class="type-checkbox">Nhớ</label>
            </div>
        </div>
        <div class="login-submit">
            <input type="submit" class="btn btn-maincolor" name="login" value="Đăng nhập" />
            <a href="{{ url()->previous() }}" class="btn btn-cancel">Trở về</a>					</div>
    </form>
    <p class="title-sign-in">
        Chưa có tài khoản ? <a href="{{ asset('') }}register" class="link signin">Tạo ngay !</a>				</p>
</div>