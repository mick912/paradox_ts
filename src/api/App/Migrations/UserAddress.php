<?php
namespace App\Migrations;

use Core\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

Class UserAddress extends Migration
{
    protected array $dependencies = [
        CreateUsersTable::class
    ];

    public function up()
    {
        if (!$this->schema()->hasTable('user_addresses')) {
            $this->schema()->create('user_addresses', function (Blueprint $table) {

                $table->id();
                $table->string('area', 20);
                $table->string('address', 150);

                $table->integer('country_id')->unsigned();
                $table->integer('city_id')->unsigned();
                $table->integer('user_id')->unsigned();

                $table->foreign('country_id')
                    ->references('id')
                    ->on('countries')
                    ->onDelete('cascade');

                $table->foreign('city_id')
                    ->references('id')
                    ->on('cities')
                    ->onDelete('cascade');

                $table->timestamps();
            });
        }
    }

    public function down()
    {
        $this->schema()->drop('user_addresses');
    }

}