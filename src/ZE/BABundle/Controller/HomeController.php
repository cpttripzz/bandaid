<?php
namespace ZE\BABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction(){
        return $this->render(
            'ZEBABundle:Home:index.html.twig'
        );
    }
}