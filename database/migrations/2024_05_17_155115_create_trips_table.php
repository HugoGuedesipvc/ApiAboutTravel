<?php

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('label');
            $table->foreignIdFor(Country::class)->nullable();
            $table->string('location')->nullable();
            $table->timestamp('initial_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('latitude')->nullable();
            $table->decimal('longitude')->nullable();
            $table->boolean('shared')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
