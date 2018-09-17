<?php
/**
 * Author: Xavier Au
 * Date: 10/3/2018
 * Time: 11:05 AM
 */

namespace Anacreation\School\Notification\Provider\ServiceProviders;


use Anacreation\Notification\Provider\Contracts\CommunicationResponseInterface;
use Anacreation\Notification\Provider\Contracts\SmsSender;
use Anacreation\Notification\Provider\ServiceProviders\NexmoResponse;
use Illuminate\Support\Facades\Log;
use Nexmo\Client;
use Nexmo\Client\Credentials\Basic;

class Nexmo implements SmsSender
{

    private $client;
    private $to;
    private $from;
    private $message;
    private $response;

    /**
     * Nexmo constructor.
     * @param string $apiKey
     * @param string $secret
     */
    public function __construct(string $apiKey, string $secret) {
        $this->client = new Client(new Basic($apiKey, $secret));
    }

    public function to(string $receiverNumber): SmsSender {
        $this->to = $receiverNumber;

        return $this;
    }

    public function from(string $senderNumber): SmsSender {
        $this->from = $senderNumber;

        return $this;
    }

    public function message(string $message): SmsSender {
        $this->message = $message;

        return $this;
    }

    public function send(): CommunicationResponseInterface {
        $data = [
            'to'   => $this->to,
            'text' => $this->message,
            'from' => $this->from
        ];

        $response = null;

        try {
            $response = $this->client->message()->send($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }


        $this->response = new NexmoResponse($response);

        return $this->response;
    }

    public function getResponse(): CommunicationResponseInterface {

        return $this->response;
    }

}