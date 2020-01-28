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
//use UserFrosting\Sprinkle\Core\Mail\MailMessage;
use UserFrosting\Sprinkle\UfMessage\Controller\Mail\UfmTwigMailMessage;
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
    public function createMessage(UfmTwigMailMessage $mailobj)
    {
        $message = [];
        //$message['from'] = $this->getMailName($message->getFromName(), $message->getFromEmail());
        $message['from'] = $mailobj->getFromEmail();
        $toemail = ["to" => [], 'cc' => [], 'bcc' => []];
        // Add all email recipients, as well as their CCs and BCCs
        foreach ($mailobj->getRecipients() as $recipient) {
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
        $message['event'] = $mailobj->getUfParam('event'); //event name;
        if ($message['event'] === false) {
            $message['event'] = 'General';
        }
        $message['user_id'] = $mailobj->getUfParam('user_id'); //user id
        if ($message['user_id'] === false) {
            //$currentUser = $this->ci->currentUser;
            $message['user_id'] = $this->ci->currentUser->id;
        }
        $message['created_by'] = $message['user_id'];
        $message['type'] = $mailobj->getUfParam('type');
        if ($message['type'] === false) {
            $message['type'] = 'GEN';
        }
        $message['visible'] = 'Y'; //email;
        $message['notification'] = 'Y'; //email;
        $message['to'] = implode(',', $toemail['to']);
        $message['cc'] = implode(',', $toemail['cc']);
        $message['bcc'] = implode(',', $toemail['bcc']);
        $message['subject']  = $mailobj->renderSubject();
        $message['body']  = $mailobj->renderBody();
        // this will send the ufmessage array as context for the mail
        // plan to use this to trigger actions based on responses to the message from the user        
        $context = $mailobj->getMessageContext();

        if ($context !== false) {
            $message['context']  = $context;
        }
        $message['message_date']  = date('Y-m-d H:i:s');
        $expdays = $this->config['expire'] ? $this->config['expire'] : 100;
        $message['expire_date']  = date('Y-m-d H:i:s', strtotime("+$expdays days"));
        return $message;
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
    public function send(UfmTwigMailMessage $message, $clearRecipients = true)
    {
        //Debug::debug("Line 203 UFMessenger initiating message");
        $mesgdata = $this->createMessage($message);

        $ufmesg = new UfMessage($mesgdata);
        $ufmesg->save();

        //$this->phpMailer->send();
        //Debug::debug("Line 207 UFMessenger After Send Command");

        // Clear out the MailMessage's internal recipient list
        if ($clearRecipients) {
            $message->clearRecipients();
        }
    }

    /**
     * Send a MailMessage message, sending a separate email to each recipient.
     *
     * If the message object supports message templates, this will render the template with the corresponding placeholder values for each recipient.
     *
     * @param MailMessage $message
     * @param bool        $clearRecipients Set to true to clear the list of recipients in the message after calling send().  This helps avoid accidentally sending a message multiple times.
     *
     * @throws phpmailerException The message could not be sent.
     */
    public function sendDistinct(UfmTwigMailMessage $message, $clearRecipients = true)
    {
        // To be implemented
        $this->phpMailer->From = $message->getFromEmail();
        $this->phpMailer->FromName = $message->getFromName();
        $this->phpMailer->addReplyTo($message->getReplyEmail(), $message->getReplyName());

        // Loop through email recipients, sending customized content to each one
        foreach ($message->getRecipients() as $recipient) {
            $this->phpMailer->addAddress($recipient->getEmail(), $recipient->getName());

            // Add any CCs and BCCs
            if ($recipient->getCCs()) {
                foreach ($recipient->getCCs() as $cc) {
                    $this->phpMailer->addCC($cc['email'], $cc['name']);
                }
            }

            if ($recipient->getBCCs()) {
                foreach ($recipient->getBCCs() as $bcc) {
                    $this->phpMailer->addBCC($bcc['email'], $bcc['name']);
                }
            }

            $this->phpMailer->Subject = $message->renderSubject($recipient->getParams());
            $this->phpMailer->Body = $message->renderBody($recipient->getParams());

            // Try to send the mail.  Will throw an exception on failure.
            $this->phpMailer->send();

            // Clear recipients from the PHPMailer object for this iteration,
            // so that we can send a separate email to the next recipient.
            $this->phpMailer->clearAllRecipients();
        }

        // Clear out the MailMessage's internal recipient list
        if ($clearRecipients) {
            $message->clearRecipients();
        }
    }
}
