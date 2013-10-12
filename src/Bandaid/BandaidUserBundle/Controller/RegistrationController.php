<?php
    namespace Bandaid\BandaidUserBundle\Controller;

    use Symfony\Component\HttpFoundation\RedirectResponse;
    use FOS\UserBundle\Controller\RegistrationController as BaseController;
    use Bandaid\BandaidUserBundle\Entity\Entity;
    use Bandaid\BandaidUserBundle\Entity\EntityType;
    use FOS\UserBundle\FOSUserEvents;
    use FOS\UserBundle\Event\FormEvent;
    use FOS\UserBundle\Event\GetResponseUserEvent;
    use FOS\UserBundle\Event\FilterUserResponseEvent;
    use Symfony\Component\HttpFoundation\Request;

    class RegistrationController extends BaseController
    {
        /**
         * Shortcut to return the Doctrine Registry service.
         *
         * @return Registry
         *
         * @throws \LogicException If DoctrineBundle is not available
         */
        public function getDoctrine()
        {
            if (!$this->container->has('doctrine')) {
                throw new \LogicException('The DoctrineBundle is not registered in your application.');
            }

            return $this->container->get('doctrine');
        }

        public function registerAction(Request $request,$typeId)
        {
            /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
            $formFactory = $this->container->get('fos_user.registration.form.factory');
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->container->get('fos_user.user_manager');
            /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');
            $user = $userManager->createUser();
            $user->setEnabled(true);

            $event = new GetResponseUserEvent($user, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }

            $form = $formFactory->createForm();
            $form->setData($user);

            if ('POST' === $request->getMethod()) {
                $form->bind($request);

                if ($form->isValid()) {
                    $event = new FormEvent($form, $request);
                    $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                    $userManager->updateUser($user);


                    if (null === $response = $event->getResponse()) {
                        $entityTypeId = $request->query->get('type');
                        $entityType = $this->getDoctrine()
                            ->getRepository('BandaidBandaidUserBundle:EntityType')
                            ->find('EntityType', $entityTypeId);
                        $entity = new Entity();
                        $entity->setEntityType($entityType);

                        $url = $this->container->get('router')->generate('fos_user_registration_confirmed');
                        $response = new RedirectResponse($url);
                    }

                    $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                    return $response;
                }
            }

            return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
                                                                                                                                         'form' => $form->createView(),
                                                                                                                                         'typeId' => $typeId
                                                                                                                                     ));
        }


    }