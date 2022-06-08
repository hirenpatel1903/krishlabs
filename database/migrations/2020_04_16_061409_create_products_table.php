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
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->decimal('cost', 13, 2);
            $table->decimal('price', 13, 2);
            $table->string('barcode_type')->nullable();
            $table->longText('barcode')->nullable();
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('tax_id')->nullable();
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('type');
            $table->unsignedTinyInteger('status');
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
        Schema::dropIfExists('products');
    }
}
