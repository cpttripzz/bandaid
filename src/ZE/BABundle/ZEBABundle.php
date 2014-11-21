<?php

namespace ZE\BABundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ZEBABundle extends Bundle
{
//    public function boot()
//    {
//        // implement alias XR for base namespace
//        $em = $this->container->get("doctrine.orm.entity_manager");
//        $config = $em->getConfiguration();
//        $config->addEntityNamespace("ZEBA", "ZE\\BABundle\\Entity\\Address");
//    }
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
