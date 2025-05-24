<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'slug' => ['required', 'string', 'alpha_dash', 'lowercase', 'max:255', 'regex:/^[a-z0-9_-]+$/', 'unique:categories,slug'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'position' => ['integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * Prepare the request data for validation.
     *
     * This method is called right before the request data is validated.
     * It allows you to modify the request data before it's validated.
     *
     * In this case, we're converting the "is active" field to a boolean.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => $this->input('slug') ?: Str::slug($this->input('name')),
            'position' => $this->input('position') ?? 0,
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    /**
     * Configure the validator instance.
     *
     * If there are any validation errors with the "name" field, we remove any
     * validation errors from the "slug" field. This is because the slug is
     * automatically generated from the name, and we don't want to show a
     * validation error on both fields.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->has('name')) {
                $validator->errors()->forget('slug');
            }
        });
    }

    public function messages(): array
    {
        return [
            'slug.regex' => 'Slug only contains lowercase letters, numbers, hyphens (-) and underscores (_).',
        ];
    }
}
