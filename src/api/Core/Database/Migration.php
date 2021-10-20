<?php


namespace Core\Database;


use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Migrations\Migration as BaseMigration;
use Illuminate\Database\Schema\Builder;

class Migration extends BaseMigration
{
    protected array $dependencies = [];

    protected function schema(): Builder
    {
        return Manager::schema();
    }

    public function getDependenciesCount():int
    {
       return count($this->dependencies);
    }

    public function getDependencies():iterable
    {
        foreach ($this->dependencies as $dependency) {
            $object = new $dependency();
            if ($object instanceof Migration) {
                yield $object;
            }
        }
    }
}