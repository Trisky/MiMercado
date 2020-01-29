<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('products', function (Blueprint $table) {
            //$table->string('id')->index();
            $table->increments('id')->index();
            $table->string('username');
            $table->string('product_id');
            $table->boolean('visible')->default(true);
            $table->string('created_at');
            $table->string('updated_at');

            $table->unique(['username', 'product_id']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
