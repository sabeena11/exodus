<?php

namespace App\Helper;

use Google\Client as Google_Client;
use Google\Service\FirebaseCloudMessaging as Google_Service_FirebaseCloudMessaging;
use GuzzleHttp\Client;

class FCMNotification
{
    public static function sendFCMNotification($fcmtokentopic, $title, $message, $image) {
        $accessToken = self::oauthToken();

        $client = new Client();

        $url = 'https://fcm.googleapis.com/v1/projects/a2zloyaltysystem/messages:send';

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ];

        $body = [
            "message" => [
                "token" => $fcmtokentopic,
                "notification" => [
                    "title" => $title,
                    "body" => $message,
                ],
                "data" => [
                    "title" => $title,
                    "body" => $message,
                    "image" => $image,
                ],
                "android" => [
                    "notification" => [
                      "image" => $image,
                    ],
                    "priority" => "high",
                ],
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "mutable-content" => 1,
                        ],
                    ],
                    "fcm_options" => [
                        "image" => $image,
                    ],
                    "headers" => [
                        "apns-priority" => "5",
                    ],
                ],
            ],
        ];
 
        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $body,
        ]);

        return $response->getStatusCode();
    }

    private static function oauthToken() {
        $client = new Google_Client();
        
        $configFile = base_path('config/a2zloyaltysystem-firebase-adminsdk-ga8ih-3a0fedfe41.json');

        try {
            $client->setAuthConfig($configFile);

            $client->addScope(Google_Service_FirebaseCloudMessaging::CLOUD_PLATFORM);

            $savedTokenJson = self::readSavedToken();

            if ($savedTokenJson) {
                $client->setAccessToken($savedTokenJson);

                $accessToken = $savedTokenJson;

                if ($client->isAccessTokenExpired()) {
                    $accessToken = self::generateToken($client);

                    $client->setAccessToken($accessToken);
                }
            } else {
                $accessToken = self::generateToken($client);

                $client->setAccessToken($accessToken);
            }

            $oauthToken = $accessToken["access_token"];

            return $oauthToken;
        } catch (Google_Exception $e) {

        }

        return false;
    }

    private static function readSavedToken() {
        $tk = @file_get_contents('fcmtoken.cache');

        if ($tk) return json_decode($tk, true); else return false;
    }

    private static function writeToken($tk) {
        file_put_contents("fcmtoken.cache", $tk);
    }

    private static function generateToken($client) {
        $client->fetchAccessTokenWithAssertion();

        $accessToken = $client->getAccessToken();

        $tokenJson = json_encode($accessToken);

        self::writeToken($tokenJson);

        return $accessToken;
    }
}