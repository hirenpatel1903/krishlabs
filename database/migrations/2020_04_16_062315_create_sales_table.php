<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shop_id');
            $table->decimal('sub_total', 8, 2)->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('total', 8, 2)->nullable();
            $table->decimal('tax_amount', 8, 2)->nullable();
            $table->decimal('paid_amount', 8, 2)->nullable();
            $table->decimal('paid_credit_amount', 8, 2)->nullable();
            $table->decimal('paid_cash_amount', 8, 2)->nullable();
            $table->longText('reference')->nullable();
            $table->longText('sale_no')->nullable();
            $table->unsignedInteger('tax_id')->nullable();
            $table->string('description',1000)->nullable();
            $table->unsignedTinyInteger('status')->nullable();
            $table->unsignedTinyInteger('payment_status')->nullable();
            $table->unsignedTinyInteger('payment_type')->nullable();
            $table->auditColumn();
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
        Schema::dropIfExists('sales');
    }
}
