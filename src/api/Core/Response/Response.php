<?php
namespace Core\Response;


class Response implements IResponse
{
    protected int $status;
    protected array $data;

    public function __construct(array $data = [], int $status=200)
    {
        $this->data = $data;
        $this->status = $status;
    }

    public function getStatus(): int
    {
       return $this->status;
    }

    public function setStatus(int $status): IResponse
    {
       $this->status = $status;
       return $this;
    }

    public function setData(array $data): IResponse
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
       return $this->data;
    }

    public function render(): string
    {
        return json_encode($this->data);
    }
}