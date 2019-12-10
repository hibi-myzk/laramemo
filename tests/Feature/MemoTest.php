<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MemoTest extends TestCase
{
    // テストケースごとに DB をリフレッシュ
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('MemosTableSeeder');
    }

    /*
     * 本文が空の場合はバリデーションエラー
     * 
     * @return void
     */
    public function testBodyShouldNotBeBlank()
    {
        $response = $this->post('/memos', [
            'body' => '',
        ]);

        $response->assertSessionhasErrors([
            'body' => '本文 は必須です。',
        ]);
    }
}
