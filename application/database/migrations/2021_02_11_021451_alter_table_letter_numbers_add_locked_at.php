<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLetterNumbersAddLockedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_numbers', function (Blueprint $table) {
          $table->dateTime('locked_at')->nullable();
          $table->unsignedBigInteger('locked_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letter_numbers', function (Blueprint $table) {
          $table->dropColumn('locked_at');
            $table->dropColumn('locked_by');
        });
    }
}
