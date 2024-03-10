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
        Schema::create('remarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('answer_id');
            $table->unsignedBigInteger('remark');
            // $table->integer('remark')->nullable(); // Jika tipe data di tabel questions adalah integer
            // $table->string('note')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('cascade');
            //$table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
