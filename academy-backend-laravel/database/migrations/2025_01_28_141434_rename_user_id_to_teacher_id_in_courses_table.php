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
        Schema::table('courses', function (Blueprint $table) {
            $table->renameColumn('user_id', 'teacher_id');
            $table->unsignedBigInteger('teacher_id')->change();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->renameColumn('teacher_id', 'user_id');
        });
    }
};
