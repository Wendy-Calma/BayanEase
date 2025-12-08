<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('document_request_id')->nullable()->constrained('document_requests')->onDelete('cascade');
            $table->enum('type', [
                'request_received',
                'request_processing',
                'request_ready',
                'request_completed',
                'request_rejected',
                'system_announcement'
            ]);
            $table->string('title');
            $table->text('message');
            $table->enum('channel', ['sms', 'email', 'in_app']);
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->boolean('sms_sent')->default(false);
            $table->boolean('email_sent')->default(false);
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};