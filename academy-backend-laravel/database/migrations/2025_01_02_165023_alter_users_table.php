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
        Schema::table('users', function (Blueprint $table) {
            $table->string('family')->after('name');
            $table->string('username')->unique()->after('id');
            $table->string('mobile')->unique()->after('email')->nullable()->default(null);
            $table->boolean('status')->default(0)->after('password'); // 0: inactive, 1: active
            $table->enum('role', ['admin', 'ordinary', 'teacher'])->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropColumn('family');
        $table->dropColumn('username');
        $table->dropColumn('mobile');
        $table->dropColumn('status');
        $table->dropColumn('role');
    }
};
