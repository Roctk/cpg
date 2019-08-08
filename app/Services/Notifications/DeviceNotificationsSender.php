<?php

namespace App\Services\Notifications;

class DeviceNotificationsSender
{
    const FCM_ENDPOINT = 'https://fcm.googleapis.com/fcm/send';

    /** @var  string */
    private $apiKey;

    /** @var  string */
    private $topic;

    public function __construct(string $apiKey, string $topic)
    {
        $this->apiKey = $apiKey;
        $this->topic = $topic;
    }

    public function sendNotification(array $data)
    {
        /*api_key available in:
        Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
        $apiKey = $this->apiKey;

        $fields = [
            'to' => '/topics/'.$this->topic,
            'data' => $data
        ];

        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$apiKey
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::FCM_ENDPOINT);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}