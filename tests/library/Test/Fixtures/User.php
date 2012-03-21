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
class User
{
    private $id;
    private $title;
    private $name;
    private $joiningDate;
    private $address;

    public function __construct($name = null)
    {
        $this->name = $name;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

        public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setJoiningDate(\DateTime $date)
    {
        $this->joiningDate = $date;
    }

    public function getJoiningDate()
    {
        return $this->joiningDate;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setAddress(Address $address)
    {
        $this->address = $address;
    }
    
    public function getAddress()
    {
        return $this->address;
    }
}