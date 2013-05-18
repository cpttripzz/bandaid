<?php

/**
 * This file is part of the FOSRestBandaid package.
 *
 * (c) Santiago Diaz <santiago.diaz@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Bandaid\BandaidUserBundle\Controller;

use Bandaid\BandaidUserBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\View\View AS FOSView;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * Controller that provides Restfuls security functions.
 *
 * @Prefix("/security")
 * @NamePrefix("Bandaid_demo_securityrest_")
 * @author Santiago Diaz <santiago.diaz@me.com>
 */
class SecurityController extends Controller
{

    /**
     * WSSE Token generation
     *
     * @return FOSView
     * @throws AccessDeniedException
     * @ApiDoc()
     */
    public function postTokenCreateAction()
    {

        $view = FOSView::create();
        $request = $this->getRequest();

        $username = $request->get('_username');
        $password = $request->get('_password');

        //$csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
        //$data = array('csrf_token' => $csrfToken,);

        $um = $this->get('fos_user.user_manager');
        $user = $um->findUserByUsernameOrEmail($username);

        if (!$user instanceof User) {
            throw new AccessDeniedException("Wrong user");
        }

        $created = date('c');
//        $created = '123456';
        $nonce = substr(md5(uniqid('nonce_', true)), 0, 16);
//        $nonce= '123456';
//        die($password);
        $nonceHigh = base64_encode($nonce);
        $password = base64_encode( hash('sha512', $password ."{".$user->getSalt()."}", true));
        $passwordDigest = base64_encode(sha1($nonce . $created .$password, true));
        $header = "UsernameToken Username=\"{$username}\", PasswordDigest=\"{$passwordDigest}\", Nonce=\"{$nonceHigh}\", Created=\"{$created}\"";
        $view->setHeader("Authorization", 'WSSE profile="UsernameToken"');
        $view->setHeader("X-WSSE", "UsernameToken Username=\"{$username}\", PasswordDigest=\"{$passwordDigest}\", Nonce=\"{$nonceHigh}\", Created=\"{$created}\"");
        $data = array('WSSE' => $header);
        $view->setStatusCode(200)->setData($data);
        return $view;
    }

  /**
     * WSSE Token Remove
     *
     * @return FOSView
     * @ApiDoc()
     */
    public function getTokenDestroyAction()
    {
        $view = FOSView::create();
        $security = $this->get('security.context');
        $token = new AnonymousToken(null, new User());
        $security->setToken($token);
        $this->get('session')->invalidate();
        $view->setStatusCode(200)->setData('Logout successful');
        return $view;
    }
}
