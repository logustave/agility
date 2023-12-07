<?php

namespace App\Http\Requests\ProjectRequest;

use App\Enums\Status;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProjectRequest extends FormRequest
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
        return [
            'label' => ['required', 'max:100', 'unique:projects,label'],
            'description' => ['nullable'],
            'budget' => ['nullable'],
            'start_date' => ['nullable'],
            'end_date' => ['nullable']
        ];
    }

    public function projectAttributes(): array
    {
        $attributes = ['label', 'description', 'budget', 'start_date', 'end_date','user_id', 'status_id'];
        return $this
            ->merge(['user_id' => Auth::id()])
            ->only($attributes);
    }
}

