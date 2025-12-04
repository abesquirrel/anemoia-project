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
        Schema::create('event_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event_type'); // e.g., 'click', 'login_attempt', 'suspicious'
            $table->text('message');      // Details about the event
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->foreignId('user_id')
                ->nullable() // Keep this, as failed logins won't have a user ID
                ->constrained()
                ->onDelete('set null'); // Best practice: if a user is deleted, their old logs stay but the ID is cleared.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_logs');
    }
};
