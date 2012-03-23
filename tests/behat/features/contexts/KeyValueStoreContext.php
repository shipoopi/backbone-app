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
    Core\Service\HookRunner,
    Core\Util\KeyValueStore;
use Test\Mocks\RequestGenerationHookMock;
use PHPUnit_Framework_Assert as Assert;

/**
 * Description of FrontControllerHookRegistration
 *
 * @author hashin
 */
class KeyValueStoreContext extends BehatContext
{

    private $keyValueStore;
    private $parameter;

    /**
     * @Given /^a KeyValueStore$/
     */
    public function aKeyvaluestore()
    {
        $this->keyValueStore = new KeyValueStore();
    }

    /**
     * @Given /^I set parameter "([^"]*)" with value "([^"]*)"$/
     */
    public function iSetParameterWithValue($name, $value)
    {
        $this->keyValueStore->set($name, $value);
    }

    /**
     * @When /^I get parameter "([^"]*)"$/
     */
    public function iGetParameter($name)
    {
        $this->parameter = $this->keyValueStore->get($name);
    }

    /**
     * @Then /^parameter is "([^"]*)"$/
     */
    public function parameterIs($value)
    {
        Assert::assertEquals($value, $this->parameter, 'Value is different');
    }

    /**
     * @Then /^parameter is null$/
     */
    public function parameterIsNull()
    {
        Assert::assertNull($this->parameter, 'Parameter is not null');
    }

    /**
     * @When /^I get parameter with no key throws Exception$/
     */
    public function iGetParameterWithNoKeyThrowsException()
    {
        try {
            $this->keyValueStore->get(null);
            throw new Exception('Expecting exception');
        } catch (\Exception $e) {
            
        }
    }

}