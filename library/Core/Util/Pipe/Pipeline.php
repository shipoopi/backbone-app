<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Util\Pipe;

use Core\Util\KeyValueStoreInterface;

/**
 * Description of ExecutionPipeline
 *
 * @author hashinpanakkaparambil
 */
class Pipeline
{
    private $pipes = array();
    private $bus;
    
    public function __construct(KeyValueStoreInterface $bus)
    {
        $this->bus = $bus;
    }
    
    public function addPipe(PipeInterface $pipe)
    {
        $this->pipes[] = $pipe;
    }

    public function flow()
    {
        foreach($this->pipes as $pipe) {
            $pipe->flow($this->bus);
        }
    }
}