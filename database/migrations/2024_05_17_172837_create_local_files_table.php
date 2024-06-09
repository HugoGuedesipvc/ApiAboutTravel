<?php

use App\Models\Local;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('local_files', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Local::class);
            $table->string('label');
            $table->longText('path');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('local_files');
    }
};
