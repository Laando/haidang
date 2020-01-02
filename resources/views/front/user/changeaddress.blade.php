<form method="post" class="register" id="user_member" action="/userhome/updateaddress">
    <style type="text/css">
        #user_member{
            margin-top: 0;
            padding-top: 0;
            border: none; 
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
            <h3>Địa chỉ của bạn</h3>
                <p class="form-row form-row form-row-wide address-field validate-required" id="billing_address_1_field">
                    <label for="billing_address_1" class="">Địa chỉ <abbr class="required" title="required">*</abbr></label>
                    <input type="text" class="input-text " name="address" id="billing_address_1" placeholder="<?= $user->address ?>" autocomplete="address-line1" value="">
                </p>
                <p class="form-row form-row form-row-wide address-field validate-required" id="billing_address_1_field">
                    <label for="billing_address_1" class="">Họ và Tên <abbr class="required" title="required">*</abbr></label>
                    <input type="text" class="input-text " name="fullname" id="billing_address_1" placeholder="<?= $user->fullname ?>" autocomplete="address-line1" value="">
                </p>
        </div>
    </div>
    <div class="register-submit">
        <input type="submit" class="btn btn-register btn-maincolor" name="update-profile" value="Cập nhật"/>
    </div>
</form>