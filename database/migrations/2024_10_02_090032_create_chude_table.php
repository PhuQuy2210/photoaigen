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
        Schema::create('chude', function (Blueprint $table) {
            $table->bigIncrements('id'); //tự tăng
            $table->string('ten');
            $table->integer('thutu');
            $table->timestamps();//thêm 2 cột thời gian tạo và thời gian update
        });
    }

    /**
     * Reverse the migrations.
     */
    //dùng để xóa bản
    public function down(): void
    {
        Schema::dropIfExists('chude');
    }
};
