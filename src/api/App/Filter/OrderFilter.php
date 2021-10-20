<?php


namespace App\Filter;


use App\Controller\ApiController;
use Core\Request\IRequest;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends AbstractFilter
{
    protected string $orderingParam = 'order';

    protected function getRequestedOrderParam( IRequest $request, ApiController $controller): array
    {
        $order = $request[$this->orderingParam];
        $allowedOrderFields = $controller->orderFields;
        $data = [];

        if ($order && $allowedOrderFields) {
            $dir = str_starts_with($order, '-') ? 'desc' : 'asc';
            $cleanFieldName = str_replace('-', '', $order);
            if (in_array($cleanFieldName, array_keys($allowedOrderFields))) {
                $data = [
                  'direction' => $dir,
                  'column' => $allowedOrderFields[$cleanFieldName]
                ];
            }
        }
        return $data;
    }

    public function filter(Builder $querySet, IRequest $request, ApiController $controller): Builder
    {
        $orderData = $this->getRequestedOrderParam($request, $controller);
        if ($orderData) {
            $querySet = $querySet->orderBy($orderData['column'], $orderData['direction']);
        }
        return $querySet;
    }
}