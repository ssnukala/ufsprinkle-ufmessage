<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\UfMessage\Controller;

/**
 * This example shows how to send via Google's Gmail servers using XOAUTH2 authentication.
 */

//Import PHPMailer classes into the global namespace
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Core\Mail\MailMessage;
use UserFrosting\Sprinkle\UfMessage\Database\Models\UfMessage;

/**
 * UfMessenger Class.
 *
 * A sending Messages to useres within the UF application using template-based emails.
 *
 * @author Srinivas Nukala (https://srinivasnukala.com)
 */

class UfMessenger
{
    /**
     * @var Logger
     */
    protected $config;
    /**
     * Create a new Mailer instance.
     *
     * @param mixed[] $config An array of configuration parameters for UfMessage.
     *
     * @throws phpmailerException Wrong mailer config value given.
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        //Debug::debug("Line 57 the oauth Config params are ", $config);
    }

    public function getMailName($name, $email)
    {
        return $name . "<$email>";
    }
    /**
     * Create a MailMessage message.
     *
     * Creates the phpMailer object ready to be sent.
     * this can be used by subsequent functions to send or capture the MIME contents etc.
     *
     * @param MailMessage $message
     *
     */
    public function createMessage($event, MailMessage $message)
    {
        $message = [];
        //$message['from'] = $this->getMailName($message->getFromName(), $message->getFromEmail());
        $message['from'] = $message->getFromEmail();
        $toemail = [];
        // Add all email recipients, as well as their CCs and BCCs
        foreach ($message->getRecipients() as $recipient) {
            //            $toemail['to'][] = $this->getMailName($recipient->getName(), $recipient->getEmail());
            $toemail['to'][] = $recipient->getEmail();

            // Add any CCs and BCCs
            if ($recipient->getCCs()) {
                foreach ($recipient->getCCs() as $cc) {
                    //$toemail['cc'][] = $this->getMailName($cc['name'], $cc['email']);
                    $toemail['cc'][] = $cc['email'];
                }
            }

            if ($recipient->getBCCs()) {
                foreach ($recipient->getBCCs() as $bcc) {
                    //$toemail['bcc'][] = $this->getMailName($bcc['name'], $bcc['email']);
                    $toemail['bcc'][] = $bcc['email'];
                }
            }
        }

        $message['event'] = $event; //email;
        $message['type'] = 'E'; //email;
        $message['visible'] = 'Y'; //email;
        $message['notification'] = 'Y'; //email;
        $message['to'] = implode(',', $toemail['to']);
        $message['cc'] = implode(',', $toemail['cc']);
        $message['bcc'] = implode(',', $toemail['bcc']);
        $message['subject']  = $message->renderSubject();
        $message['body']  = $message->renderBody();
        $message['message_date']  = date('Y-m-d H:i:s');

        //return $this->phpMailer;
    }

    /**
     * Send a MailMessage message.
     *
     * Sends a single email to all recipients, as well as their CCs and BCCs.
     * Since it is a single-header message, recipient-specific template data will not be included.
     *
     * @param MailMessage $message
     * @param bool        $clearRecipients Set to true to clear the list of recipients in the message after calling send().  This helps avoid accidentally sending a message multiple times.
     *
     * @throws phpmailerException The message could not be sent.
     */
    public function send($event, MailMessage $message, $clearRecipients = true)
    {
        Debug::debug("Line 203 Gmailer initiating message");
        $this->createMessage($event, $message);
        // Try to send the mail.  Will throw an exception on failure.
        $this->phpMailer->send();
        Debug::debug("Line 207 Gmailer After Send Command");

        // Clear recipients from the PHPMailer object for this iteration,
        // so that we can use the same object for other emails.
        $this->phpMailer->clearAllRecipients();

        // Clear out the MailMessage's internal recipient list
        if ($clearRecipients) {
            $message->clearRecipients();
        }
    }
}
