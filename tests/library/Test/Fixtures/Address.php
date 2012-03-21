<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\Fixtures;

/**
 * Description of User
 *
 * @author hashinpanakkaparambil
 */
class Address
{

    private $address1;
    private $address2;

    public function __construct($address1 = '', $address2 = '')
    {
        $this->address1 = $address1;
        $this->address2 = $address2;
    }

    public function getAddress1()
    {
        return $this->address1;
    }

    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    public function getAddress2()
    {
        return $this->address2;
    }

    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

}