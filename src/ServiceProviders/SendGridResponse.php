<?php
/**
 * Author: Xavier Au
 * Date: 16/3/2018
 * Time: 8:02 AM
 */

namespace Anacreation\Notification\Provider\ServiceProviders;


use Anacreation\Notification\Provider\Contracts\CommunicationResponseInterface;
use SendGrid\Response;

class SendGridResponse implements CommunicationResponseInterface
{
    /**
     * @var \SendGrid\Response
     */
    private $response;


    /**
     * SendGridResponse constructor.
     * @param \SendGrid\Response $response
     */
    public function __construct(Response $response) {
        $this->response = $response;
    }


    public function isOkay(): bool {
        return $this->response->statusCode() >= 200 and $this->response->statusCode() <= 299;
    }

    /**
     * @return \SendGrid\Response
     */
    public function getResponse() {
        return $this->response;
    }
}