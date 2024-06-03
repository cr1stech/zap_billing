<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $sid;
    protected $token;
    protected $from;
    protected $client;

    public function __construct()
    {
        $this->sid = env('TWILIO_SID');
        $this->token = env('TWILIO_AUTH_TOKEN');
        $this->from = 'whatsapp:' . env('TWILIO_PHONE_NUMBER');
        $this->client = new Client($this->sid, $this->token);
    }

    public function sendMessage($to, $message)
    {
        return $this->client->messages->create(
            'whatsapp:' . $to,
            [
                'from' => $this->from,
                'body' => $message,
            ]
        );
    }
}

