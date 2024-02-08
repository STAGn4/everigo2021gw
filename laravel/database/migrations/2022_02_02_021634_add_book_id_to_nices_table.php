<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookIdToNicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nices', function (Blueprint $table) {
            $table->Integer('review_no')->length(11)->default(0)->comment('レビューNO');
            $table->Integer('book_no')->length(11)->default(0)->comment('ブックNO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nices', function (Blueprint $table) {
            //
        });
    }
}
