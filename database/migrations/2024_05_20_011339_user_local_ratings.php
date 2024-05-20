<?php

use App\Models\Local;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_local_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Local::class);
            $table->integer('rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_local_ratings');
    }
};
