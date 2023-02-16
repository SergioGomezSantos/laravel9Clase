<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company_reason');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('nif');
            $table->integer('room_number')->nullable();
            $table->boolean('physiotherapy')->nullable();
            $table->integer('max_capacity')->nullable();
            $table->boolean('unisex')->nullable();
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
        Schema::dropIfExists('centers');
    }
};
