<?php

namespace Tests\Feature\FederalDistricts;

use App\Models\FederalDistrict;
use App\Models\Region;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * 1. Test federal district store attributes validate
 * 2. Test federal district store relationships required validate
 * 3. Test federal district store relationships must be an array validate
 * 4. Test federal district store relationships regions required validate
 * 5. Test federal district store relationships regions data must be an array validate
 * 6. Test federal district store relationships regions data required validate
 * 7. Test federal district store relationships regions data must be an array validate
 * 8. Test federal district store relationships regions data n required validate
 * 9. Test federal district store relationships regions data n must be an array validate
 * 10. Test federal district store relationships regions data n item invalid validate
 * 11. Test federal district store relationships regions data n item present validate
 */
class FederalDistrictStoreValidateTest extends TestCase
{
    use RefreshDatabase;

    public function test_federal_district_store_items_validate()
    {
        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => '',
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 7,
                    'slug'        => 'severo-zapadnyy-federalnyy-okrug',
                    'active'      => 'true',
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.type field is required.',
                        'source'  => [
                            'pointer' => '/data/type',
                        ]
                    ],
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.attributes.description must be a string.',
                        'source'  => [
                            'pointer' => '/data/attributes/description',
                        ]
                    ],
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.attributes.slug field is prohibited.',
                        'source'  => [
                            'pointer' => '/data/attributes/slug',
                        ]
                    ],
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.attributes.active field must be true or false.',
                        'source'  => [
                            'pointer' => '/data/attributes/active',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('federal_districts', [
            'name'        => 'Северо-западный федеральный округ',
            'description' => 7,
            'slug'        => 'severo-zapadnyy-federalnyy-okrug',
            'active'      => 'true'
        ]);
    }

    public function test_federal_district_create_relationships_required_validate()
    {
        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => FederalDistrict::TYPE_RESOURCE,
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 'Description shortly',
                    'active'      => true,
                ],
                'relationships' => [

                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.relationships field is required.',
                        'source'  => [
                            'pointer' => '/data/relationships',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('federal_districts', [
            'name'        => 'Северо-западный федеральный округ',
            'description' => 'Description shortly',
            'slug'        => 'severo-zapadnyy-federalnyy-okrug',
            'active'      => true
        ]);
    }

    public function test_federal_district_create_relationships_must_be_array_validate()
    {
        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => FederalDistrict::TYPE_RESOURCE,
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 'Description shortly',
                    'active'      => true,
                ],
                'relationships' => 'test'
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.relationships must be an array.',
                        'source'  => [
                            'pointer' => '/data/relationships',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('federal_districts', [
            'name'        => 'Северо-западный федеральный округ',
            'description' => 'Description shortly',
            'slug'        => 'severo-zapadnyy-federalnyy-okrug',
            'active'      => true
        ]);
    }

    public function test_federal_district_create_relationships_regions_required_validate()
    {
        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => FederalDistrict::TYPE_RESOURCE,
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 'Description shortly',
                    'active'      => true,
                ],
                'relationships' => [
                    'regions' => [

                    ]
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.relationships.regions field is required.',
                        'source'  => [
                            'pointer' => '/data/relationships/regions',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('federal_districts', [
            'name'        => 'Северо-западный федеральный округ',
            'description' => 'Description shortly',
            'slug'        => 'severo-zapadnyy-federalnyy-okrug',
            'active'      => true
        ]);
    }

    public function test_federal_district_create_relationships_regions_must_be_array_validate()
    {
        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => FederalDistrict::TYPE_RESOURCE,
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 'Description shortly',
                    'active'      => true,
                ],
                'relationships' => [
                    'regions' => 'test'
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.relationships.regions must be an array.',
                        'source'  => [
                            'pointer' => '/data/relationships/regions',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('federal_districts', [
            'name'        => 'Северо-западный федеральный округ',
            'description' => 'Description shortly',
            'slug'        => 'severo-zapadnyy-federalnyy-okrug',
            'active'      => true
        ]);
    }

    public function test_federal_district_create_relationships_regions_data_required_validate()
    {
        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => FederalDistrict::TYPE_RESOURCE,
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 'Description shortly',
                    'active'      => true,
                ],
                'relationships' => [
                    'regions' => [
                        'data' => [

                        ]
                    ]
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.relationships.regions.data field is required.',
                        'source'  => [
                            'pointer' => '/data/relationships/regions/data',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('federal_districts', [
            'name'        => 'Северо-западный федеральный округ',
            'description' => 'Description shortly',
            'slug'        => 'severo-zapadnyy-federalnyy-okrug',
            'active'      => true
        ]);
    }

    public function test_federal_district_create_relationships_regions_data_must_be_array_validate()
    {
        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => FederalDistrict::TYPE_RESOURCE,
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 'Description shortly',
                    'active'      => true,
                ],
                'relationships' => [
                    'regions' => [
                        'data' => 'test'
                    ]
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.relationships.regions.data must be an array.',
                        'source'  => [
                            'pointer' => '/data/relationships/regions/data',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('federal_districts', [
            'name'        => 'Северо-западный федеральный округ',
            'description' => 'Description shortly',
            'slug'        => 'severo-zapadnyy-federalnyy-okrug',
            'active'      => true
        ]);
    }

    public function test_federal_district_create_relationships_regions_data_n_required_validate()
    {
        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => FederalDistrict::TYPE_RESOURCE,
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 'Description shortly',
                    'active'      => true,
                ],
                'relationships' => [
                    'regions' => [
                        'data' => [
                            [

                            ],
                            [

                            ]
                        ]
                    ]
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.relationships.regions.data.0 field is required.',
                        'source'  => [
                            'pointer' => '/data/relationships/regions/data/0',
                        ]
                    ],
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.relationships.regions.data.1 field is required.',
                        'source'  => [
                            'pointer' => '/data/relationships/regions/data/1',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('federal_districts', [
            'name'        => 'Северо-западный федеральный округ',
            'description' => 'Description shortly',
            'slug'        => 'severo-zapadnyy-federalnyy-okrug',
            'active'      => true
        ]);
    }

    public function test_federal_district_create_relationships_regions_data_n_must_be_an_array_validate()
    {
        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => FederalDistrict::TYPE_RESOURCE,
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 'Description shortly',
                    'active'      => true,
                ],
                'relationships' => [
                    'regions' => [
                        'data' => [
                            "test",
                            "test"
                        ]
                    ]
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.relationships.regions.data.0 must be an array.',
                        'source'  => [
                            'pointer' => '/data/relationships/regions/data/0',
                        ]
                    ],
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.relationships.regions.data.1 must be an array.',
                        'source'  => [
                            'pointer' => '/data/relationships/regions/data/1',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('federal_districts', [
            'name'        => 'Северо-западный федеральный округ',
            'description' => 'Description shortly',
            'slug'        => 'severo-zapadnyy-federalnyy-okrug',
            'active'      => true
        ]);
    }

    public function test_federal_district_create_relationships_regions_data_n_item_invalid_validate()
    {
        $federalDistrictions = FederalDistrict::factory()->create();

        $regions = Region::factory()->count(3)->create([
            'federal_district_id' => $federalDistrictions->first()->id,
        ]);

        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => FederalDistrict::TYPE_RESOURCE,
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 'Description shortly',
                    'active'      => true,
                ],
                'relationships' => [
                    'regions' => [
                        'data' => [
                            [
                                'id' => $regions->first()->id
                            ],
                            [
                                'type' => Region::TYPE_RESOURCE
                            ]
                        ]
                    ]
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.relationships.regions.data.0.type field must be present.',
                        'source'  => [
                            'pointer' => '/data/relationships/regions/data/0/type',
                        ]
                    ],
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The data.relationships.regions.data.1.id field must be present.',
                        'source'  => [
                            'pointer' => '/data/relationships/regions/data/1/id',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('federal_districts', [
            'name'        => 'Северо-западный федеральный округ',
            'description' => 'Description shortly',
            'slug'        => 'severo-zapadnyy-federalnyy-okrug',
            'active'      => true
        ]);
    }

    public function test_federal_district_create_relationships_regions_data_n_item_present_validate()
    {
        $federalDistrictions = FederalDistrict::factory()->create();

        $regions = Region::factory()->count(3)->create([
            'federal_district_id' => $federalDistrictions->first()->id,
        ]);

        $this->postJson('/api/v1/federal-districts', [
            'data' => [
                'type' => FederalDistrict::TYPE_RESOURCE,
                'attributes' => [
                    'name'        => 'Северо-западный федеральный округ',
                    'description' => 'Description shortly',
                    'active'      => true,
                ],
                'relationships' => [
                    'regions' => [
                        'data' => [
                            [
                                'id' => $regions->first()->id,
                                'type' => 'test'
                            ],
                            [
                                'id' => 677778888,
                                'type' => Region::TYPE_RESOURCE
                            ]
                        ]
                    ]
                ]
            ]
        ], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json',
        ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The selected data.relationships.regions.data.0.type is invalid.',
                        'source'  => [
                            'pointer' => '/data/relationships/regions/data/0/type',
                        ]
                    ],
                    [
                        'title'   => 'Validation Error',
                        'details' => 'The selected data.relationships.regions.data.1.id is invalid.',
                        'source'  => [
                            'pointer' => '/data/relationships/regions/data/1/id',
                        ]
                    ]
                ]
            ]);
    }
}
