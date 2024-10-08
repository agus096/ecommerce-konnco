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
            Schema::create('purchases', function (Blueprint $table) {
                $table->id();
                $table->string('order_id')->unique();
                $table->string('product_id');
                $table->string('product_name');
                $table->decimal('amount', 10, 2);
                $table->string('qty');
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('status')->default('pending'); // Status: pending, success, failed
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
        Schema::dropIfExists('purchases');
    }
};
