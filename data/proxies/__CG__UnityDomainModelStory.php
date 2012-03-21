<?php

namespace Unity\Domain\Proxy\__CG__\Unity\Domain\Model;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Story extends \Unity\Domain\Model\Story implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    /** @private */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int) $this->_identifier["id"];
        }
        $this->__load();
        return parent::getId();
    }

    public function getTitle()
    {
        $this->__load();
        return parent::getTitle();
    }

    public function getDescription()
    {
        $this->__load();
        return parent::getDescription();
    }

    public function setTitle($title)
    {
        $this->__load();
        return parent::setTitle($title);
    }

    public function setDescription($description)
    {
        $this->__load();
        return parent::setDescription($description);
    }

    public function setProduct($product)
    {
        $this->__load();
        return parent::setProduct($product);
    }

    public function getProduct()
    {
        $this->__load();
        return parent::getProduct();
    }

    public function getStatus()
    {
        $this->__load();
        return parent::getStatus();
    }

    public function setStatus(\Unity\Domain\Model\StoryStatus $status)
    {
        $this->__load();
        return parent::setStatus($status);
    }

    public function getPriority()
    {
        $this->__load();
        return parent::getPriority();
    }

    public function setPriority($priority)
    {
        $this->__load();
        return parent::setPriority($priority);
    }

    public function setRelease(\Unity\Domain\Model\Release $release = NULL)
    {
        $this->__load();
        return parent::setRelease($release);
    }

    public function release()
    {
        $this->__load();
        return parent::release();
    }

    public function getEstimate()
    {
        $this->__load();
        return parent::getEstimate();
    }

    public function setEstimate($estimate)
    {
        $this->__load();
        return parent::setEstimate($estimate);
    }

    public function removeEstimate()
    {
        $this->__load();
        return parent::removeEstimate();
    }

    public function setSprint(\Unity\Domain\Model\Sprint $sprint = NULL)
    {
        $this->__load();
        return parent::setSprint($sprint);
    }

    public function sprint()
    {
        $this->__load();
        return parent::sprint();
    }

    public function tasks()
    {
        $this->__load();
        return parent::tasks();
    }

    public function addTask(\Unity\Domain\Model\Task $task)
    {
        $this->__load();
        return parent::addTask($task);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'title', 'description', 'estimate', 'priority', 'status', 'product', 'release', 'sprint', 'tasks');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields AS $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}