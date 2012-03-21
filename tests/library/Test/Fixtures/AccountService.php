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
 * Description of AccountService
 *
 * @author hashinpanakkaparambil
 */
class AccountService
{
    /**
     * @Injections\InjectType(
     * "Test\Fixtures\AccountRepositoryInterface", mandatory=false)
     */
    private $accountRepository;
    
    /**
     * @Injections\Inject(mandatory=false)
     */
    private $userRepository;
}