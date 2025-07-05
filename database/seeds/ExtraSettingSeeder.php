<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class ExtraSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = Setting::where('key','account')->first();
        if(!$setting){
            Setting::insert(['key' => 'account' , 'value' => 'text']);
        }

    }
}
