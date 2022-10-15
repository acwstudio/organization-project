<?php

namespace App\Http\Requests\Api\V1\Regions;

use App\Models\City;
use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;

class RegionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'data'                                => ['required','array'],
            'data.type'                           => ['required','string','in:' . Region::TYPE_RESOURCE],
            'data.attributes'                     => ['required','array'],
            'data.attributes.federal_district_id' => ['required','integer'],
            'data.attributes.name'                => ['required','string'],
            'data.attributes.description'         => ['required','string'],
            'data.attributes.slug'                => ['prohibited'],
            'data.attributes.active'              => ['required','boolean'],
            // relationships
            'data.relationships'                    => ['sometimes','required','array'],
            'data.relationships.cities'             => ['sometimes','required','array'],
            'data.relationships.cities.data'        => ['sometimes','required','array'],
            'data.relationships.cities.data.*'      => ['sometimes','required','array'],
            'data.relationships.cities.data.*.type' => ['present','string','in:' . City::TYPE_RESOURCE],
            'data.relationships.cities.data.*.id'   => [
                'present','integer', 'distinct', 'exists:' . City::TYPE_RESOURCE . ',id'
            ],
        ];
    }
}