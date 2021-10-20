<?php
namespace App\Migrations;

use Core\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

Class CreateUsersTable extends Migration
{
    protected array $dependencies = [
      CreateRolesTable_1::class,
      CreateDepartmentsTable_1::class
    ];

    public function up()
    {
        if (!$this->schema()->hasTable('users')) {
            $this->schema()->create('users', function (Blueprint $table) {
                $table->id();
                $table->string('first_name', 30);
                $table->string('last_name', 30);
                $table->string('email', 60)->unique();
                $table->integer('age');
                $table->integer('department_id')->unsigned();
                $table->foreign('department_id')
                    ->references('id')
                    ->on('departments')
                    ->onDelete('cascade');

                $table->integer('role_id')->unsigned();
                $table->foreign('role_id')
                    ->references('id')
                    ->on('roles')
                    ->onDelete('cascade');
                $table->timestamps();
            });
        }

    }

    public function down()
    {
        $this->dropForeignKeys();
        $this->schema()->drop('users');
    }

    protected function dropForeignKeys()
    {
        $this->schema()->table('users', function (Blueprint $table) {
            $table->dropForeign('users_department_id_foreign');
            $table->dropForeign('users_role_id_foreign');
        });
    }

}