<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer("id")->autoIncrement();
            $table->string('catalog_id')->default('0');
            $table->string('brand')->nullable();
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->text('ean')->nullable();
            $table->text('article_number')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->text('price')->nullable();
            $table->text('qty')->nullable();
            $table->json('images')->nullable();
            $table->json('websiteimages')->nullable();
            $table->text('status')->nullable();
            $table->integer('order')->nullable();
            $table->integer('shippings')->default("0");
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
