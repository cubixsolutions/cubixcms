<?php  namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreUserCreateRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'name'                  => 'required|max:255',
            'email'                 => 'required|unique:users|email',
            'password'              => 'required|confirmed|min:10',
            'password_confirmation' => 'required'

        ];

    }

}