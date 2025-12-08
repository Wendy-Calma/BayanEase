<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number', 50)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('document_type_id')->constrained('document_types')->onDelete('restrict');
            $table->text('purpose');
            $table->enum('status', [
                'pending',
                'processing',
                'ready_for_pickup',
                'completed',
                'rejected',
                'cancelled'
            ])->default('pending');
            $table->enum('priority', ['low', 'normal', 'high'])->default('normal');
            $table->string('contact_number', 15);
            $table->date('preferred_pickup_date')->nullable();
            $table->text('special_instructions')->nullable();
            
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('processing_started_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('reference_number');
            $table->index('status');
            $table->index(['user_id', 'status']);
            $table->index('submitted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};