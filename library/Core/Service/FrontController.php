<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service;

/**
 * Description of FrontController
 *
 * @author hashinpanakkaparambil
 */
class FrontController
{

    private $serviceControllers = array();
    private $config;
    private $includePaths = array();

    public function __construct(FrontControllerConfig $config)
    {
        $this->config = $config;
        $this->includePaths[] = get_include_path();
        $this->addIncludePaths(
            $this->config->getServiceControllerDirectories());
    }

    private function addIncludePaths(array $paths)
    {
        $this->includePaths += $paths;
        return $this;
    }

    private function registerIncludePaths()
    {
        set_include_path(implode(PATH_SEPARATOR, $this->includePaths));
        return $this;
    }

    public function run()
    {
        $this->registerIncludePaths();
          
    }

}