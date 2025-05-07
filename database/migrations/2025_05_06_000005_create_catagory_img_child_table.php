<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catagory_img_child', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('Tên danh mục con');
            $table->integer('parent_id')->comment('ID của danh mục cha');
            $table->integer('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catagory_img_child');
    }
};
