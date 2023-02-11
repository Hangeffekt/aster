<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->integer("shop_id")->autoIncrement();
            $table->string('shop_name')->nullable();
            $table->integer('postal_code')->nullable();
            $table->text('town')->nullable();
            $table->text('address')->nullable();
            $table->integer('telephone')->nullable();
            $table->text('email')->default("0");
            $table->integer('status')->default("0");
            $table->text('takeover')->nullable();
            $table->integer('cost')->nullable();
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
        Schema::dropIfExists('shops');
    }
}
