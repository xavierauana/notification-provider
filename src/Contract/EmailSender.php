<?php
/**
 * Author: Xavier Au
 * Date: 10/3/2018
 * Time: 11:06 AM
 */

namespace Anacreation\Notification\Provider\Contracts;


interface EmailSender
{
    public function __construct(string $username, string $password);

    public function from(string $name, string $fromEmailAddress): EmailSender;

    public function to(string $name, string $toEmailAddress): EmailSender;

    public function subject(string $sg): EmailSender;

    public function cc(array $emailAddresses): EmailSender;

    public function bcc(array $emailAddresses): EmailSender;

    public function textContent(string $content): EmailSender;

    public function htmlContent(string $content): EmailSender;

    public function replyTo(string $emailAddress): EmailSender;

    public function send(array $customParams): CommunicationResponseInterface;

    public function getResponse(): CommunicationResponseInterface;

    public function setWebhookParser(WebhookParser $webhookParser): void;

    public function enableSendBox(): void;


    /**
     * Parse webhook event
     * @param $data
     */
    public function parse($data): void;
}