<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('link_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')
                ->constrained('links')
                ->onDelete('cascade');
            $table->timestampTz('visited_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_visits');
    }
};
