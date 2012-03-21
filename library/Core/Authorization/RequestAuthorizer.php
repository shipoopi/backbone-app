<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Authorization;

use Core\Transformation\Request;


/**
 *
 * @author hashinpanakkaparambil
 */
interface RequestAuthorizer
{
    public function addSecuredOperation(SecuredOperation $operation);
    public function addRule(Rule $rule);
    public function getRules();
    public function authorizeRequest(Request $request, $operation);
}