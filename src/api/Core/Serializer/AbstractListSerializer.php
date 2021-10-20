<?php


namespace Core\Serializer;


use Core\Request\IRequest;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractListSerializer implements IListSerializer
{

    protected Collection $querySet;
    protected IRequest $request;
    protected string $serializerClass;

    public function __construct(
        Collection $querySet,
        IRequest $request
    )
    {
        $this->querySet = $querySet;
        $this->request = $request;
    }

    public function getData(): iterable
    {
        $data = [];
        foreach ($this->querySet as $item) {
            $serializer = new $this->serializerClass($item, $this->request);
            $data[] = $serializer->getData();
        }
        return $data;
    }
}