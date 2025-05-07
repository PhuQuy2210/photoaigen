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
        Schema::create('tintuc', function (Blueprint $table) {
            $table->id(); // int auto increment
            $table->string('title', 200)->comment('Tiêu đề tin tức');
            $table->longText('content')->comment('Nội dung tin tức');
            $table->text('description')->comment('Mô tả');
            $table->unsignedBigInteger('author_id')->nullable()->comment('Tác Giả');
            $table->integer('view')->nullable();
            $table->integer('view_fake')->nullable();
            $table->integer('active')->default(1)->comment('trạng thái');
            $table->unsignedBigInteger('category_id')->nullable()->comment('Danh Mục Tin');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Ngày Xuất Bản');
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Ngày cập nhật');

            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('danhmuctin')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tintuc');
    }
};
