<?php
namespace App\Controller;


use Core\Request\IRequest;
use Core\Response\IResponse;
use Illuminate\Database\Eloquent\Builder;

abstract class ApiController
{
    protected IResponse $response;
    protected IRequest $request;
    protected array $filterBackends = [
    ];
    public array $orderFields = [];

    public function __construct(IResponse $response, IRequest $request)
    {
        $this->response = $response;
        $this->request = $request;
    }

    protected abstract function getQuerySet(): Builder;

    protected function filterQuerySet(Builder $querySet): Builder
    {
        foreach ($this->filterBackends as $backend) {
            $querySet = (new $backend())->filter($querySet, $this->request, $this);
        }
        return $querySet;
    }
}