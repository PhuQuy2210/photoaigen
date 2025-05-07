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
            $table->id(); // AUTO_INCREMENT
            $table->string('url', 300)->comment('URL của hình ảnh');
            $table->string('thumb_path', 255)->nullable();
            $table->text('description')->nullable()->comment('Mô tả hình ảnh');
            $table->integer('active')->default(1)->comment('Kích hoạt');
            $table->integer('direction')->default(1)->comment('0-ngang or 1-dọc');
            $table->integer('view')->nullable()->comment('Lượt xem');
            $table->integer('like_count')->default(1500)->comment('Số lượt thích của hình ảnh');
            $table->unsignedBigInteger('category_id')->nullable()->comment('Danh mục ảnh');
            $table->unsignedBigInteger('category_child')->default(1)->comment('Danh mục con');
            $table->timestamp('created_at')->useCurrent()->comment('Ngày đăng tải');
            $table->timestamp('updated_at')->useCurrent()->comment('Ngày cập nhật');

            // Indexes
            $table->index('category_id', 'hinhanh_ibfk_2');
            $table->index('category_child', 'hinhanh_ibfk_3');
        });

        // Foreign Key Constraints
        Schema::table('hinhanh', function (Blueprint $table) {
            $table->foreign('category_id', 'hinhanh_ibfk_2')
                ->references('id')
                ->on('danhmucanh')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('category_child', 'hinhanh_ibfk_3')
                ->references('id')
                ->on('catagory_img_child')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hinhanh', function (Blueprint $table) {
            $table->dropForeign('hinhanh_ibfk_2');
            $table->dropForeign('hinhanh_ibfk_3');
        });

        Schema::dropIfExists('hinhanh');
    }
};
