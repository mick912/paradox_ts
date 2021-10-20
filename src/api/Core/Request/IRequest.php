<?php

namespace Core\Request;

/**
 * Interface IRequest
 * @package Core\Request
 */
interface IRequest extends \ArrayAccess
{
    public function get(string $name, $def = null);
    public function post(string $name, $type = null);
    public function getUri():string ;
    public function getMethod():string ;
    public function isPost():bool;
}