<?php

/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */

/*
 * Core configuration file for UserFrosting.  You must override/extend this in your site's configuration file.
 *
 * Sensitive credentials should be stored in an environment variable or your .env file.
 * Database password: DB_PASSWORD
 * SMTP server password: SMTP_PASSWORD
 */
return [
    'ufmessenger' => [
        'notify' => 'Y',
        'expire' => 100
    ]
];
