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
        Schema::create('reimbursement_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('reimbursement_id');
            $table->string('file_name');
            $table->timestamps();

            $table->foreign('reimbursement_id')->references('id')->on('reimbursements')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimbursement_files');
    }
};
