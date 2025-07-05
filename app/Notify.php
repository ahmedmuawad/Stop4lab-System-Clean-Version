<?php

namespace App;

use App\Models\User;

use App\Models\FirebaseToken;
use Illuminate\Support\Facades\App;

class Notify
{

    // GET TOKEN OF SEND TO NOTIFICATION 
    public static function getTokens($send_to, $id = null)
    {
        if ($send_to == "users") {
            return FirebaseToken::whereHas('user', function ($query) use ($id) {
                $query->where('is_notifiy', 1);
            })->where('type' , 'user')->whereIn('user_id', $id->pluck('id')->toArray())->pluck('token_firebase');
        } elseif($send_to == "patients")
        {
            return FirebaseToken::whereHas('patient', function ($query) use ($id) {
                $query->where('is_notifiy', 1);
            })->where('type' , 'patient')->whereIn('user_id', $id->pluck('id')->toArray())->pluck('token_firebase');
        }
    } // end of function get tokens


    // SEND NOTIFICATION TO USER IN MOBILE
    public static function NotifyMobile($title, $message, $send_to, $user_send_to, $user_id = null)
    {
        $labName = setting('info');

        // dd($send_to);
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $tokenList;

        $tokenList = SELF::getTokens($send_to, $user_send_to);

        // dd($tokenList);
        $notification = [
            'title' => $labName['name'],
            'body' => $message,
            'user_id' => $user_id,
            'image' => '/assets/images/logo/logo.png',
            'sound' => true,
        ];

        $extraNotificationData = [
            'user_id' => $user_id,
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "sound" => "default",
            "badge" => "8",
            "color" => "#ffffff",
            "priority" => "high",
        ];

        $fcmNotification = [
            'registration_ids' => $tokenList, //multple token array
            'notification' => $notification,
            'data' => $extraNotificationData,
        ];

        $headers = [
            'Authorization: key=AAAAjpwsr-s:APA91bFQNSSPoHoYdYXOVCHVi-0KCjG6hkSZEern5Lv8CKnxA5jwk1HGeZSQfrFvexgdYqMALtSuecqFCrw_BQUiBtxoMIFsUcPHPNivxAjXwrXFxiLtRI76nv66w-0V4Hv3NevhAc88',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        // dd($result);
        curl_close($ch);
    } // end of NotifyMobile

    // SEND NOTIFICATION TO  USER WEB
    public static function NotifyWeb($title, $message, $send_to, $user_send_to, $user_id = null, $type = null, $modal_id = null)
    {

        $tokenList = [];

        if ($send_to == 'admin') {
            $tokenList = SELF::getTokens($send_to, $user_send_to);
        } elseif ($send_to == 'user') {
            $tokenList = SELF::getTokens($send_to, $user_send_to);
        }

        $SERVER_API_KEY = 'AAAAsrgXhEw:APA91bFXgAqyh1XC3hw34peNB-y-ofCCleWpjZdmw_SDxsD8mQLwyeG9JiBGEAPfU-fEIom4DDeeVpuedW4OTAcENqpxvBKzNFrysz0R3h7aB6cn707fJtfXOggDBhNrNqGEpRKBbv0U';

        $data = [

            "registration_ids" => $tokenList,
            "notification" => [

                'body'  =>  $message,
                'title'  => $title,
                "icon"  => url("uploads/signature/1.png"),
                "sound"  => true,
            ],
            "data" => [
                "link" => $type ? route('dashboard.users.show', $user_id) : '',
                'users' => $user_send_to,
            ]
        ];


        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        dd($response);

        // return
    } 
    // end of notify web

} // end of class