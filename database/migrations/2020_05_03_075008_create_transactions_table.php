<?php

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(TransactionType::ADDFUND);
            $table->unsignedBigInteger('source_balance_id')->nullable();
            $table->unsignedBigInteger('destination_balance_id');
            $table->decimal('amount', 13, 2);
            $table->tinyInteger('status')->default(TransactionStatus::CREATED);
            $table->text('meta')->nullable();
            $table->uuid('invoice_id')->index();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
