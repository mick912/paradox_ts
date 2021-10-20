<?php
namespace App\Serializer;


class UserFullInfoSerializer extends UserInfoSerializer
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

    public function getAddress($user): array
    {
        $address = $user->address;
        return [
            'country' => $address->country->name,
            'city' => $address->city->name,
            'area' => $address->area,
            'address' => $address->address
        ];
    }
}