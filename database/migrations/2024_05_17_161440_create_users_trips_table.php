<?php

use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_trip_shared', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Trip::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_trip_shared');
    }
};
