<?php

namespace App\Http\Requests\Drawing;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'shapes' => ['required', 'array'],
            'shapes.*.id' => ['required', 'integer', 'exists:shapes,id'],
            'shapes.*.x' => ['required', 'numeric'],
            'shapes.*.y' => ['required', 'numeric'],
        ];
    }
}
