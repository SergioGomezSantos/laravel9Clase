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
        // Schema::table('products', function (Blueprint $table) {
        //     $table->unsignedBigInteger('order_id');
        //     $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

        //     //$table->foreign('order_id')->constrained();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('products', function (Blueprint $table) {
        //     //$table->dropForeign('products_order_id_foreign'); tabla, fk, _foreign
        //     $table->dropForeign(['order_id']);
        //     $table->dropColumn('order_id');
        // });
    }
};
