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
    Schema::create('links', function (Blueprint $table) {

      $table->id();

      // Nullable FK to users.id, ON DELETE SET NULL
      $table->foreignId('user_id')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();
      $table->string('short_code', 20)->unique();
      $table->text('original_url');
      $table->boolean('is_custom')->default(false);

      //Timestamps WITH TIME ZONE, default CURRENT_TIMESTAMP
      $table->timestampTz('created_at')->useCurrent();
      $table->timestampTz('updated_at')->useCurrent()->useCurrentOnUpdate();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('links');
  }
};
