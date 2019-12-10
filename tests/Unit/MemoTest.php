<?php

namespace Tests\Unit;

use App\Memo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    // テストケースごとに DB をリフレッシュ
    use RefreshDatabase;

    /**
     * Memo#getFormattedCreatedAtAttribute
     *
     * @return void
     */
    public function test_getFormattedCreatedAtAttribute()
    {
        $memo = new Memo();
        $memo->body = 'test';
        $memo->save();

        $this->assertRegExp('/[0-9]{4}\/[0-9]{2}\/[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $memo->getFormattedCreatedAtAttribute());
    }
}
