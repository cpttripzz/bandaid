<?php
namespace ZE\BABundle\Security\Authentication\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function __construct(Container $container)
    {
        $this->router = $container->get('router');
        $this->security = $container->get('security.context');
    }

    public function setSession($session=null)
    {
        $this->session = $session;
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $returnUrl = '';
        if ($this->security->isGranted('ROLE_SUPER_ADMIN') || ($this->security->isGranted('ROLE_ADMIN')) )
        {
            $returnUrl = $this->router->generate('sonata_admin_dashboard');
        }
        elseif ($this->security->isGranted('ROLE_USER'))
        {
            $key = 'currentUrl';

            if ($this->session->has($key)) {
                $url = $this->session->get($key);
                $baseUrl = $this->router->getContext()->getBaseUrl();
                $this->session->remove($key);

                $returnUrl = $baseUrl .$url;
            } else {
                $returnUrl = $this->router->generate('home');
            }
        }
        if ($request->isXmlHttpRequest()) {
            $result = array('success' => true, 'url'=>$returnUrl);
            $response = new JsonResponse($result);
        } else {
            $response = new RedirectResponse($returnUrl);
        }
        return $response;
    }

}