<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->unsignedInteger('product_price');
            $table->unsignedInteger('rating');
            $table->unsignedInteger('sale');
            $table->string('product_img');

        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
