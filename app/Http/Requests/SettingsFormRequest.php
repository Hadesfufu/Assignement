<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Request;

class SettingsFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|alpha_num|min:3|max:32',
            'email' => 'required|email',
            'password' => 'min:3|confirmed',
            'password_confirmation' => 'min:3',
            'image' => 'image|max:1024*1024*1'
        ];
    }
}
