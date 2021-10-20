<?php


namespace App\Filter;


use App\Controller\ApiController;
use Core\Request\IRequest;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter
{
    public function filter(Builder $querySet, IRequest $request, ApiController $controller): Builder
    {
        return $querySet;
    }
}