<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TaskTestJson;

class TaskTest extends TestCase
{

    // Remove token after 5 min.
    protected $token = '3|XtMELPNwpTp5G5sGemyNNVDUwguPVN9KZs2jBv5V';

    // test new create artisan command

    public function test_artisan_command_login()
    {
        $this->artisan('login:{login}', ['login' => 'tester@tester.ru', 'password' => '123123123'])->assertExitCode(0);
    }

    // test get item by id, checking the json structure for compliance
    // method get

    public function test_get_task_by_id()
    {
        $task_id = TaskTestJson::all()->random()->id;
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->get('/api/edit/' . $task_id)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'message',
                    'code',
                    'data' => [
                        'items' => [
                            'id',
                            'item',
                            'item2',
                            'item3',
                            'user_id'
                        ],
                    ],
                ]
            );
    }

    // test get item by id, checking the json structure for compliance
    // method post

    public function test_post_task_by_id(Type $var = null)
    {
        $task_id = TaskTestJson::all()->random()->id;
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->post('/api/edit/' . $task_id)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'message',
                    'code',
                    'data' => [
                        'items' => [
                            'id',
                            'item',
                            'item2',
                            'item3',
                            'user_id'
                        ],
                    ],
                ]
            );
    }

    // test create task
    // method get
    public function test_method_get_create_task(Type $var = null)
    {
        $test2 = [
            "value" => "TEST_GET_METHOD1",
        ];

        $data = [
            'item2' => (object) $test2,
            'item3' => [
                'TEST_GET_METHOD2'
            ],
            'item' => 'TEST_GET_METHOD3',
        ];

        $this->withHeader('Authorization', 'Bearer ' . $this->token)->json('GET', 'api/store', ["data" => json_encode($data)])->assertStatus(200);
    }

    // test create task
    // method post
    public function test_method_post_create_task(Type $var = null)
    {
        $test2 = [
            "value" => "TEST_POST_METHOD1",
        ];

        $data = [
            "data" => [
                'item2' => (object) $test2,
                'item3' => [
                    'TEST_POST_METHOD2'
                ],
                'item' => 'TEST_POST_METHOD3',
            ]
        ];

        $this->withHeader('Authorization', 'Bearer ' . $this->token)->json('POST', 'api/store', $data)->assertStatus(200);
    }
}
