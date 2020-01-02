<form method="post" class="register" id="user_member" >
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
                       data-validation-error-msg-format="Vui " />
                <label for="regemail" class="error regemail"></label>
            </div>
            <div class="col-md-6">
                <label for="dob" class="control-label form-label">
                    Ngày sinh
                </label>
                <input id="dob" type="dob" placeholder="" class="form-control form-input datepicker" placeholder="YYYY-MM-DD" readonly="readonly" type="text"
                       value="{{ old('dob') }}" name="dob"
                       data-validation-error-msg-format="Vui lòng nhập đúng đinh dạng ngày" />
                <label for="dob" class="error dob"></label>
            </div>
        </div>
    </div>
    <div class="register-submit">
        <input type="submit" class="btn btn-register btn-maincolor" name="update-profile" value="Cập nhật thông tin"/>
    </div>
</form>