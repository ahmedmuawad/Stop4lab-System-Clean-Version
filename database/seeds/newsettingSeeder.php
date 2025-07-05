<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class newsettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'key' => 'invoices',
            'value' => json_encode([
                "direction" => "ltr",
                "font_size" => "15",
                "font-family" => "cairo"
            ])
        ]);
    }
}
