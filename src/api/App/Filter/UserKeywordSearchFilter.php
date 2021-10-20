<?php


namespace App\Filter;


use App\Controller\ApiController;
use Core\Request\IRequest;
use Illuminate\Database\Eloquent\Builder;

class UserKeywordSearchFilter extends AbstractFilter
{
    protected string $queryParam = 'q';

    public function filter(Builder $querySet, IRequest $request, ApiController $controller): Builder
    {
        $terms = explode(" ", $request[$this->queryParam]);
        $searchableFields = ['first_name', 'last_name', 'email', 'age'];

        if ($terms) {
            foreach ($searchableFields as $field) {
                foreach ($terms as $term) {
                    $querySet = $querySet->orWhere($field, 'LIKE', "%{$term}%");
                }
            }
            $querySet = $querySet->orWhereHas('role', function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->where('name', 'LIKE', "%{$term}%");
                }
            });
            $querySet = $querySet->orWhereHas('department', function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->where('name', 'LIKE', "%{$term}%");
                }
            });
        }
        return $querySet;
    }
}