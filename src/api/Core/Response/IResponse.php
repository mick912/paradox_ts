<?php
namespace Core\Response;

interface IResponse
{
    public function getStatus():int;
    public function setStatus(int $status):IResponse;

    public function setData(array $data):IResponse;
    public function getData();

    public function render():string;
}