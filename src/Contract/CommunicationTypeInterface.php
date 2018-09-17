<?php
/**
 * Author: Xavier Au
 * Date: 9/3/2018
 * Time: 2:19 PM
 */

namespace Anacreation\Notification\Provider\Contracts;


use Illuminate\Database\Eloquent\Relations\Relation;

interface CommunicationTypeInterface
{
    public function channel(): Relation;

    public function getTypeAttribute(): string;

    public function getValueAttribute(): string;
}