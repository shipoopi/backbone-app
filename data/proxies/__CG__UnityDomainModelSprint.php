<?php

namespace Unity\Domain\Proxy\__CG__\Unity\Domain\Model;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Sprint extends \Unity\Domain\Model\Sprint implements \Doctrine\ORM\Proxy\Proxy
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
            return $this->_identifier["id"];
        }
        $this->__load();
        return parent::getId();
    }

    public function setStories(\Doctrine\Common\Collections\Collection $stories)
    {
        $this->__load();
        return parent::setStories($stories);
    }

    public function backlog()
    {
        $this->__load();
        return parent::backlog();
    }

    public function setGoal($goal)
    {
        $this->__load();
        return parent::setGoal($goal);
    }

    public function getGoal()
    {
        $this->__load();
        return parent::getGoal();
    }

    public function setStartDate(\DateTime $date)
    {
        $this->__load();
        return parent::setStartDate($date);
    }

    public function getStartDate()
    {
        $this->__load();
        return parent::getStartDate();
    }

    public function setEndDate(\DateTime $date)
    {
        $this->__load();
        return parent::setEndDate($date);
    }

    public function getEndDate()
    {
        $this->__load();
        return parent::getEndDate();
    }

    public function getStartsOn()
    {
        $this->__load();
        return parent::getStartsOn();
    }

    public function getEndsOn()
    {
        $this->__load();
        return parent::getEndsOn();
    }

    public function getVelocity()
    {
        $this->__load();
        return parent::getVelocity();
    }

    public function addStory(\Unity\Domain\Model\Story $story)
    {
        $this->__load();
        return parent::addStory($story);
    }

    public function removeStory(\Unity\Domain\Model\Story $story)
    {
        $this->__load();
        return parent::removeStory($story);
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


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'goal', 'startDate', 'endDate', 'stories', 'release');
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