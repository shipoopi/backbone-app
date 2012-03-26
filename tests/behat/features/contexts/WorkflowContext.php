<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Core\Util\Validator,
    Core\Service\Workflow,
    Core\Service\ControllerBus;

use Test\Mocks\RequestGenerationHookMock;

use PHPUnit_Framework_Assert as Assert;



/**
 * Description of FrontControllerHookRegistration
 *
 * @author hashin
 */
class WorkflowContext extends BehatContext
{
    private $hookRunner;
    private $requestGenerationHook;
    private $controllerBus;
    private $request;
    
    private function getHookRunnerCache()
    {
        $reflHook = new ReflectionObject($this->hookRunner);
        $reflCache = $reflHook->getProperty('steps');
        $reflCache->setAccessible(true);
        return $reflCache->getValue($this->hookRunner);
    }
    /**
     * @Given /^a HookRunner$/
     */
    public function aHookrunner()
    {
        $this->hookRunner = new Workflow(new Core\Util\KeyValueStore());
    }
    
    /**
     * @Given /^a request generation hook$/
     */
    public function aRequestGenerationHook()
    {
        $this->requestGenerationHook = new RequestGenerationHookMock();
    }

    /**
     * @When /^I register the hook$/
     */
    public function iRegisterTheHook()
    {
        $this->hookRunner->addStep($this->requestGenerationHook);
    }
    
    /**
     * @Then /^hookRunner has the hook in the cache$/
     */
    public function hookrunnerHasTheHookInTheCache()
    {
        $cache = $this->getHookRunnerCache();
        Assert::assertContains(
            $this->requestGenerationHook, $cache, 'Hook not registered');
    }

     /**
     * @When /^I run the hooks$/
     */
    public function iRunTheHooks()
    {
        $this->controllerBus = $this->hookRunner->run();
    }

    /**
     * @Then /^result is controller bus object$/
     */
    public function resultIsControllerBusObject()

    {
        Assert::assertInstanceOf(
            'Core\Util\KeyValueStoreInterface', $this->controllerBus);
    }
    
    /**
     * @Given /^controller bus has the request object$/
     */
    public function controllerBusHasTheRequestObject()
    {
        $this->request = $this->controllerBus->get('request');
        Assert::assertInstanceOf('Core\Service\Request', $this->request,
            'Invalid request object');
    }


}