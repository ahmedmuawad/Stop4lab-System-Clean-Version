<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Setting::where('key','reports')->delete();
        Setting::where('key','account')->delete();
        Setting::create([
          'key'=>'portal',
          'value'=>null,
        ]);
        Setting::insert(['key' => 'account' , 'value' => json_encode([
          "expenses_type" => "custody",
          "branch" => "1",
          "payment" => "1",
          "show_discount_value" => true,
          "show_discount_persentage" => true,
          "show_test_prices" => true,
          "tax" => true,
          "tax_persentage" => "14",
          ])]);


        Setting::insert([
            [
                'key'=>'reports',
                'value'=>json_encode(
                    [                                                                                                                                      
                        "show_header" => true,
                        "show_footer" => true,
                        "show_signature" => true,
                        "show_qrcode" => true,
                        "report_paid_stauts" => true,
                        "show_avatar" => true,
                        "header-margin-top" => "75",
                        "header-margin-right" => "5",
                        "header-margin-bottom" => "35",
                        "header-margin-left" => "5",
                        "content-header-margin-top" => "0",
                        "content-header-margin-bottom" => "2",
                        "margin-top" => "80",
                        "margin-right" => "5",
                        "margin-bottom" => "35",
                        "margin-left" => "5",
                        "content-margin-top" => "35",
                        "content-margin-bottom" => "2",
                        "qrcode-dimension" => "120",
                        "report_header" => [
                          "text-align" => "center",
                          "border-color" => "rgb(0, 0, 0)",
                          "border-width" => "1",
                          "background-color" => "rgb(255, 255, 255)",
                        ],
                        "branch_name" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "12",
                        ],
                        "branch_info" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "12",
                        ],
                        "patient_title" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "13",
                        ],
                        "patient_data" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "13",
                        ],
                        "test_title" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "24",
                          "height" => "1",
                          "text-align" => "center",
                        ],
                        "test_name" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "14",
                          "height" => "4",
                          "text-align" => "left",
                        ],
                        "test_head" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "14",
                          "height" => "4",
                          "text-align" => "left",
                        ],
                        "result" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "14",
                          "height" => "4",
                          "text-align" => "left",
                        ],
                        "unit" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "14",
                          "height" => "4",
                          "text-align" => "left",
                        ],
                        "reference_range" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "14",
                          "height" => "4",
                          "text-align" => "left",
                        ],
                        "status" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "14",
                          "height" => "4",
                          "text-align" => "left",
                        ],
                        "comment" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "14",
                          "height" => "4",
                          "text-align" => "left",
                        ],
                        "signature" => [
                          "color" => "#ff0202",
                          "font-family" => "sans-serif",
                          "font-size" => "12",
                        ],
                        "antibiotic_name" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "14",
                        ],
                        "sensitivity" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "12",
                        ],
                        "commercial_name" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "12",
                        ],
                        "report_footer" => [
                          "color" => "#000000",
                          "font-family" => "sans-serif",
                          "font-size" => "12",
                          "text-align" => "center",
                          "border-color" => "rgb(0, 0, 0)",
                          "border-width" => "1",
                          "background-color" => "rgb(255, 255, 255)",
                        ],
                        "qrcode_to_account" => false,
                        "qrcode_to_pdf" => false,
                        "report_sign_stauts" => false,
                        "show_status" => true,
                        "show_unit" => true,
                        "show_range" => true,
                      ]
                )
            ],
        ]);
        // Setting::insert(['key' => 'portal' , 'value' => 'soon']);
        $reports_settings = setting('reports');
        $test_settings = json_encode($reports_settings);

        DB::table('group_tests')->where('setting',null)->update(['setting' => $test_settings ]);


    }
}
