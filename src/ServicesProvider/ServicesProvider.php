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
use UserFrosting\Sprinkle\UfMessage\Database\Models\UfMessage;
use UserFrosting\Sprinkle\UfMessage\Twig\UfMessageExtension;

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
        $container['ufmessenger'] = function ($c) {
            $mailer = new UfMessenger($c->config['ufmessenger']);
            Debug::debug("Line 44 ServiceProvider config ufmessage is ", $c->config['ufmessenger']);
            // Use UF debug settings to override any service-specific log settings.

            return $mailer;
        };

        $container->extend('classMapper', function ($classMapper, $c) {
            $classMapper->setClassMapping('uf_message', 'UserFrosting\Sprinkle\UfMessage\Database\Models\UfMessage');
            $classMapper->setClassMapping('uf_message_sprunje', 'UserFrosting\Sprinkle\UfMessage\Sprunje\UfMessageSprunje');
            return $classMapper;
        });

        $container['ufMessages'] = function ($c) {
            try {
                $currentUser = $c->currentUser;
                $ufmessages = UfMessage::select('id', 'body', 'message_date')
                    ->where('user_id', $currentUser->id)
                    ->where('status', 'A')->orderBy('message_date', 'DESC')->limit(5)->get();
                return $ufmessages->toArray();
            } catch (\Exception $e) {
                return ['uf_messages' => []];
            }
        };

        /*
         * Extends the 'view' service with the UfMessageExtension for Twig.
         *
         * Adds messages to the View
         *
         * @return \Slim\Views\Twig
         */
        $container->extend('view', function ($view, $c) {
            $twig = $view->getEnvironment();
            $extension = new UfMessageExtension($c);
            $twig->addExtension($extension);

            try {
                /** @var \UserFrosting\Sprinkle\Account\Authenticate\Authenticator $authenticator */
                $ufmessages = $c->ufMessages;
            } catch (\Exception $e) {
                return $view;
            }

            return $view;
        });
    }
}
