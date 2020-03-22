<?php

namespace UserFrosting\Sprinkle\UfMessage\Controller\Util;

use Carbon\Carbon;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Sprinkle\UfMessage\Controller\Mail\UfmTwigMailMessage;
use UserFrosting\Sprinkle\Core\Mail\EmailRecipient;

/**
 * Rules controller
 *
 * @package UserFrosting-RegSevak
 * @author Srinivas Nukala
 * @link http://srinivasnukala.com
 */
class UfMessageUtilController extends SimpleController
{
    public function sendGenericMessage($subject, $text, $data = [], $type = 'GEN', $event = 'General')
    {
        $message = new UfmTwigMailMessage($this->ci->view, 'mail/ufmessage.html.twig');
        $user = $this->ci->currentUser->only(['id', 'full_name', 'first_name', 'last_name', 'email']);

        $admuser = $this->ci->config['address_book.admin'];
        $message->from([
            'email' => $admuser['email'], 'name' => $admuser['name']
        ]);
        $toemail = new EmailRecipient($user['email'], $user['full_name']);
        $message->addEmailRecipient($toemail);

        $message->addParams([
            'user' => $user,
            'ufmessage' => [
                'subject' => $subject, 'user_id' => $user['id'],
                'event' => $event, 'type' => $type,
                'data' => $data, 'message_text' => $text
            ], 'context' => false //just send the ufmessage array as context
        ]);

        $this->ci->ufmessenger->send($message);
    }

    public function sendAdminAlertMessage($subject, $text, $data = [], $type = 'ALR', $event = 'Admin Alert')
    {
        $message = new UfmTwigMailMessage($this->ci->view, 'mail/system.html.twig');
        $user = $this->ci->currentUser->only(['id', 'full_name', 'first_name', 'last_name', 'email']);

        $admuser = $this->ci->config['address_book.admin'];
        $message->from([
            'email' => $admuser['email'], 'name' => $admuser['name']
        ]);
        $toemail = new EmailRecipient($admuser['email'], $admuser['name']);
        $message->addEmailRecipient($toemail);

        $message->addParams([
            'user' => $user,
            'ufmessage' => [
                'subject' => $subject, 'user_id' => $user['id'],
                'event' => $event, 'type' => $type,
                'data' => $data, 'message_text' => $text
            ], 'context' => false //just send the ufmessage array as context
        ]);

        $this->ci->ufmessenger->send($message);
    }
}
