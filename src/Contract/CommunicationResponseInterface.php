<?php
/**
 * Author: Xavier Au
 * Date: 9/3/2018
 * Time: 2:19 PM
 */

namespace Anacreation\Notification\Provider\Contracts;


interface CommunicationResponseInterface
{
    public function isOkay(): bool;

    public function getResponse();
}