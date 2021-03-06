<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\User;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|string|max:255|unique:users',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:5|confirmed',
        ];
    }
}
