<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Library\KeywordsParser;
use App\Repositories\BookRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Book;

class BookController extends Controller
{
    protected $book_repository;

    public function __construct(BookRepository $book_repository)
    {
        $this->book_repository = $book_repository;
    }

    public function index(Request $request)
    {
        $keywords = KeywordsParser::parseFromString($request->keyword);

        $limit = $request->limit ?? 20;
        if ($limit > 120) {
            $limit = 120;
        }

        $books = $this->book_repository->getBookSalesInfoList(
            limit: $limit,
            use_paginate: true,
            keywords: $keywords,
            max_release_date: Carbon::now(),
            order_rule: $request->order_rule,
            name: $request->name,
            series_no: $request->series,
            genre_no: $request->genre,
            isbn: $request->isbn,
            author_name: $request->author,
        );

        $series_list = $this->book_repository->getSeriesList();
        $genres = $this->book_repository->getGenres();
        $params = [
            'books' => $books,
            'series_list' => $series_list,
            'genres' => $genres,
        ];
        return view('book.index', $params);
    }

    public function newRelease()
    {
        $books = $this->book_repository->getNewBooks(limit: 5);
        return view('book.new-release', ['books' => $books]);
    }

    public function Recommend()
    {
        $books = $this->book_repository->getRecommendBooks(limit: 5);
        return view('book.recommend', ['books' => $books]);
    }

    public function detail($book_no)
    {
        $book = $this->book_repository->getBookDetail($book_no, series_books_limit: 6);
        $rate = DB::table('book_reviews')->where('book_no',$book_no)->avg('stars');
        $book->floatStar = number_format($rate,1);
        $book->count = DB::table('book_reviews')->where('book_no',$book_no)->count('stars');
        if(is_null($book)){
            abort(404);
        }
        return view('book.detail',['book' => $book]);
    }

    public function genre($genre_no)
    {
        $books = $this->book_repository->getGenrebooks($genre_no,limit: 5);
        $book_genrename = $books->first()->genrename;
        if (is_null($books)) {
            abort(404);
        }

        // dd($books);

        return view('book.genre', ['books' => $books,'book_genrename'=>$book_genrename]);
    }

    public function review($book_no) {
        $book = $this->book_repository->getBookDetail($book_no, series_books_limit: 6);
        return view('book.review',['book' => $book]);
    }

    public function reviewsend($book_no,Request $request) {
        DB::table('book_reviews')->upsert([
            'book_no' => $request->input('book_no'),
            'user_id' => $request->input('user_id'),
            'stars' => $request->input('stars'),
            'title' => $request->input('title'),
            'value' => $request->input('value'),
        ],'user_id');
        $book = $this->book_repository->getBookDetail($book_no, series_books_limit: 6);
        $request->session()->regenerateToken();
        return view('book.reviewsend',['book' => $book,'review_data' => $request]);
    }

    public function delete($book_no){
        $book = $this->book_repository->getBookDetail($book_no, series_books_limit: 6);
        DB::table('book_reviews')->where('user_id', '=', auth()->id())->where('book_no',$book_no)->delete();
        return view('book.delete',['book' => $book]);
    }

    public function reviewlist($book_no) {
        $book = $this->book_repository->getBookDetail($book_no, series_books_limit: 6);
        $rate = DB::table('book_reviews')->where('book_no',$book_no)->avg('stars');
        $book->floatStar = number_format($rate,1);
        $book->count = DB::table('book_reviews')->where('book_no',$book_no)->count('stars');
        $book->good = DB::table('nices')->where('book_no',$book_no)->where('review_id', 1)->count('review_id');
        $book->bad = DB::table('nices')->where('book_no',$book_no)->where('review_id', 2)->count('review_id');
        return view('book.reviewlist',['book' => $book]);
    }

    public function Good($book_no,$review_no)
    {
        $book = $this->book_repository->getBookDetail($book_no, series_books_limit: 6);
        DB::table('nices')->upsert([
            'review_id' => 1,
            'book_no' => $book_no,
            'review_no' =>  $review_no,
            'user_id' => auth()->id(),
        ],['book_no','user_id'],['review_no','review_id']);
        return view('book.good',['book' => $book]);
    }

    public function Bad($book_no,$review_no)
    {
        $book = $this->book_repository->getBookDetail($book_no, series_books_limit: 6);
        DB::table('nices')->upsert([
            'review_id' => 2,
            'book_no' => $book_no,
            'review_no' =>  $review_no,
            'user_id' => auth()->id(),
        ],['book_no','user_id'],['review_no','review_id']);
        return view('book.bad',['book' => $book]);
    }

    public function Reset($book_no,$review_no)
    {
        $book = $this->book_repository->getBookDetail($book_no, series_books_limit: 6);
        DB::table('nices')->where('user_id', auth()->id())->where('review_no',$review_no)->where('book_no',$book_no)->delete();
        return view('book.reset',['book' => $book]);
    }
}
