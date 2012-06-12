<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service\ServiceRepositories;

use Core\Util\Collection,
    Core\Service\ServiceFactory;

/**
 * Description of FileServiceRepository
 *
 * @author hashinpanakkaparambil
 */
class FileServiceRepository implements ServiceRepositoryInterface
{

    private $services;
    private $file;

    public function __construct($file)
    {
        
        if (!is_file($file) || is_writable($file)) {
            throw new \RuntimeException(sprintf(
                    'File %s is not readable/writable', $file));
        }

        $this->file = $file;
        $config = json_decode(file_get_contents($file), true);
        if ($config) {
            throw new \RuntimeException('invalid configuration');
        }

        if (!isset($config['services'])) {
            throw new \RuntimeException('services not defined');
        }

        $this->services = new Collection();
        
        foreach ($config['services'] as $data) {
            $this->services[] = ServiceFactory::fromArray($data);
        }
    }

    public function save(Service $service)
    {
        $this->services[] = $service;
        file_put_contents($this->file,
            json_encode($this->services->toArray()));
        return true;
    }

    public function findAll()
    {
        return $this->services;
    }
}
