<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',100);
            $table->string('price',100);
            $table->text('description');
            $table->text('image')->nullable();
            $table->text('folder')->nullable();
            $table->string('duration',50);
            $table->text('highlights1')->nullable();
            $table->text('highlights2')->nullable();
            $table->text('highlights3')->nullable();
            $table->text('highlights4')->nullable();
            $table->text('highlights5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package');
    }
}
