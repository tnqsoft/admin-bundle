<?php

namespace TNQSoft\AdminBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class BaseService
{
    /**
    * @var Container
    */
    protected $container;

    /**
    * Set Container
    *
    * @param Container $container
    */
    public function setContainer(Container $container) {
        $this->container = $container;
    }

    /**
    * Get Service
    *
    * @param  string $serviceName
    * @return Object Service
    */
    public function get($serviceName)
    {
        return $this->container->get($serviceName);
    }
}
