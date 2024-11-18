<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePreferenceRequest extends FormRequest
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
            'categories' => 'required|array',
            'categories.*' => 'integer|exists:categories,id',
            'sources' => 'required|array',
            'sources.*' => 'integer|exists:sources,id',
            'authors' => 'required|array',
            'authors.*' => 'integer|exists:authors,id',
        ];
    }
}
