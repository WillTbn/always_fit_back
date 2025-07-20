<?php

namespace App\Http\Requests\Training;

use App\Enums\LevelsTrainingEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTrainingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'subname' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'equipment' => 'nullable|string',
            'meta_days' => 'nullable|integer',
            'level' => ['required', Rule::enum(LevelsTrainingEnum::class)],
        ];
    }
}
