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
        Schema::table('answers1', function (Blueprint $table) {
            $table->unsignedBigInteger('auditor_id');
            $table->string('image')->nullable();
            $table->foreign('auditor_id')->references('id')->on('auditors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('answers1', function (Blueprint $table) {
            // $table->dropColumn('auditor_id');
            // $table->dropColumn('image')->nullable();
        });
    }
};
