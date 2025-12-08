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
        Schema::table('document_requests', function (Blueprint $table) {
            // Column should already exist from previous migration
            // Just ensure the foreign key constraint exists
            if (!Schema::hasColumn('document_requests', 'dependent_id')) {
                $table->foreignId('dependent_id')->nullable()->constrained('dependents')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            $table->dropForeign(['dependent_id']);
        });
    }
};
