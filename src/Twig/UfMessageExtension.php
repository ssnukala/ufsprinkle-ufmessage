<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\UfMessage\Twig;

use Psr\Container\ContainerInterface;
use UserFrosting\Support\Repository\Repository as Config;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

/**
 * Extends Twig functionality for the Account sprinkle.
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 */
class UfMessageExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var ContainerInterface
     */
    protected $services;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param ContainerInterface $services
     */
    public function __construct(ContainerInterface $services)
    {
        $this->services = $services;
        $this->config = $services->config;
    }

    public function getName()
    {
        return 'userfrosting/ufmessage';
    }

    public function getGlobals()
    {
        try {
            $ufMessages = $this->services->ufMessages;
        } catch (\Exception $e) {
            $ufMessages = null;
        }

        return [
            'uf_messages'   => $ufMessages,
        ];
    }
}
