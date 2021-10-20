<?php
namespace App\Controller;


use Core\Request\IRequest;
use Core\Response\IResponse;
use Core\Serializer\IListSerializer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait ListApiTrait
{

    protected function getListSerializer(Collection $querySet): IListSerializer
    {
        return new $this->listSerializerClass($querySet, $this->request);
    }


    protected function paginate(Builder $querySet): LengthAwarePaginator
    {
        return $querySet->paginate($this->pageSize, '*', 'page', $this->request[$this->pageParam]);
    }

    protected function getPaginatedData()
    {
        $qs = $this->filterQuerySet($this->getQuerySet());
        $pagination = $this->paginate($qs);
        $serializer = $this->getListSerializer($pagination->getCollection());
        return [
            'current_page' => $pagination->currentPage(),
            'first_page' => 1,
            'last_page' => $pagination->lastPage(),
            'total' => $pagination->total(),
            'page_size' => $this->pageSize,
            'results' => $serializer->getData()
        ];
    }
}