<?php

namespace App\Http\Requests;

use App\Rules\UserUniqueNewValue;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UpdateAdministratorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $administrator = $this->route()->parameter('administrator');
        return [
            'lastname' => ['nullable', 'max:100'],
            'firstname' => ['nullable', 'max:100'],
            'email' => ['nullable', 'email', new UserUniqueNewValue('email', $administrator?->email, $administrator?->user_id)],
            'contact' => ['nullable', new UserUniqueNewValue('contact', $administrator?->contact, $administrator?->user_id)],
            'password' => ['nullable', Password::min(8),'confirmed'],
            'photo' => ['nullable']
        ];
    }

    public function userAttributes(): array
    {
        $attributes = ['lastname', 'firstname', 'email', 'contact', 'password', 'photo'];

        if ($this->input('password')) {
            $this->merge(['password' => Hash::make($this->input('password'))]);
            $attributes[] = 'password';
        }

        return $this
            ->only($attributes);
    }
}
