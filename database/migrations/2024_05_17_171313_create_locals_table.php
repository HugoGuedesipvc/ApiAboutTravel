<?php

use App\Models\LocalType;
use App\Models\Trip;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('locals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Trip::class);
            $table->foreignIdFor(LocalType::class);
            $table->string('name');
            $table->decimal('latitude')->nullable();
            $table->decimal('longitude')->nullable();
            $table->longText('description')->nullable();
            $table->timestamp('date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locals');
    }
};
