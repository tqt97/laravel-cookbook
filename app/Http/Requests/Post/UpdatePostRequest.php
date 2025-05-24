<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'alpha_dash', 'lowercase', 'max:255', 'regex:/^[a-z0-9_-]+$/', Rule::unique('posts', 'slug')->ignore($this->post)],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'is_featured' => ['required', 'boolean'],
            'is_published' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'tags' => ['nullable', 'array', 'max:5'],
            'tags.*' => ['bail', 'integer', 'exists:tags,id'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * This method is called after the request is validated. Here we can
     * manipulate the data before it is passed to the validator.
     */
    protected function prepareForValidation(): void
    {
        $isPublished = $this->boolean('is_published');

        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_published' => $isPublished,
            'published_at' => match (true) {
                ! $isPublished => null,
                ! $this->post->is_published => now(),
                default => $this->post->published_at,
            },
            'tags' => $this->input('tags') ?? [],
        ]);
    }

    public function messages(): array
    {
        return [
            'tags.max' => 'You can select a maximum of 5 tags.',
            'tags.*.exists' => 'The selected tag does not exist.',
            'tags.*.integer' => 'Each tag must be an integer ID.',
            'slug.regex' => 'Slug only contains lowercase letters, numbers, hyphens (-) and underscores (_).',
        ];
    }
}
