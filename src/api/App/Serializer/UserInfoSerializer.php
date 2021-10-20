<?php
namespace App\Serializer;


use Core\Serializer\AbstractRetrieveSerializer;

class UserInfoSerializer extends AbstractRetrieveSerializer
{
    protected function getFields(): array
    {
        return  [
            'id' => '',
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'role' => [$this, 'getRole'],
            'department' => [$this, 'getDepartment'],
            'address' => [$this, 'getAddress']
        ];
    }

    public function getRole($user): string
    {
        return $user->role->name;
    }

    public function getDepartment($user): string
    {
        return $user->department->name;
    }
}