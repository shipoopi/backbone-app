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
 * Description of PipelineRunnable
 *
 * @author hashinpanakkaparambil
 */
interface PipeInterface
{
    public function flow(KeyValueStoreInterface $bus);
}