<?php

namespace Bandaid\BandaidUserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends ContainerAware
{


    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'bandaid_bandaid_user_homepage'));
        $menu->addChild ('Login', array('route' => 'fos_user_security_login'));
        return $menu;
    }
}