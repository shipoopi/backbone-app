<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\Fixtures;

use Core\DependencyInjection\Injections;

/**
 * Description of AccountRepository
 *
 * @author hashinpanakkaparambil
 */
class AccountRepository implements AccountRepositoryInterface
{
    
    /**
     * @Injections\InjectType(
     * "Test\Fixtures\AccountRepositoryInterface", mandatory=false)
     */
    private $accountService;

    public function findOne()
    {
        
    }

}