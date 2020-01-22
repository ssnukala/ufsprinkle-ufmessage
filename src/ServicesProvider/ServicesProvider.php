<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\UfMessage\ServicesProvider;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Illuminate\Database\Capsule\Manager as Capsule;
use Interop\Container\ContainerInterface;
use UserFrosting\Sprinkle\UfMessage\Controller\UfMessenger;
use UserFrosting\Sprinkle\Core\Facades\Debug;

/**
 * UserFrosting APIMail services provider.
 *
 * Registers core services for Google OAuth Mail for UserFrosting.
 *
 * @author Srinivas Nukala (https://srinivasnukala.com)
 */
class ServicesProvider
{
    /**
     * Register UserFrosting's core services.
     *
     * @param ContainerInterface $container A DI container implementing ArrayAccess and container-interop.
     */
    public function register(ContainerInterface $container)
    {

        /*
         * Mail service.
         *
         * @return \UserFrosting\Sprinkle\Core\Mail\Mailer
         */
        $container['ufmessage'] = function ($c) {
            $mailer = new UfMessenger($c->config['ufmessage']);
            Debug::debug("Line 44 ServiceProvider config ufmessage is ", $c->config['ufmessage']);
            // Use UF debug settings to override any service-specific log settings.

            return $mailer;
        };

        $container->extend('classMapper', function ($classMapper, $c) {
            $classMapper->setClassMapping('uf_message', 'UserFrosting\Sprinkle\UfMessage\Database\Models\UfMessage');
            $classMapper->setClassMapping('uf_message_sprunje', 'UserFrosting\Sprinkle\UfMessage\Sprunje\UfMessageSprunje');
            return $classMapper;
        });
    }
}
