<form method="post" class="register" id="user_member" action="/userhome/updatepassword">
    <style type="text/css">
        #user_member{
            margin-top: 0;
            padding-top: 0;
            padding-left: 30px;
        }
        #user_member h3{
            margin-top: 0;
        }
    </style>
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
            <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
                <label for="password">Mật khẩu hiện tại<span class="required">*</span></label>
                {!! Form::input('password', 'oldpassword', null, ['placeholder' => 'Mật khẩu cũ','id'=>'oldpassword', 'class'=>'woocommerce-Input woocommerce-Input--text input-text']) !!}
            </p>
            <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
                <label for="password">Mật khẩu mới<span class="required">*</span></label>
                {!! Form::input('password', 'password', null, ['placeholder' => 'Mật khẩu mới','id'=>'password', 'class'=>'woocommerce-Input woocommerce-Input--text input-text']) !!}
            </p>
            <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
                <label for="password">Nhập lại mật khẩu mới<span class="required">*</span></label>
                {!! Form::input('password', 'password_confirmation', null, ['placeholder' => 'Xác nhận mật khẩu mới','id'=>'password_confirmation','class' => 'woocommerce-Input woocommerce-Input--text input-text']) !!}
            </p>
            <p class="woocommerce-LostPassword lost_password">
                Trường hợp bạn không nhớ mật khẩu hiện tại, bạn có thể liên hệ hotline 19002011 nhân viên chúng tôi sẽ cung cấp lại mật khẩu cho bạn
            </p>
        </div>
    </div>
    <div class="register-submit">
        <input type="submit" class="btn btn-register btn-maincolor" name="update-profile" value="Cập nhật"/>
    </div>
</form>