<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\Timezone;
use App\Models\Branch;
use App\Http\Requests\Admin\GeneralSettingRequest;
use App\Http\Requests\Admin\EmailSettingRequest;
use App\Http\Requests\Admin\ReportSettingRequest;
use App\Http\Requests\Admin\SmsSettingRequest;
use App\Http\Requests\Admin\WhatsappSettingRequest;
use App\Http\Requests\Admin\ApiSettingRequest;
use App\Http\Requests\Admin\BarcodeSettingRequest;
use App\Http\Requests\Admin\portalRequest;
use App\Models\PaymentMethod;
use App\Models\TaxType;
use App\Models\Test;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_setting',['only' => [
                                                            'index',
                                                            'info_submit',
                                                            'emails_submit',
                                                            'reports_submit',
                                                            'sms_submit',
                                                            'whatsapp_submit',
                                                            'api_keys_submit',
                                                            'barcode_submit',
                                                            'medical_submit',
                                                            'printer_submit',
                                                        ]]);
    }

    public function index()
    {
        //general
        $settings=setting('info');
        $currencies=Currency::all();
        
        //reports
        $reports_settings=setting('reports');

        //barcode
        $barcode_settings=setting('barcode');

        //medical
        $medical_settings=setting('medical');

        $invoice_setting = setting('invoices');
        //printer spical case

        //$printer_settings= setting('printer') ;
        $printer_settings= (Setting::where('key','printer')->first()) ? setting('printer') : null ;

        //emails
        $emails_settings=setting('emails');

        //sms
        $sms_settings=setting('sms');

        //whatsapp
        $whatsapp_settings=setting('whatsapp');

        //api keys
        $api_keys_settings=setting('api_keys');

        //
        $account_settings=setting('account');

        //timezone
        $timezone_settings=setting('info')['timezone'];
        $timezone_settings=Timezone::where('timezone',$timezone_settings)->first();


        $portal_settings=setting('portal');
        
    

        $report_branches=Branch::all();

        $tests = Test::with('category.parent', 'test_price')->where(function ($q) {
            return $q->where('parent_id', 0)->orWhere('separated', true);
        })->get();

        
        $payment_methods = PaymentMethod::all();

        return view('admin.settings.index',compact(
            'settings',
            'currencies',
            'tests',
            'reports_settings',
            'barcode_settings',
            'medical_settings',
            'invoice_setting',
            'printer_settings',
            'emails_settings',
            'sms_settings',
            'portal_settings',
            'whatsapp_settings',
            'api_keys_settings',
            'timezone_settings',
            'account_settings',
            'report_branches',
            'payment_methods'
        ));
        
    }


    /**
     * update settings info
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function info_submit(GeneralSettingRequest $request)
    {
        //old settings
        // dd($request);
        $old_settings=Setting::where('key','info')->first();
        $old_settings=json_decode($old_settings['value'],true);
        $settings=$request->except('logo','_token');
        
        //social links
        $settings['socials']['facebook']=$request['facebook'];
        $settings['socials']['twitter']=$request['twitter'];
        $settings['socials']['instagram']=$request['instagram'];
        $settings['socials']['youtube']=$request['youtube'];
        $settings['portalID'] = $request['portalID'];
        //update currency cache
        cache()->put('currency',$request['currency']);
    
        //update banner
        if($request->hasFile('banner'))
        {
            $logo=$request->file('banner');
            $logo->move('assets/images','banner.jpg');
        }

        //update logo
        if($request->hasFile('logo'))
        {
           $request->file('logo')->move('img','logo.png');;
        }

        //update reports logo
        if($request->hasFile('reports_logo'))
        {
            $request->file('reports_logo')->move('img','reports_logo.png');
        }

        //update Letterhead-bg
        if($request->hasFile('Letterhead-bg'))
        {
            $extension=$request->file('Letterhead-bg')->getClientOriginalExtension();
            $request->file('Letterhead-bg')->move('img','Letterhead-bg.'.$extension);
            $settings['Letterhead-bg']='Letterhead-bg.'.$extension;
        }


        $info=Setting::where('key','info')->firstOrFail();
        $info->update([
            'value'=>json_encode($settings)
        ]);

       session()->flash('success',__('Settings Updated successfully'));

       return redirect()->route('admin.settings.index');
    }

    

    /**
     * update emails settings
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function emails_submit(EmailSettingRequest $request)
    {
       $settings=$request->except('_token');

       $settings['patient_code']['active']=($request->has('patient_code.active'))?true:false;
       $settings['reset_password']['active']=($request->has('reset_password.active'))?true:false;
       $settings['tests_notification']['active']=($request->has('tests_notification.active'))?true:false;

       //update setting record in database
       $emails=Setting::where('key','emails')->firstOrFail();
       $emails->update([
         'value'=>json_encode($settings)
       ]);
       
       session()->flash('success',__('Settings Updated successfully'));

       return redirect()->route('admin.settings.index');
    }

    /**
     * 
     */

     public function portal_submit(portalRequest $request){
        Log::Info(['re1'=>$request->taxType1]);
        Log::Info(['re2'=>$request->taxType2]);

        $portal_settings=[];

        $portal_settings['name'] = $request->name;
        $portal_settings['gov'] = $request->gov;
        $portal_settings['ID'] = $request->ID;
        $portal_settings['Secret'] = $request->Secret;
        $portal_settings['registerationNumber'] = $request->registerationNumber;
        if(isset($request->taxType1)){
            $portal_settings['taxType1']['id'] = $request->taxType1['id'];
            $portal_settings['taxType1']['value'] = $request->taxType1['value'];    
        }
        
        if(isset($request->taxType2)){
            $portal_settings['taxType2']['id'] = $request->taxType2['id'];
            $portal_settings['taxType2']['value'] = $request->taxType2['value'];    
        }
       
        $portal=Setting::where('key','portal')->firstOrFail();

        $portal->update([
            'value'=>json_encode($portal_settings)
        ]);

        session()->flash('success',__('Settings Updated successfully'));

        return redirect()->route('admin.settings.index');

     }
    /**
     * update reports settings
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reports_submit(ReportSettingRequest $request)
    {
        // dd($request->all());
        $request['show_header']=($request->has('show_header'))?true:false;
        $request['show_footer']=($request->has('show_footer'))?true:false;
        $request['show_signature']=($request->has('show_signature'))?true:false;
        $request['show_avatar']=($request->has('show_avatar'))?true:false;
        $request['show_qrcode']=($request->has('show_qrcode'))?true:false;
        $request['qrcode_to_account']=($request->has('qrcode_to_account'))?true:false;
        $request['qrcode_to_pdf']=($request->has('qrcode_to_pdf'))?true:false;
        $request['report_paid_stauts']=($request->has('report_paid_stauts'))?true:false;
        $request['report_sign_stauts']=($request->has('report_sign_stauts'))?true:false;
        $request['direction']=($request->has('direction'))?true:false;
        $request['show_status']=($request->has('show_status'))?true:false;
        $request['show_unit']=($request->has('show_unit'))?true:false;
        $request['show_range']=($request->has('show_range'))?true:false;
        $request['new_line']=($request->has('new_line'))?true:false;
        $request['highlite']=($request->has('highlite'))?true:false;
        $request['show_s_collection']=($request->has('show_s_collection'))?true:false;
        $request['show_d_collection']=($request->has('show_d_collection'))?true:false;
        $request['show_branch']=($request->has('show_branch'))?true:false;
        $request['show_sign_without_header']=($request->has('show_sign_without_header'))?true:false;
        $request['show_sign_with_header']=($request->has('show_sign_with_header'))?true:false;

        $settings=json_encode($request->except('_method','_token','branches'));

        $reports=Setting::where('key','reports')->firstOrFail();
        $reports->update([
            'value'=>$settings
        ]);

        //report branches
        $branches=Branch::all();

        foreach($branches as $branch)
        {
            $branch->update([
                'show_header_image'=>($request->has('branches.'.$branch['id'].'.show_header_image'))?true:false,
                'show_watermark_image'=>($request->has('branches.'.$branch['id'].'.show_watermark_image'))?true:false,
                'show_footer_image'=>($request->has('branches.'.$branch['id'].'.show_footer_image'))?true:false,
                'report_footer'=>$request['branches'][$branch['id']]['report_footer']
            ]);

            //upload header
            if($request->hasFile('branches.'.$branch['id'].'.header_image'))
            {
                $header_image=$request->file('branches.'.$branch['id'].'.header_image');
                $name='header_'.$branch['id'].'.'.$header_image->getClientOriginalExtension();
                $header_image->move('uploads/branches',$name);
                $branch->update([
                    'header_image'=>$name
                ]);
            }

            //upload watermark
            if($request->hasFile('branches.'.$branch['id'].'.watermark_image'))
            {
                $watermark_image=$request->file('branches.'.$branch['id'].'.watermark_image');
                $name='watermark_'.$branch['id'].'.'.$watermark_image->getClientOriginalExtension();
                $watermark_image->move('uploads/branches',$name);
                $branch->update([
                    'watermark_image'=>$name
                ]);
            }

            //upload footer
            if($request->hasFile('branches.'.$branch['id'].'.footer_image'))
            {
                $footer_image=$request->file('branches.'.$branch['id'].'.footer_image');
                $name='footer_'.$branch['id'].'.'.$footer_image->getClientOriginalExtension();
                $footer_image->move('uploads/branches',$name);
                $branch->update([
                    'footer_image'=>$name
                ]);
            }

        }

        session()->flash('success',__('Settings Updated successfully'));

        return redirect()->route('admin.settings.index');
    }

    /**
     * update reports settings
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sms_submit(SmsSettingRequest $request)
    {
        $settings=$request->except('_method','_token');

        $settings['patient_code']['active']=($request->has('patient_code.active'))?true:false;
        $settings['tests_notification']['active']=($request->has('tests_notification.active'))?true:false;
    
        $sms=Setting::where('key','sms')->firstOrFail();
        $sms->update([
            'value'=>$settings
        ]);

        session()->flash('success',__('Settings Updated successfully'));

        return redirect()->route('admin.settings.index');
    }

    public function invoices_submit(Request $request){
        $invoice = Setting::where('key' , 'invoices')->first();
        $settings=$request->except('_method','_token');
        if(!$invoice){
            Setting::create([
                'key'=>'invoices',
                'value'=>null,
            ]);
        }
        Setting::where('key' , 'invoices')->update([
            'value'=>$settings,
        ]);
        session()->flash('success',__('Settings Updated successfully'));


        return redirect()->route('admin.settings.index');

    }

    /**
     * update whatsapp settings
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function whatsapp_submit(WhatsappSettingRequest $request)
    {
        $whatsapp_settings=[];

        $whatsapp_settings['receipt']['active']=(isset($request['receipt']['active']))?true:false; 
        $whatsapp_settings['report']['active']=(isset($request['report']['active']))?true:false;    
        
        $whatsapp_settings['receipt']['message']=$request['receipt']['message'];
        $whatsapp_settings['report']['message']=$request['report']['message'];


        $whatsapp=Setting::where('key','whatsapp')->firstOrFail();
        $whatsapp->update([
            'value'=>json_encode($whatsapp_settings)
        ]);

        session()->flash('success',__('Settings Updated successfully'));

        return redirect()->route('admin.settings.index');
    }


    /**
     * update api keys settings
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function api_keys_submit(ApiSettingRequest $request)
    {
        $api_keys=[];
        $api_keys['google_map']=$request['google_map'];

        $api_keys_setting=Setting::where('key','api_keys')->firstOrFail();
        $api_keys_setting->update([
            'value'=>json_encode($api_keys)
        ]);

        session()->flash('success',__('Settings Updated successfully'));
       
        return redirect()->route('admin.settings.index');
    }

     /**
     * update barcode settings
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function barcode_submit(Request $request)
    {
        $barcode_settings=Setting::where('key','barcode')->firstOrFail();
        $barcode_settings->update([
            'value'=>json_encode($request->except('_token'))
        ]);

        
        
        session()->flash('success',__('Settings Updated successfully'));
       
        return redirect()->route('admin.settings.index');
    }

    public function medical_submit(Request $request)
    {
        Log::Info(['req'=>$request]);

        $medical_settings = Setting::where('key','medical')->firstOrFail();
        $request['histogram_status']=($request->has('histogram_status'))?true:false;
        $request['sameRefRang'] = ($request->has('sameRefRang'))?true:false;
        $request['low_culture'] = ($request->has('low_culture'))?true:false;
        $request['resistant_culture'] = ($request->has('resistant_culture'))?true:false;

        $request['samePrice'] = ($request->has('samePrice'))?true:false;
        $medical_settings->update([
            'value'=>json_encode($request->except('_token'))
        ]);

        session()->flash('success',__('Settings Updated successfully'));
       
        return redirect()->route('admin.settings.index');

    }

    public function printer_submit(Request $request)
    {
        $printer_settings = Setting::where('key','printer')->firstOrFail();
        $printer_settings->update([
            'value' => json_encode($request->except('_token'))
        ]);

        session()->flash('success',__('Settings Updated successfully'));
       
        return redirect()->route('admin.settings.index');
    }

    public function accounting_submit(Request $request)
    {
        $account_settings = Setting::where('key','account')->firstOrFail();

        $request['show_discount_value']=($request->has('show_discount_value'))?true:false;
        $request['show_discount_persentage']=($request->has('show_discount_persentage'))?true:false;
        $request['show_test_prices']=($request->has('show_test_prices'))?true:false;
        $request['show_test_date']=($request->has('show_test_date'))?true:false;
        $request['show_test_name']=($request->has('show_test_name'))?true:false;
        $request['tax']=($request->has('tax'))?true:false;



        $account_settings->update([
            'value' => json_encode($request->except('_token'))
        ]);

        session()->flash('success',__('Settings Updated successfully'));
       
        return redirect()->route('admin.settings.index');
    }
}
