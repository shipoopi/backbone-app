<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Persistence;

/**
 *
 * @author hashinpanakkaparambil
 */
interface RepositoryAdapter
{
    public function save($entity, $flush = true);
    public function delete($entity, $flush = true);
}