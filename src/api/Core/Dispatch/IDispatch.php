<?php
namespace Core\Dispatch;

interface IDispatch
{
    /**
     * dispatching Controller
     * @return mixed
     */
    public function dispatch();
}