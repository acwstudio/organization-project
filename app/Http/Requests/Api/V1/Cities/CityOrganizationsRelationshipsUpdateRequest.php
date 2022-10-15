<?php

namespace App\Http\Requests\Api\V1\Cities;

use Illuminate\Foundation\Http\FormRequest;

class CityOrganizationsRelationshipsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'data'        => 'present|array',
            'data.*.id'   => 'required|string|exists:organizations,id',
            'data.*.type' => 'required|string|in:organizations',
        ];
    }
}