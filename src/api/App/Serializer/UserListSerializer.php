<?php


namespace App\Serializer;


use Core\Serializer\AbstractListSerializer;

class UserListSerializer extends AbstractListSerializer
{
    protected string $serializerClass = UserInfoSerializer::class;
}