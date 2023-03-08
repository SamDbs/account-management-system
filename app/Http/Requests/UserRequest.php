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
        $currentPasswordRules = [];
        if (auth()->user()->password && auth()->user()->role->name !== 'admin') {
            $currentPasswordRules = ['required_with:password', 'current_password'];
        }

        return [
            'name' => ['string', 'max:255', 'required'],
            'email' => ['required','string','email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['digits:10', Rule::unique(User::class)->ignore($this->user()->id)],
            'description' => ['string', 'max:255', 'nullable'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'current_password' => $currentPasswordRules,
        ];
    }
}
