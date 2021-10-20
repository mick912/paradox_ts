<?php
namespace App\Controller;


use Core\Serializer\IRetrieveSerializer;
use Illuminate\Database\Eloquent\Model;

trait RetrieveApiTrait
{

    protected function getRetrieveSerializer(Model $model): IRetrieveSerializer
    {
        return new $this->retrieveSerializerClass($model, $this->request);
    }

    protected function getObject($id): Model
    {
        return $this->getQuerySet()->findOrFail($id);
    }
}