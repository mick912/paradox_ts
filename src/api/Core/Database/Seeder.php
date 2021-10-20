<?php
namespace Core\Database;

use Illuminate\Container\Container;
use \Illuminate\Database\Seeder as BaseSeeder;

abstract class Seeder extends BaseSeeder
{
    public function __construct(Container $container)
    {
        $this->setContainer($container);
    }
}