<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveGoodToBookReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_reviews', function (Blueprint $table) {
            $table->dropColumn('good');
            $table->dropColumn('bad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_reviews', function (Blueprint $table) {
            $table->Integer('good')->length(11)->default(0)->comment('good評価');
            $table->Integer('bad')->length(11)->default(0)->comment('bad評価');
        });
    }
}
