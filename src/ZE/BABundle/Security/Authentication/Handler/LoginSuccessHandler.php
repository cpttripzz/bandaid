<?php
namespace ZE\BABundle\Security\Authentication\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\Container;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{

    protected $router;
    protected $security;
    protected $session;
    protected $api;
    public function __construct(Container $container)
    {
        $this->router = $container->get('router');
        $this->security = $container->get('security.context');
        $this->api = $container->get('buzz');
    }

    public function setSession($session=null)
    {
        $this->session = $session;
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {

        if ($this->security->isGranted('ROLE_SUPER_ADMIN') || ($this->security->isGranted('ROLE_ADMIN')) )
        {
            $response = new RedirectResponse($this->router->generate('sonata_admin_dashboard'));
        }
        elseif ($this->security->isGranted('ROLE_USER'))
        {
            $key = 'currentUrl';

            if ($this->session->has($key)) {
                $url = $this->session->get($key);
                $baseUrl = $this->router->getContext()->getBaseUrl();
                $this->session->remove($key);
                $response = new RedirectResponse($baseUrl .$url);
//                try{
//                    $apiResponse = $this->api->get('http://localhost:26300/register-user/'. $this->session->getId());
//                }
//                catch(\Exception $e){}
//                if($apiResponse->getStatusCode() == 200)
            } else {
                $response = new RedirectResponse($this->router->generate('home'));
            }
        }

        return $response;
    }

}