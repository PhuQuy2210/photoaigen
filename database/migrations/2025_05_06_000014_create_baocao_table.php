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
        Schema::create('baocao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('hinhanh_id')->constrained('hinhanh')->onDelete('cascade')->onUpdate('cascade');
            $table->string('email', 50);
            $table->integer('sdt');
            $table->string('quocgia', 50);
            $table->string('url', 200);
            $table->boolean('kiemduyet')->default(0);
            $table->text('description');
            $table->timestamps(0);  // Tự động thêm created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baocao');
    }
};
