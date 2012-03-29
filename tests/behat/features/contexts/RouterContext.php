<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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

use Core\Service\Router,
    Core\Service\Route;

use Test\Mocks\RequestMock;

/**
 * Description of ServiceControllerResolverContext
 *
 * @author hashinpanakkaparambil
 */
class RouterContext extends BehatContext
{
    private $directory;
    private $router;
    private $request;
    private $route;
    private $exptectedRoute;
    
    /**
     * @Given /^empty directory$/
     */
    public function emptyDirectory()
    {
        $this->directory = new DirectoryIterator(__DIR__ 
            . '/fixtures/empty-controller-directory');
    }

    /**
     * @Given /^router$/
     */
    public function router()
    {
        $this->router = new Router($this->directory);
    }

    /**
     * @Given /^a request$/
     */
    public function aRequest()
    {
        $this->request = new RequestMock();
    }

    /**
     * @Given /^I resolve the route$/
     */
    public function iResolveTheRoute()
    {
        $this->route = $this->router->resolveRoute($this->request);
    }

    /**
     * @Then /^route is null$/
     */
    public function routeIsNull()
    {
        Assert::assertNull($this->route);
    }

    /**
     * @Given /^a directory with no php files$/
     */
    public function aDirectoryWithNoPhpFiles()
    {
        $this->directory = new DirectoryIterator(
            __DIR__ . '/fixtures/dir-no-php-files');
    }

    /**
     * @Given /^a directory having no classes with route annotation$/
     */
    public function aDirectoryHavingNoClassesWithRouteAnnotation()
    {
        $this->directory = new DirectoryIterator(
            __DIR__ . '/fixtures/no-route-annotation');
    }

    /**
     * @Given /^a directory having no media type with route annotation$/
     */
    public function aDirectoryHavingNoMediaTypeWithRouteAnnotation()
    {
        $this->directory = new DirectoryIterator(
            __DIR__ . '/fixtures/no-media-type');
        
        $this->exptectedRoute = new Route(
            'PaymentsController', 'getPayments');
    }

    /**
     * @Then /^route is Route instance$/
     */
    public function routeIsRouteInstance()
    {
        Assert::assertTrue($this->route instanceof Route);
    }

    /**
     * @Given /^matches expected route$/
     */
    public function matchesExpectedRoute()
    {
        Assert::assertTrue($this->route->equals($this->exptectedRoute));
    }

    /**
     * @Given /^a directory having media type with route annotation$/
     */
    public function aDirectoryHavingMediaTypeWithRouteAnnotation()
    {
        $this->directory = new DirectoryIterator(
            __DIR__ . '/fixtures/with-media-type');
        $this->exptectedRoute = new Route(
            'PaymentsController', 'getPayments');
    }

    /**
     * @Given /^a directory having no matching media type route annotation$/
     */
    public function aDirectoryHavingNoMatchingMediaTypeRouteAnnotation()
    {
        $this->directory = new DirectoryIterator(
            __DIR__ . '/fixtures/no-matching-media-type');
    }
    
}