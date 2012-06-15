<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Util;

/**
 * Description of Archiver
 *
 * @author hashinpanakkaparambil
 */
class Archiver
{
    private $options;
    
    public function __construct(array $options = array())
    {
        $this->options = $options;
    }

    public function archive($dirToArchive, $archiveFile)
    {
        $dirToArchive = (string) $dir;
        $archiveFile = (string) $archiveFile;
        
    }
}