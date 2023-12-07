<?php

namespace App\Http\Requests\ProjectRequest;

use App\Enums\Status;
use App\Rules\ProjectUniqueNewValue;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $project = $this->route()->parameter('project');
        return [
            'label' => ['nullable', 'max:100', new ProjectUniqueNewValue('label', $project?->label, $project?->id)],
            'description' => ['nullable'],
            'budget' => ['nullable'],
            'start_date' => ['nullable'],
            'end_date' => ['nullable'],
            'is_validate' => ['nullable','boolean'],
            'status_id' => ['nullable','exists:statuses,id']
        ];
    }

    public function projectAttributes(): array
    {
        $attributes = ['label', 'description', 'budget', 'start_date', 'end_date', 'status_id'];
        return $this->only($attributes);
    }
}
