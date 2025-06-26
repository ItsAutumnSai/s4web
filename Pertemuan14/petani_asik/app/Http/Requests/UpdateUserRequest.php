<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('edit_user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'iot_id' => 'nullable|string|max:255', // Tambahkan validasi
            'iot_token' => 'nullable|string|max:255', // Tambahkan validasi
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => ['required'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('field.name'),
            'role' => __('field.role'),
        ];
    }
}
