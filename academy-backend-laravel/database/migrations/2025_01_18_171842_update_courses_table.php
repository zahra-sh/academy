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

//            $table->dropForeign(['user_id']);
//            $table->dropColumn('user_id');

//            $table->foreignId('teacher_id')->constrained('teachers')->nullable();

            $table->integer('sessions_number')->default(0);
            $table->integer('completed_sessions')->default(0);
            $table->text('days');
            $table->boolean('is_top')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
//            $table->dropForeign(['teacher_id']);
            $table->dropColumn(['teacher_id', 'sessions_number', 'completed_sessions', 'days', 'is_top']);

            $table->foreignId('user_id')->constrained('users')->nullable();
        });
    }
};
