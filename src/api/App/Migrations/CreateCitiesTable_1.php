<?php
namespace App\Migrations;

use Core\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

Class CreateCitiesTable_1 extends Migration
{
    protected array $dependencies = [
      CreateCountriesTable_1::class
    ];

    public function up()
    {
        if (!$this->schema()->hasTable('cities')) {
            $this->schema()->create('cities', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->integer('country_id')->unsigned();
                $table->foreign('country_id')
                    ->references('id')
                    ->on('countries')
                    ->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        $this->dropForeignKeys();
        $this->schema()->drop('cities');
    }

    protected function dropForeignKeys()
    {
        $this->schema()->table('cities', function (Blueprint $table) {
            $table->dropForeign('cities_country_id_foreign');
        });
    }


}