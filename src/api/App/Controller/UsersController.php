<?php
namespace App\Controller;


use App\Filter\OrderFilter;
use App\Filter\UserKeywordSearchFilter;
use App\Models\User;
use App\Serializer\UserFullInfoSerializer;
use App\Serializer\UserListSerializer;
use Core\Response\IResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends ApiController
{
    use ListApiTrait;
    use RetrieveApiTrait;

    protected string $listSerializerClass = UserListSerializer::class;
    protected string $retrieveSerializerClass = UserFullInfoSerializer::class;

    protected int $pageSize = 15;
    protected string $pageParam = 'page';

    protected array $filterBackends = [
        UserKeywordSearchFilter::class,
        OrderFilter::class
    ];

    public array $orderFields = [
        'email' => 'email',
        'first_name' => 'first_name',
        'last_name' => 'last_name',
        'age' => 'age',
        'role' => 'roles.name',
        'department' => 'departments.name'
    ];

    protected function getQuerySet(): Builder
    {
       return User::select('users.*')
           ->join('roles', 'users.role_id', '=', 'roles.id')
           ->join('departments', 'users.department_id', '=', 'departments.id');
    }

    public function index(): IResponse
    {
        $data = $this->getPaginatedData();
        $this->response->setData($data);
        return $this->response;
    }

    public function retrieve($userId): IResponse
    {
        try {
            $user = $this->getObject($userId);
            $serializer = $this->getRetrieveSerializer($user);
            $this->response->setData($serializer->getData());
        } catch (ModelNotFoundException $e) {
            $this->response->setStatus(404);
            $this->response->setData([
                'error' => "User is not found!"
            ]);
        } finally {
            return $this->response;
        }
    }
}