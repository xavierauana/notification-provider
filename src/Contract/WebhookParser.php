<?php
/**
 * Author: Xavier Au
 * Date: 12/4/2018
 * Time: 1:53 AM
 */

namespace Anacreation\Notification\Provider\Contracts;


interface WebhookParser
{
    public function parse($data): void;
}