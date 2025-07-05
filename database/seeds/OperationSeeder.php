<?php

use Illuminate\Database\Seeder;
use App\Models\Operation;
class OperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $test=Operation::create([
            'name'=>'Less Than',
            'operands'=>"1",
            "operand_type"=>'numberic'
        ]);

        $test=Operation::create([
            'name'=>'Less Than or Equal',
            'operands'=>"1",
            "operand_type"=>'numberic'
        ]);

        $test=Operation::create([
            'name'=>'greater Than',
            'operands'=>"1",
            "operand_type"=>'numberic'
        ]);

        $test=Operation::create([
            'name'=>'greater Than or Equal',
            'operands'=>"1",
            "operand_type"=>'numberic'
        ]);

        $test=Operation::create([
            'name'=>'between',
            'operands'=>"2",
            "operand_type"=>'numberic'
        ]);
    }
}
