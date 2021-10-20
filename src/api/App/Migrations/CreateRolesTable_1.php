<?php
namespace App\Migrations;

use Core\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

Class CreateRolesTable_1 extends Migration
{

    public function up()
    {
        if (!$this->schema()->hasTable('roles')) {
            $this->schema()->create('roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        $this->schema()->drop('roles');
    }
}