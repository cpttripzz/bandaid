<?php

namespace ZE\BABundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {

        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('Home', array('route' => 'homepage'))
            ->setAttribute('icon', 'fa fa-list');

        $menu->addChild('Musicians', array('route' => 'musician'))
            ->setAttribute('icon', 'fa fa-music');

        $menu->addChild('Bands', array('route' => 'band'))
            ->setAttribute('icon', 'fa fa-group');
        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');
        if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))) {
            $username = $this->container->get('security.context')->getToken()->getUser()->getUsername();

            $menu->addChild('User', array('label' => 'Hi ' . $username))
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'icon-user');

            $menu['User']->addChild('Edit profile', array('route' => 'fos_user_profile_edit'))
                ->setAttribute('icon', 'icon-edit');
            $menu['User']->addChild('Messages', array('route' => 'message'))
                ->setAttribute('badge', 0)
                ->setAttribute('id', 'new_messages');
            $menu['User']->addChild('Logout', array('route' => 'fos_user_security_logout'))
                ->setAttribute('icon', 'fa fa-sign-out');
        } else {
            $menu->addChild('User', array('label' => 'Hi Visitor' ))
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'icon-user');
            $menu['User']->addChild('Login', array('route' => 'fos_user_security_login'))
                ->setAttribute('icon', 'fa fa-sign-in')
                ->setAttribute('data-toggle','modal')
                ->setAttribute('data-target','#login_modal')
                ->setAttribute('id', 'btn_modal_login')

            ;
        }


        return $menu;
    }
}