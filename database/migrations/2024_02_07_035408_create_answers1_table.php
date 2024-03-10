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
        Schema::create('answers1', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('auditor_id');
            // $table->string('image')->nullable();
            $table->timestamps();
        
            // $table->foreign('auditor_id')->references('id')->on('auditors')->onDelete('cascade');
            //$table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers1');
    }
};
