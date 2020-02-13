<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Document;

class DocumentsTest extends TestCase
{
    use RefreshDatabase;

    public function testDocumentAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = [
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
            'Authorization' => "Bearer $token"
        ];
        $document = [
            'status' => 'draft',
            'payload' => ["Lorem" => "Ipsum"],
            'user_id' => $user->id,
        ];

        $this->json('POST', route('create.document'), $document, $headers)
            ->assertStatus(201)
            ->assertJson([
                'status' => 'draft',
                'payload' => json_encode(["Lorem" => "Ipsum"]),
                'user_id' => $user->id,
            ]);
    }

    public function testDocumentArePatchedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = [
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
            'Authorization' => "Bearer $token"
        ];
        $document = factory(Document::class)->create([
            'status' => 'draft',
            'payload' =>  json_encode([
                "First key" => "Default value",
                "Second key" => "Default value"
            ]),
            'user_id' => $user->id,
        ]);

        $payload = [
            'payload' => [
                "First key" => "Changed value",
                "Second key" => null,
                "Third key" => "New value",
            ],
        ];

        $this->json('PATCH', route('edit.document', ['id' => $document->id]), $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'id' => $document->id,
                'status' => 'draft',
                'payload' => json_encode([
                    "First key" => "Changed value",
                    "Third key" => "New value",
                ])
            ]);
    }

    public function testDocumentsAreListedCorrectly()
    {
        $headers = [
            'Accept' => 'application/json',
        ];
        $document1 = factory(Document::class)->create([
            'payload' => json_encode([
                "First key" => "Default value of 1-st doc",
                "Second key" => "Default value of 1-st doc",
            ]),
            'user_id' => 1,
        ]);

        $document2 = factory(Document::class)->create([
            'payload' => json_encode([
                "First key" => "Default value of 2-nd doc",
                "Second key" => "Default value of 2-nd doc",
            ]),
            'user_id' => 1,
        ]);

        $this->json('GET', route('get.documents', ['page' => 1, 'perPage' => 2]), [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'document' => [
                        [
                            'id' => $document2->id,
                            'status' => 'draft',
                            'payload' => [
                                "First key" => "Default value of 2-nd doc",
                                "Second key" => "Default value of 2-nd doc",
                            ],
                            'createdAt' => $document2->created_at,
                            'modifyAt' => $document2->modify_at,
                        ],
                        [
                            'id' => $document1->id,
                            'status' => 'draft',
                            'payload' => [
                                "First key" => "Default value of 1-st doc",
                                "Second key" => "Default value of 1-st doc",
                            ],
                            'createdAt' => $document1->created_at,
                            'modifyAt' => $document1->modify_at,
                        ],
                    ],
                ],
            ]);
    }
}
