<?php

namespace App\Http\Requests\Shapes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required',Rule::in('circle','rectangular')],
            'color' => ['required', Rule::in(['red', 'blue', 'green'])],
            'width' => 'required_if:type,rectangular|numeric| min:0',
            'height' => 'required_if:type,rectangular|numeric| min:0',
            'radius' => 'required_if:type,circle|numeric| min:0'
        ];
    }
}
