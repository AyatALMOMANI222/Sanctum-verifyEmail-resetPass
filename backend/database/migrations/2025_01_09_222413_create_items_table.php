<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');  // تغيير إلى bigIncrements لإنشاء المفتاح الأساسي تلقائيًا
            $table->string('name'); 
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2); 
            $table->decimal('discount_price', 8, 2)->nullable(); 
           
            $table->unsignedBigInteger('branch_category_id');
            $table->string('currency', 3)->default('USD'); 
            $table->string('size')->nullable(); 
            $table->string('flavor')->nullable(); 
            
            $table->foreign('branch_category_id')
                  ->references('id')
                  ->on('branch_category')
                  ->onDelete('cascade'); 

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
