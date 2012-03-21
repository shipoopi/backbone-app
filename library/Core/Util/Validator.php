<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Util;

/**
 * Description of Validator
 *
 * @author hashinpanakkaparambil
 */
class Validator
{

    protected static function throwError($msg, $exception = null)
    {
        $exception = $exception ?
            new $exception($msg) : new \UnexpectedValueException($msg);

        throw $exception;
    }

    public static function nonEmptyString($var, $msg = null, $exception = null)
    {
        $msg = $msg ? : 'Non empty string expected';
        if (!is_string($var) || strlen(trim($var)) == 0) {
            self::throwError($msg, $exception);
        }

        return true;
    }

    public static function validObject($var, $msg = null, $exception = null)
    {
        $msg = $msg ? : 'Object expected';
        if (!is_object($var)) {
            self::throwError($msg, $exception);
        }

        return true;
    }

    public static function classExists($class, $msg = null, $exception = null)
    {
        $msg = $msg ? : 'Class %s does not exist';

        if (!class_exists($class, true)) {
            self::throwError(sprintf($msg, $class), $exception);
        }

        return true;
    }

    public static function nonZeroInt($var, $msg = null, $exception = null)
    {
        $msg = $msg ? : 'Non zero int expected';
        if (!is_int($var) || $var === 0) {
            self::throwError($msg, $exception);
        }
        return true;
    }

    public static function notNull($var, $msg = null, $exception = null)
    {
        $msg = $msg ? : 'Can not be null';
        if (!isset($var)) {
            self::throwError($msg, $exception);
        }
        return true;
    }

    public static function validDate($var, $format = 'd/m/Y', $msg = null, $exception = null)
    {
        $msg = $msg ? : 'Not a valid date %s';
        $date = \DateTime::createFromFormat($format, $var);
        if (!$date instanceof \DateTime) {
            self::throwError(sprintf($msg, $var), $exception);
        }
        return true;
    }

    
    public static function arrayValueIsSet($array, $index, $msg = null, $exception = null)
    {
        $msg = $msg ? : 'Value must be set';
        if (!isset($array[$index])) {
            self::throwError($msg, $exception);
        }

        return true;
    }
}
