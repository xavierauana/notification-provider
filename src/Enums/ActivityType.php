<?php
/**
 * Author: Xavier Au
 * Date: 16/3/2018
 * Time: 8:13 AM
 */

namespace Anacreation\Notification\Provider\Enums;


class ActivityType
{
    const QUEUED  = 0;
    const SUCCESS = 1;

    // Sendgrid 9 Event
    const PROCESSED   = 2;
    const DROPPED     = 3;
    const DEFERRED    = 4;
    const BOUNCE      = 5;
    const DELIVERED   = 6;
    const OPEN        = 7;
    const CLICK       = 8;
    const SPAM        = 9;
    const UNSUBSCRIBE = 10;

    // Nexmo Delivery Receipt Status Possible Value
    const EXPIRED  = 11;
    const FAILED   = 12;
    const REJECTED = 13;
    const ACCEPT   = 14;
    const BUFFERED = 15;
    const UNKNOWN  = 16;
}