<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    protected $headers = ['Accept' => 'application/json'];

    public function testRequiredFieldsForRegistration()
    {
        $this->json('POST', 'api/register', $this->headers)
            ->assertStatus(422)
            // ->assertJson([
            //     "message" => "The given data was invalid.",
            //     "errors" => [
            //         "name" => ["The name field is required."],
            //         "email" => ["The email field is required."],
            //         "password" => ["The password field is required."],
            //     ]
            // ]);
            ->assertJson([
                "message" => "The name field is required. (and 2 more errors)",
                "errors" => [
                    "name" => [
                        "The name field is required."
                    ],
                    "email" => [
                        "The email field is required."
                    ],
                    "password" => [
                        "The password field is required."
                    ]
                ]
            ])
            ->assertJsonStructure([
                "errors",
                "message"
            ]);
    }

    public function testRepeatPassword()
    {
        $userData = [
            "name" => "Ravuthz 001",
            "email" => "ravuthz+001@gmail.com",
            "password" => "RavuthzOO1"
        ];

        $this->json('POST', 'api/register', $userData, $this->headers)
            ->assertStatus(422)
            // ->assertJson([
            //     "message" => "The given data was invalid.",
            //     "errors" => [
            //         "password" => ["The password confirmation does not match."]
            //     ]
            // ]);
            ->assertJson([
                "message" => "The password confirmation does not match.",
                "errors" => [
                    "password" => [
                        "The password confirmation does not match."
                    ]
                ]
            ])
            ->assertJsonStructure([
                "errors",
                "message"
            ]);
    }

    public function testSuccessfulRegistration()
    {
        $userData = [
            "name" => "Ravuthz 001",
            "email" => "ravuthz+001@gmail.com",
            "password" => "RavuthzOO1",
            "password_confirmation" => "RavuthzOO1"
        ];

        $this->json('POST', 'api/register', $userData, $this->headers)
            ->assertStatus(201)
            ->assertJsonStructure([
                "data" => [
                    "user" => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                    "token",
                ],
                "errors",
                "message",
            ]);
    }
}
