<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MemosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 3) as $num) {
            DB::table('memos')->insert([
                'body' => "メモ {$num}",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
