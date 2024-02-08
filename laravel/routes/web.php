<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TopPageServer;
use App\Http\Controllers\EverigoController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CompanyController;
// GW課題その①
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LabelPageServer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', TopPageServer::class)->name('index');

Route::get('book', [BookController::class, 'index'])->name('book.index');
Route::get('book/new-release', [BookController::class, 'newRelease'])->name('book.new-release');
Route::get('book/recommend', [BookController::class, 'Recommend'])->name('book.recommend');
Route::get('book/{book_no}', [BookController::class, 'detail'])->whereNumber('book_no')->name('book.detail');
// 課題その③
Route::get('book/{book_no}/review', [BookController::class, 'review'])->whereNumber('book_no')->name('book.review');
Route::post('book/{book_no}/review/send',[BookController::class,'reviewsend'])->whereNumber('book_no')->name('review.send');
// 課題その④
Route::get('book/{book_no}/review/list', [BookController::class, 'reviewlist'])->whereNumber('book_no')->name('book.reviewlist');
Route::get('book/{book_no}/review/delete', [BookController::class, 'delete'])->whereNumber('book_no')->name('book.delete');

Route::get('book/{book_no}/review/{review_no}/good', [BookController::class, 'good'])->whereNumber('book_no')->whereNumber('review_no')->name('book.good');
Route::get('book/{book_no}/review/{review_no}/bad', [BookController::class, 'bad'])->whereNumber('book_no')->whereNumber('review_no')->name('book.bad');
Route::get('book/{book_no}/review/{review_no}/reset', [BookController::class, 'reset'])->whereNumber('book_no')->whereNumber('review_no')->name('book.reset');

Route::get('genre/{genre_no}', [BookController::class, 'genre'])->whereNumber('genre_no')->name('book.genre');

Route::get('news', [NewsController::class, 'index'])->name('news.index');
Route::get('news/{news_no}', [NewsController::class, 'detail'])->whereNumber('news_no')->name('news.detail');

Route::get('everigo',[EverigoController::class,'index'])->name('everigo.index');
Route::get('everigo/webbasic',[EverigoController::class,'webbasic'])->name('everigo/webbasic');
Route::get('everigo/programbasic',[EverigoController::class,'programbasic'])->name('everigo/programbasic');
Route::get('everigo/feedback',[EverigoController::class,'feedback'])->name('everigo/feedback');

Route::get('blog',[BlogController::class,'index'])->name('blog.index');
Route::get('blog/{news_no}',[BlogController::class,'detail'])->name('blog.detail');

Route::get('company',[CompanyController::class,'index'])->name('company.index');
Route::get('company/recruit',[CompanyController::class,'recruit'])->name('company.recruit');
Route::get('company/privacy',[CompanyController::class,'privacy'])->name('company.privacy');
Route::get('company/contact',[CompanyController::class,'contact'])->name('company.contact');

Route::post('company/confirm',[CompanyController::class,'confirm'])->name('company.confirm');
Route::post('company/send',[CompanyController::class,'send'])->name('company.send');

// GW課題 その①
Route::get('label',[LabelController::class,'label_index'])->name('labels.index');
Route::get('label/magazine',LabelPageServer::class)->name('label.magazine');
Route::get('label/new-release', [LabelController::class, 'labelRelease'])->name('label.new-release');
Route::get('label/recommend', [LabelController::class, 'Recommend'])->name('label.recommend');
Route::get('recommend', [BookController::class, 'Recommend'])->name('book.recommend');
Route::get('label/genre/{genre_no}', [BookController::class, 'genre'])->whereNumber('genre_no')->name('label.genre');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
