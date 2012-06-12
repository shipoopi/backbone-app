<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Service\ServiceRepositories;

/**
 *
 * @author hashinpanakkaparambil
 */
interface ServiceRepositoryInterface
{
    public function save(Service $service);
    public function findAll();
}