<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('username')->after('email_verified_at');
            $table->integer('phone_number')->after('password')->nullable();
            $table->string('profile_picture')->after('phone_number')->nullable();
            $table->longText('description')->after('profile_picture')->nullable();
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('username');
            $table->dropColumn('phone_number');
            $table->dropColumn('profile_picture');
            $table->dropColumn('description');
            $table->dropSoftDeletes();
        });
    }
};
