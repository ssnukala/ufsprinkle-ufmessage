<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\UfMessage\Controller\Mail;

/**
 * This example shows how to send via Google's Gmail servers using XOAUTH2 authentication.
 */

//Import PHPMailer classes into the global namespace
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Core\Mail\TwigMailMessage;

/**
 * UfMessenger Class.
 *
 * A sending Messages to useres within the UF application using template-based emails.
 *
 * @author Srinivas Nukala (https://srinivasnukala.com)
 */

class UfmTwigMailMessage extends TwigMailMessage
{
    /**
     * {@inheritdoc}
     */
    public function getParam($param = '')
    {
        Debug::debug("Line 36 getting param $param from ", $this->params['ufmessage']);
        if ($param != '') {
            return $this->params['ufmessage'][$param];
        } else {
            return $this->params['ufmessage'];
        }
    }
}
