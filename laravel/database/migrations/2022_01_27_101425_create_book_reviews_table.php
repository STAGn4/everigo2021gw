<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('book_reviews', function (Blueprint $table) {
        $table->Increments('review_no');
        $table->Integer('book_no')->length(11)->default(0)->comment('書籍No');
        $table->Integer('user_id')->length(11)->default(0)->comment('ユーザーID');
        $table->Float('stars',11, 1)->default(0)->comment('星');
        $table->Text('title')->comment('タイトル');
        $table->MediumText('value')->comment('レビュー内容');
        $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));


        $table->foreign('book_no')->references('book_no')->on('book');
        $table->foreign('user_id')->references('id')->on('users');
        $table->unique(['book_no', 'user_id']);
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_reviews');
    }
}
