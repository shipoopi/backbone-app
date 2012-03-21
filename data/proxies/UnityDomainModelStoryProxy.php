<?php

namespace Unity\Domain\Proxy;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class UnityDomainModelStoryProxy extends \Unity\Domain\Model\Story implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    private function _load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function getId()
    {
        $this->_load();
        return parent::getId();
    }

    public function getTitle()
    {
        $this->_load();
        return parent::getTitle();
    }

    public function getDescription()
    {
        $this->_load();
        return parent::getDescription();
    }

    public function setTitle($title)
    {
        $this->_load();
        return parent::setTitle($title);
    }

    public function setDescription($description)
    {
        $this->_load();
        return parent::setDescription($description);
    }

    public function setProduct($product)
    {
        $this->_load();
        return parent::setProduct($product);
    }

    public function getProduct()
    {
        $this->_load();
        return parent::getProduct();
    }

    public function getStatus()
    {
        $this->_load();
        return parent::getStatus();
    }

    public function setStatus(\Unity\Domain\Model\StoryStatus $status)
    {
        $this->_load();
        return parent::setStatus($status);
    }

    public function getPriority()
    {
        $this->_load();
        return parent::getPriority();
    }

    public function setPriority($priority)
    {
        $this->_load();
        return parent::setPriority($priority);
    }

    public function setRelease(\Unity\Domain\Model\Release $release = NULL)
    {
        $this->_load();
        return parent::setRelease($release);
    }

    public function release()
    {
        $this->_load();
        return parent::release();
    }

    public function getEstimate()
    {
        $this->_load();
        return parent::getEstimate();
    }

    public function setEstimate($estimate)
    {
        $this->_load();
        return parent::setEstimate($estimate);
    }

    public function removeEstimate()
    {
        $this->_load();
        return parent::removeEstimate();
    }

    public function setSprint(\Unity\Domain\Model\Sprint $sprint = NULL)
    {
        $this->_load();
        return parent::setSprint($sprint);
    }

    public function sprint()
    {
        $this->_load();
        return parent::sprint();
    }

    public function tasks()
    {
        $this->_load();
        return parent::tasks();
    }

    public function addTask(\Unity\Domain\Model\Task $task)
    {
        $this->_load();
        return parent::addTask($task);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'title', 'description', 'estimate', 'priority', 'product', 'release', 'sprint', 'tasks', 'status');
    }
}