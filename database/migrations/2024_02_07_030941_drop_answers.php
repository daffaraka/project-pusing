<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('remarks', function (Blueprint $table) {
        // Drop foreign key constraint
        $table->dropForeign(['answer_id']); // Ganti 'foreign_key_column' dengan nama kolom kunci asing
        //$table->dropForeign(['question_id']); // Ganti 'foreign_key_column' dengan nama kolom kunci asing

        // Drop the column
        $table->dropColumn('answer_id'); // Ganti 'foreign_key_column' dengan nama kolom kunci asing
        //$table->dropColumn('question_id'); // Ganti 'foreign_key_column' dengan nama kolom kunci asing
    });

    Schema::dropIfExists('remarks'); // Ganti 'table_name' dengan nama tabel yang ingin Anda hapus
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
