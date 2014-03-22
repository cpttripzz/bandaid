<?php

namespace ZE\BABundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext
                  implements KernelAwareInterface
{
    private $kernel;
    private $parameters;
    private $container;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->container = $kernel->getContainer();
    }
    /**
     * @Given /^I am logged in as admin$/
     */
    public function iAmLoggedInAsAdmin(){
        $this->loginAs('admin', 'admin');
    }

    /**
     * @Given /^I am logged in as Bob$/
     */
    public function iAmLoggedInAsBob(){
        $this->loginAs('bob', 'bob');
    }

    private function loginAs($user, $password){
        $this->visit('/admin/login');
        $this->fillField('username', $user);
        $this->fillField('password', $password);
        $this->pressButton('_submit');
    }
}
