<?php


namespace Core\Serializer;


use Core\Request\IRequest;

abstract class AbstractRetrieveSerializer implements IRetrieveSerializer
{
    protected \ArrayAccess $item;
    protected IRequest $request;

    protected array $fields = [];

    public function __construct(\ArrayAccess $item, IRequest $request)
    {
        $this->item = $item;
        $this->request = $request;
    }

    protected function getFields(): array
    {
        return $this->fields;
    }

    public function getData(): array
    {
        $data = [];
        $fields = $this->getFields();
        foreach ($fields as $fieldName => $field) {
           $data[$fieldName] = (is_callable($field)) ? call_user_func($field, $this->item) : $this->item[$fieldName];
        }
        return $data;
    }
}