<?php
/**
 * Author: Xavier Au
 * Date: 10/3/2018
 * Time: 11:03 AM
 */

namespace Anacreation\Notification\Provider\Contracts;


interface SmsSender
{

    public function __construct(string $username, string $password);

    /**
     * @param string $receiverNumber
     */
    public function to(string $receiverNumber): SmsSender;

    /**
     * @param string $senderNumber
     */
    public function from(string $senderNumber): SmsSender;

    /**
     * @param string $message
     */
    public function message(string $message): SmsSender;

    /**
     */
    public function send(): CommunicationResponseInterface;

    /**
     * @return mixed
     */
    public function getResponse(): CommunicationResponseInterface;
}