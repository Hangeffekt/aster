<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->integer("id")->autoIncrement();
            $table->integer('parent_id')->nullable();
            $table->integer('sub_menu')->nullable();
            $table->string('name');
            $table->text('url')->nullable();
            $table->json('filters')->nullable();
            $table->text('status')->default("0");
            $table->text('order')->default("0");
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
        Schema::dropIfExists('catalogs');
    }
}
