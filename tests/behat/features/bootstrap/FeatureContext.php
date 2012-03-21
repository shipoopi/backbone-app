<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Core\Util\Validator;

defined('TEST_LIB')
    || define('TEST_LIB',
              realpath(realpath(dirname(__FILE__) . '/../../../library')));

defined('LIB')
    || define('LIB',
              realpath(realpath(dirname(__FILE__) . '/../../../../library')));


// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV',
              (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR,
                         array(
        TEST_LIB, LIB,
        get_include_path()
    )));



require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->registerNamespace('Core');
Zend_Loader_Autoloader::getInstance()->registerNamespace('Doctrine');
Zend_Loader_Autoloader::getInstance()->registerNamespace('Test');
Zend_Loader_Autoloader::getInstance()->registerNamespace('PHPUnit');


//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param   array   $parameters     context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $filesToSkip = array('AbstractContext.php');

        $path = dirname(__FILE__) . '/../contexts/';
        $it = new RecursiveDirectoryIterator($path);
        /** @var $file  SplFileInfo */
        foreach ($it as $file) {
            if (!$file->isDir()) {
                $name = $file->getFilename();
                if (!in_array($name, $filesToSkip)) {
                    $class = pathinfo($name, PATHINFO_FILENAME);
                    require_once dirname(__FILE__) . '/../contexts/' . $name;
                    $this->useContext($class, new $class($parameters));
                }
            }
        }
    }

    
    public function newInstance($class)
    {
        $prototype = unserialize(sprintf('O:%d:"%s":0:{}', strlen($class),
                                                                  $class));

        return clone $prototype;
    }

    public function jsonDecode($json)
    {
        $json = (string) $json;
        $mappingArray = json_decode($json, true);
        if (!$mappingArray) {
            throw new Exception("Invalid mapping provided");
        }

        return $mappingArray;
    }

    public function objectHasProperties($object, array $properties)
    {
        $reflectionObject = new ReflectionObject($object);

        foreach ($properties as $prop => $expected) {
            $prop = $reflectionObject->getProperty($prop);
            if (!$prop) {
                throw new Exception(sprintf(
                        'Property %s not found', $prop));
            }

            $prop->setAccessible(true);
            $actual = $prop->getValue($object);
            if ($actual != $expected) {
                throw new Exception(spritf(
                        'Expected %s , got %s', $expected, $actual));
            }
        }
    }

}
