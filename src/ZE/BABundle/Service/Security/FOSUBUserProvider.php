<?php


namespace ZE\BABundle\Service\Security;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

class FOSUBUserProvider extends BaseClass
{

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();

        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';


        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }

        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());

        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        list($service, $username, $user, $email) = $this->getUserNameByServiceType($response);

        if (null === $user) {

            $setter = 'set'.ucfirst($service);
            $setter_id = $setter.'Id';
            $setter_token = $setter.'AccessToken';
            // create new user here
            $user = $this->userManager->createUser();
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());
            //I have set all requested data with the user's username
            //modify here with relevant data
            $user->setUsername($username);
            if($email){
                $user->setEmail($email);
            }

            $user->setPassword(md5(microtime()));
            $user->setEnabled(true);
            $this->userManager->updateUser($user);
            return $user;
        }

        //if user exists - go with the HWIOAuth way
        list($service, $username, $user) = $this->getUserNameByServiceType($response);

        $setter = 'set' . ucfirst($service) . 'AccessToken';

        //update access token
        $user->$setter($response->getAccessToken());

        return $user;
    }

    protected function loadUserByOAuthUserResponseAndNickName($response)
    {
        $username = $response->getNickname();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        return $user;
    }

    protected function loadUserByOAuthUserResponseAndRealName($response)
    {
        $username = $response->getRealName();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        return $user;
    }

    /**
     * @param UserResponseInterface $response
     * @return array
     */
    public function getUserNameByServiceType(UserResponseInterface $response)
    {
        $service = $response->getResourceOwner()->getName();
        if ($service == 'facebook') {
            $username = $response->getRealName();

            $user = $this->loadUserByOAuthUserResponseAndRealName($response);
            return array($service, $username, $user, 'fixme');
        } else {
            $username = $response->getNickname();
            $email = $response->getEmail();
            $user = $this->loadUserByOAuthUserResponseAndNickName($response);
            return array($service, $username, $user, $email);
        }
    }

}