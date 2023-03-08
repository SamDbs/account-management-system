<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');
        $rule = $user ? Rule::unique(User::class)->ignore($user->id) : '';
        return [
            'name' => ['string', 'max:255', 'required'],
            'email' => ['required','string','email', 'max:255', $rule],
            'phone' => ['digits:10', $rule],
            'description' => ['string', 'max:255', 'nullable'],
            'password' => ['confirmed', Password::min(8)->mixedCase()->numbers()],
        ];
    }
}
