<?php
/**
 * Author: Xavier Au
 * Date: 10/3/2018
 * Time: 11:07 AM
 */

namespace Anacreation\Notification\Provider\ServiceProviders;


use Anacreation\Notification\Provider\Contracts\CommunicationResponseInterface;
use Anacreation\Notification\Provider\Contracts\EmailSender;
use Anacreation\Notification\Provider\Contracts\WebhookParser;
use SendGrid as SG;
use SendGrid\MailSettings;
use SendGrid\ReplyTo;
use SendGrid\SandBoxMode;

class SendGrid implements EmailSender
{
    /**
     * @var WebhookParser.
     */
    private $webhookParser = null;
    private $sg;
    private $from;
    private $to;
    private $subject;
    private $cc = [];
    private $bcc = [];
    private $contents = [];
    private $replyTo;
    private $response;
    private $settings;

    /**
     * SendGrid constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password) {
        $this->sg = new SG($password);

        $this->webhookParser = new SendGridWebhookParser();
    }

    public function from(string $name, string $fromEmailAddress): EmailSender {
        $this->from = new SG\Email($name, $fromEmailAddress);

        return $this;
    }

    public function to(string $name, string $toEmailAddress): EmailSender {
        $this->to = new SG\Email($name, $toEmailAddress);

        return $this;
    }

    public function subject(string $subject = null): EmailSender {
        $this->subject = $subject ?? "";

        return $this;
    }

    public function cc(array $emailAddresses): EmailSender {
        $this->cc = $emailAddresses;

        return $this;
    }

    public function bcc(array $emailAddresses): EmailSender {
        $this->bcc = $emailAddresses;

        return $this;
    }

    public function textContent(string $content): EmailSender {

        $this->contents[] = new SG\Content("text/plain", $content);

        return $this;
    }

    public function htmlContent(string $content): EmailSender {
        $this->contents[] = new SG\Content("text/html", $content);

        return $this;
    }

    public function replyTo(string $emailAddress, string $name = null
    ): EmailSender {

        $this->replyTo = new ReplyTo($emailAddress, $name);

        return $this;
    }

    public function send(array $customParams): CommunicationResponseInterface {

        $mail = $this->constructSGMail();

        $this->addCCRecipients($mail);

        $this->addCustomArgs($mail, $customParams);

        $this->addReplyTo($mail);

        $this->enableSandboxMode($mail);

        $this->response = new SendGridResponse($this->sg->client->mail()
                                                                ->send()
                                                                ->post($mail));

        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getResponse(): CommunicationResponseInterface {

        return $this->response;
    }

    private function addCustomArgs(SG\Mail &$mail, array $params): void {

        foreach ($params as $key => $value) {
            $mail->personalization[0]->addCustomArg($key, $value);
        }
    }

    /**
     * Parse webhook event
     * @param $data
     */
    public function parse($data): void {
        if ($this->webhookParser) {
            $this->webhookParser->parse($data);
        }
    }


    /**
     * @param WebhookParser $webhookParser
     */
    public function setWebhookParser(WebhookParser $webhookParser): void {
        $this->webhookParser = $webhookParser;
    }


    public function enableSendBox(): EmailSender {
        if ($this->settings === null) {
            $this->settings = new MailSettings();
        }
        $this->settings->setSandBoxMode(new SandBoxMode(true));

        return $this;
    }

    /**
     * @return null|\SendGrid\Mail
     * @throws \Exception
     */
    private function constructSGMail() {
        $mail = null;

        foreach ($this->contents as $content) {
            if ($mail) {
                $mail->addContent($content);
            } else {
                if (!$this->from) {
                    throw new \InvalidArgumentException("From Address is missing");
                }
                $mail = new SG\Mail($this->from, $this->subject, $this->to,
                    $content);
            }
        }

        if ($mail === null) {
            throw new \Exception("No mail object!");
        }

        return $mail;
    }

    /**
     * @param $mail
     */
    private function addCCRecipients(&$mail): void {
        foreach ($this->cc as $cc) {
            $mail->personalization[0]->addCc($cc);
        }

        foreach ($this->bcc as $bcc) {
            $mail->personalization[0]->addBcc($bcc);
        }
    }

    /**
     * @param $mail
     */
    private function addReplyTo(&$mail): void {
        if ($this->replyTo) {
            $mail->setReplyTo($this->replyTo);
        }
    }

    private function enableSandboxMode(&$mail) {
        if ($this->settings) {
            $mail->setMailSettings($this->settings);
        }
    }

}
