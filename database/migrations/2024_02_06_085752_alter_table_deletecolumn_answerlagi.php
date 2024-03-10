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
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('remark')->nullable(); // Jika tipe data di tabel questions adalah integer
            $table->dropColumn('note')->nullable();
                
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->integer('remark')->nullable(); // Jika tipe data di tabel questions adalah integer
            $table->string('note')->nullable();
        });
    }
};
