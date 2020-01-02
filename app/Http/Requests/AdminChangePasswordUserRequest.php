<?php
namespace App\Http\Requests;


class AdminChangePasswordUserRequest extends Request {
    public function authorize()
    {
        return true;
    }
    public function rules()
    {

        return $rules = [
            'password' => 'required|confirmed'
        ];
    }
}