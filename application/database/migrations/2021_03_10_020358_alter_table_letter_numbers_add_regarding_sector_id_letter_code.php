<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLetterNumbersAddRegardingSectorIdLetterCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_numbers', function (Blueprint $table) {
            $table->integer('sector_id')->nullable();
            $table->string('regarding')->nullable();
            $table->string('letter_code')->nullable();
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
            //
        });
    }
}
