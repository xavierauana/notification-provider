<?php
/**
 * Author: Xavier Au
 * Date: 12/4/2018
 * Time: 1:54 AM
 */

namespace Anacreation\Notification\Provider\ServiceProviders;


use Anacreation\Notification\Provider\Contracts\WebhookParser;
use Anacreation\Notification\Provider\Enums\ActivityType;

class SendGridWebhookParser implements WebhookParser
{
    public function parse($data): void {
        foreach ($data as $event) {
            $event = (object)$event;
            $type = $this->getType($event);
            $content = json_encode($event);

            //            ActivityLog::create([
            //                'type'          => $type,
            //                'channel'       => 'email',
            //                'provider'      => SendGrid::class,
            //                'to'            => $event->email,
            //                'receiver_type' => $event->receiver_type,
            //                'receiver_id'   => $event->receiver_id,
            //                'notice_id'     => $event->notice_id,
            //                'content'       => $content,
            //            ]);
        }
    }

    private function getType($event): ?int {
        switch ($event->event) {
            case strtolower("PROCESSED")   :
                return ActivityType::PROCESSED;
            case strtolower("DROPPED"):
                return ActivityType::DROPPED;
            case strtolower("DEFERRED"):
                return ActivityType::DEFERRED;
            case strtolower("BOUNCE"):
                return ActivityType::BOUNCE;
            case strtolower("DELIVERED"):
                return ActivityType::DELIVERED;
            case strtolower("OPEN"):
                return ActivityType::OPEN;
            case strtolower("CLICK"):
                return ActivityType::CLICK;
            case "spamreport":
                return ActivityType::SPAM;
            case strtolower("UNSUBSCRIBE"):
                return ActivityType::UNSUBSCRIBE;
            default:
                return null;
        }
    }
}