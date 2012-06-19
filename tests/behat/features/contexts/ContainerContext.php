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
use Core\DependencyInjection\Container;

/**
 * Description of FrontControllerHookRegistration
 *
 * @author hashin
 */
class ContainerContext extends BehatContext
{

    private $container;
    private $database;

    /**
     * @Given /^container$/
     */
    public function container()
    {
        $this->container = new Container();
    }

    /**
     * @Given /^root configuration with no configuration$/
     */
    public function rootConfigurationWithNoConfiguration()
    {
        $this->container->setConfiguration(array(
            'dependencies' => array(
                'database' => array(
                    'type' => 'Test\Database'
                )
            )
        ));
    }

    /**
     * @When /^I get dependency$/
     */
    public function iGetDependency()
    {
        $this->database = $this->container->get('database');
    }

    /**
     * @Then /^object property is unchanged$/
     */
    public function objectPropertyIsUnchanged()
    {
        $reflClass = new ReflectionClass($this->database);
        $reflHost = $reflClass->getProperty('host');
        $reflHost->setAccessible(true);
        $value = $reflHost->getValue($this->database);
        Assert::assertNull($value);
    }

    /**
     * @Given /^root configuration with configuration$/
     */
    public function rootConfigurationWithConfiguration()
    {
        $this->container->setConfiguration(array(
            'dependencies' => array(
                'nonConfigurable' => array(
                    'type' => 'Test\NonConfigurable',
                    'configuration' => array(
                        'host' => 'localhost'
                    )
                )
            )
        ));
    }

    /**
     * @When /^I get a non configurable dependency I get exception$/
     */
    public function iGetANonConfigurableDependencyIGetException()
    {
        try {
            $dependency = $this->container->get('nonConfigurable');
            throw new Exception('expecting non configurable exception');
        } catch (LogicException $e) {
            
        }
        
    }
    
    /**
     * @When /^I get dependency I get exception$/
     */
    public function iGetDependencyIGetException()
    {
        try {
            $this->database = $this->container->get('database');
            throw new Exception('expecting exception');
        } catch (LogicException $e) {
        }
    }
    
     /**
     * @Given /^root configuration with scalar configuration$/
     */
    public function rootConfigurationWithScalarConfiguration()
    {
         $this->container->setConfiguration(array(
            'dependencies' => array(
                'database' => array(
                    'type' => 'Test\Database',
                    'configuration' => array(
                        'host' => 'localhost'
                    )
                )
            )
        ));
    }

    /**
     * @Then /^value is changed for the dependency$/
     */
    public function valueIsChangedForTheDependency()
    {
        $reflClass = new ReflectionClass($this->database);
        $reflHost = $reflClass->getProperty('host');
        $reflHost->setAccessible(true);
        $value = $reflHost->getValue($this->database);
        Assert::assertEquals('localhost', $value, 'Value is not changed');
    }

    /**
     * @Given /^root configuration with configuration having service reference$/
     */
    public function rootConfigurationWithConfigurationHavingServiceReference()
    {
        $this->container->setConfiguration(array(
            'dependencies' => array(
                'localhost' => array('type' => 'Test\Host'),
                'database' => array(
                    'type' => 'Test\Database',
                    'configuration' => array(
                        'host' => '@localhost'
                    )
                )
            )
        ));
    }

    /**
     * @Then /^the value is a service$/
     */
    public function theValueIsAService()
    {
        $reflClass = new ReflectionClass($this->database);
        $reflHost = $reflClass->getProperty('host');
        $reflHost->setAccessible(true);
        $value = $reflHost->getValue($this->database);
        Assert::assertTrue($value instanceof \Test\Host);
    }


}