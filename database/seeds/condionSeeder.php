<?php

use Illuminate\Database\Seeder;
use App\Models\Condition;
class condionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Condition::create([
            'name'=>'C.Low'
        ]); 

        Condition::create([
            'name'=>'Low'
        ]); 

        Condition::create([
            'name'=>'Normal'
        ]); 

        Condition::create([
            'name'=>'High'
        ]); 

        Condition::create([
            'name'=>'C.High'
        ]); 
    }
}
