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
        Schema::create('hinhanh', function (Blueprint $table) {
            $table->id();
            $table->string('url', 300)->comment('URL của hình ảnh');
            $table->string('thumb_path', 255)->nullable();
            $table->text('description')->nullable()->comment('Mô tả hình ảnh');
            $table->tinyInteger('active', 1)->default(1)->comment('kích hoạt');
            $table->integer('direction', 11)->default(1)->comment('0-ngang or 1-dọc');
            $table->integer('view')->nullable()->comment('Lượt xem');
            $table->integer('like_count')->default(1500)->comment('Số lượt thích của hình ảnh');
            $table->integer('category_id')->nullable()->comment('danh mục ảnh');
            $table->integer('category_child')->default(1)->comment('Danh mục con');
            $table->timestamps(0); // Tạo trường created_at, updated_at với timestamp mặc định

            $table->foreign('category_id')->references('id')->on('danhmucanh')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_child')->references('id')->on('catagory_img_child')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hinhanh');
    }
};
