<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_category', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true); 

            $table->unsignedBigInteger('branch_id');  
            $table->unsignedBigInteger('category_id');
    
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');  // ربط الفرع
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');  // ربط الفئة
    
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
        Schema::dropIfExists('branch_category'); // حذف الجدول إذا تم التراجع عن الترحيل
    }
}
