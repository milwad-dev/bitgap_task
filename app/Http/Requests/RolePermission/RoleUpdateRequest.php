<?php

namespace App\Http\Requests\RolePermission;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:roles,name,'.$this->id],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'exists:permissions,id'],
        ];
    }
}
