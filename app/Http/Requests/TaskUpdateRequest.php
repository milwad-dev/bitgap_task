<?php

namespace App\Http\Requests;

use App\Enums\Task\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TaskUpdateRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'status' => ['required', new Enum(TaskStatusEnum::class)],
            'description' => ['required', 'string', 'min:3'],
            'due_date' => ['required', 'date', 'after:today', 'date_format:Y-m-d'],
            'assigned_id' => ['nullable', 'numeric', 'exists:users,id'],
        ];
    }
}
