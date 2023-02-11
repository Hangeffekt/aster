<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer("id")->autoIncrement();
            $table->integer('user_id')->nullable();
            $table->string('status')->nullable();
            $table->string('delivery_mode')->nullable();
            $table->string('delivery_first_name')->nullable();
            $table->string('delivery_last_name')->nullable();
            $table->string('delivery_zip_code')->nullable();
            $table->string('delivery_town')->nullable();
            $table->string('delivery_street')->nullable();
            $table->string('delivery_street_type')->nullable();
            $table->integer('delivery_number_floor')->nullable();
            $table->integer('delivery_cost')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('invoice_first_name')->nullable();
            $table->string('invoice_last_name')->nullable();
            $table->integer('invoice_zip_code')->nullable();
            $table->string('invoice_town')->nullable();
            $table->string('invoice_street')->nullable();
            $table->string('invoice_street_type')->nullable();
            $table->string('invoice_number_floor')->nullable();
            $table->string('invoice_tax_number')->nullable();
            $table->integer('payment_cost')->nullable();
            $table->string('comment')->nullable();
            $table->string('products')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
