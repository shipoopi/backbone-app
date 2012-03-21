<?php

namespace Core\Vendor\Doctrine\Logging;

use Doctrine\DBAL\Logging\SQLLogger as DoctrineSqlLogger;

/**
 * Description of DoctrineFirebugLogger
 *
 * @author hashpanak
 */
class DoctrineFirebugLogger implements DoctrineSqlLogger
{

    /**
     * Sum of query times
     *
     * @var float
     */
    protected $_totalMS = 0;
    /**
     * Total number of queries logged
     *
     * @var integer
     */
    protected $_queryCount = 0;
    /**
     * Table of queries and their times
     *
     * @var \Zend_Wildfire_Plugin_FirePhp_TableMessage
     */
    protected $_message;
    /**
     * @var stdClass
     */
    protected $_curQuery = null;

    public function __construct()
    {
        $this->_message = new \Zend_Wildfire_Plugin_FirePhp_TableMessage('Doctrine Queries');
        $this->_message->setBuffered(true);
        $this->_message->setHeader(array('Time', 'Event', 'Parameters'));
        $this->_message->setOption('includeLineNumbers', false);
        \Zend_Wildfire_Plugin_FirePhp::getInstance()->send($this->_message, 'Doctrine Queries');
    }

    /**
     * @param string $sql The SQL statement that was executed
     * @param array $params Arguments for SQL
     * @param float $executionMS Time for query to return
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $this->_curQuery = new \stdClass();
        $this->_curQuery->sql = $sql;
        $this->_curQuery->params = $params;
        $this->_curQuery->types = $types;
        $this->_curQuery->startTime = \microtime(true);
    }

    public function stopQuery()
    {
        $executionMS = \microtime(true) - $this->_curQuery->startTime;
        $this->_totalMS += $executionMS;
        ++$this->_queryCount;
        $this->_message->addRow(array(
            number_format($executionMS, 5),
            $this->_curQuery->sql,
            $this->_curQuery->params
        ));
        $this->updateLabel();
    }

    /**
     * Sets the label for the FireBug entry
     */
    public function updateLabel()
    {
        $this->_message->setLabel(
            sprintf('Doctrine Queries (%d @ %f sec)',
                $this->_queryCount,
                number_format($this->_totalMS, 5))
        );
    }

}