<?php
namespace App\Migrations;

use Core\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

Class CreateCountriesTable_1 extends Migration
{

    public function up()
    {
        if (!$this->schema()->hasTable('countries')) {
            $this->schema()->create('countries', function ($table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->string('iso', 3);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        $this->schema()->drop('countries');
    }

}