<?php
/**
 * Author: Xavier Au
 * Date: 16/3/2018
 * Time: 8:01 AM
 */

namespace Anacreation\Notification\Provider\ServiceProviders;


use Anacreation\Notification\Provider\Contracts\CommunicationResponseInterface;
use Nexmo\Message\Message;

class NexmoResponse implements CommunicationResponseInterface
{

    private $nexmo;

    /**
     * SmsResponse constructor.
     * @param \Nexmo\Message\Message|null $nexmo
     */
    public function __construct(Message $nexmo = null) {
        $this->nexmo = $nexmo;
    }

    public function isOkay(): bool {
        return $this->nexmo->getStatus() === 0;
    }

    public function getResponse() {
        return $this->nexmo;
    }
}