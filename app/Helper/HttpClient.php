<?php

namespace App\Helper;

use App\Models\User;
use App\Models\AppConfig;
use App\Models\SmsLog;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HttpClient
{
    public static function send_sms($user, $message)
    {
        $app_config = AppConfig::where('enable_sms', '=', "1")->first();

        if ($app_config == null) {
            return 400;
        }

        $client = new Client();

        $url = 'https://sms.aakashsms.com/sms/v3/send';

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $body = [
            'auth_token' => $app_config->sms_token,
            'to' => $user->mobile,
            'text' => $message,
        ];
 
        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $body,
        ]);

        // Store the SMS log data
        $smsLogData = [
            'user_id' => $user->id,
            'message' => $message,
            'response' => $response->getBody()->getContents(),
            'status_code' => $response->getStatusCode(),
            'created' => now(),
            'success' => ($response->getStatusCode() == 200) ? 1 : 0,
        ];

        
        SmsLog::create($smsLogData);

        return $response->getStatusCode();
  

        //  // Store the SMS log data without sending the actual SMS
        //  $smsLogData = [
        //     'user_id' => $user->id,
        //     'message' => $message,
        //     'response' => 'SMS not sent (logging only)',
        //     'status_code' => 200, // Assuming the SMS log is successful since no actual SMS is sent
        //     'created' => now(),
        //     'success' => 1, // Assuming the SMS log is successful since no actual SMS is sent
        // ];

        // SmsLog::create($smsLogData);

        // return 200; // Return a success status code
    }
}