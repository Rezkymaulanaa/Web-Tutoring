<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:255', Rule::unique('users')->ignore($user)],
            'email' => ['required', 'email:dns', 'max:255', Rule::unique('users')->ignore($user)],
            'role' => ['required', Rule::enum(UserRole::class)->only(UserRole::assignable())],
        ];
    }
}
