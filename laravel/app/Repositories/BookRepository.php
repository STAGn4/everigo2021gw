<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\Opus;
use App\Models\Series;
use Illuminate\Support\Facades\DB;
use App\Models\BookGenre;
use App\Models\Genre;
use App\Models\BookReviews;


class BookRepository
{
    public function getBookDetail($book_no, $series_books_limit)
    {
        //本の情報を取得
        $image_host = config('app.hondana_url') ?? url('') . ':81';
        $book =  Book::select(
            'book.book_no',
            'book.name',
            DB::raw('CONCAT(\'' . $image_host . '\',book.image) as image'),
            'release_date',
            'book.price',
            'book.content',
            'book.isbn',
            'book_size.name as size',
            'book.page',
            'stock_status.name as stock_status',
            'book_reviews.user_id',
            'book_reviews.stars',
            'book_reviews.title',
            'book_reviews.value',
        )
        ->where('book.book_no', $book_no)
        ->leftJoin('book_reviews', function ($join) {
            $join->on('book_reviews.book_no', '=', 'book.book_no')
              ->where('book_reviews.user_id', '=', auth()->id());
            })
        ->leftJoin('book_size', 'book.book_size_no', '=', 'book_size.book_size_no')
        ->leftJoin('stock_status', 'book.stock_status_no', '=', 'stock_status.stock_status_no')
        ->first();
    if(is_null($book)){
        return null;
    }
        //レビュー情報を取得し、本の情報に追加
        $reviews = BookReviews::select(
            'book_reviews.book_no',
            'book_reviews.review_no',
            'book_reviews.user_id',
            'book_reviews.title',
            'book_reviews.value',
            'book_reviews.stars',
            'book_reviews.updated_at',
            'users.name',
            'nices.review_id'
        )
            ->where('book_reviews.book_no', $book_no)
            ->leftJoin('users', 'book_reviews.user_id', '=', 'users.id')
            ->leftJoin('nices', 'book_reviews.user_id', '=', 'nices.user_id')
            ->orderBy('updated_at', 'desc')
            ->get();
        $book->reviews = $reviews;

        //著者情報を取得し、本の情報に追加
        $authors = Opus::select(
            'author.name as name',
            'author_type.name as type',
        )
            ->where('book_no', $book_no)
            ->leftJoin('author', 'opus.author_no', 'author.author_no')
            ->leftJoin('author_type', 'opus.author_type_no', 'author_type.author_type_no')
            ->get();
        $book->authors = $authors;

         //ジャンル情報を取得し、本の情報に追加
         $genres = Book::select(
            'genre.name as name'
        )
            ->where('book.book_no', $book_no)
            ->leftjoin('book_genre','book.book_no','=','book_genre.book_no')
            ->leftjoin('genre','book_genre.genre_no','=','genre.genre_no')
            ->get();
         $book->genres = $genres;


        //本のシリーズ(複数)を取得するサブクエリ
        $book_series = function ($query) use ($book_no) {
            $query->select('book_series.series_no')
                ->from('book_series')
                ->where('book_series.book_no', $book_no);
        };

        //同じシリーズの本のbook_no(複数)を取得するサブクエリ
        $series_books_no = function ($query) use ($book_no, $book_series) {
            $query->select('book_series.book_no')
                ->from('book_series')
                ->whereIn('book_series.series_no', $book_series)
                ->where('book_series.book_no', '!=', $book_no);
        };

        //同じシリーズの本を取得し、本の情報に追加
        $series_books = $this->selectBookSalesInfo()
            ->whereIn('book.book_no', $series_books_no)
            ->orderBy('release_date', 'desc')
            ->limit($series_books_limit)
            ->get();
        $book->series_books = $series_books;

        return $book;
    }

    public function getNewBooks($limit)
    {
        $image_host = config('app.hondana_url') ?? url('') . ':81';
        return  Book::select(
            'book_no',
            'book.name',
            DB::raw('CONCAT(\'' . $image_host . '\',image) as image'),
            'release_date',
            'price',
            'content',
            'page',
            'stock_status.name as stock_status'

        )
            ->whereRaw('DATE_FORMAT(release_date, \'%Y%m\') = DATE_FORMAT(NOW(), \'%Y%m\')')
            ->leftJoin('stock_status', 'book.stock_status_no', '=', 'stock_status.stock_status_no')
            ->orderBy('release_date', 'asc')
            ->paginate($limit);
    }

    public function getBookSalesInfoList(
        $limit,
        $use_paginate = false,
        $order_rule = 'release_date_desc',
        $keywords = null,
        $name = null,
        $author_name = null,
        $series_no = null,
        $genre_no = null,
        $isbn = null,
        $min_release_date = null,
        $max_release_date = null,
        $recommend_status = null,
    ) {
        $query = $this->selectBookSalesInfo();

        //絞り込みに使用するカラムをJOIN
        if ($keywords != null) {
            $query
                ->leftJoin('opus', 'book.book_no', 'opus.book_no')
                ->leftJoin('author', 'opus.author_no', 'author.author_no')
                ->leftJoin('book_series', 'book.book_no', 'book_series.book_no')
                ->leftJoin('series', 'book_series.series_no', 'series.series_no')
                ->leftJoin('book_genre', 'book.book_no', 'book_genre.book_no')
                ->leftJoin('genre', 'book_genre.genre_no', 'genre.genre_no');
        } else {
            if ($author_name != null) {
                $query
                    ->leftJoin('opus', 'book.book_no', 'opus.book_no')
                    ->leftJoin('author', 'opus.author_no', 'author.author_no');
            }
            if ($series_no != null) {
                $query
                    ->leftJoin('book_series', 'book.book_no', 'book_series.book_no');
            }
            if ($genre_no != null) {
                $query
                    ->leftJoin('book_genre', 'book.book_no', 'book_genre.book_no');
            }
        }

        //絞り込み
        if ($isbn != null) {
            $query->where('book.isbn', $isbn);
        }
        if ($series_no != null) {
            $query->where('book_series.series_no', $series_no);
        }
        if ($genre_no != null) {
            $query->where('book_genre.genre_no', $genre_no);
        }
        if ($min_release_date != null) {
            $query->where('release_date', '>=', $min_release_date);
        }
        if ($max_release_date != null) {
            $query->where('release_date', '<=', $max_release_date);
        }
        if ($name != null) {
            $query->where('book.name', 'LIKE', "%$name%");
        }
        if ($author_name != null) {
            $query->where('author.name', 'LIKE', "%$author_name%");
        }
        if ($recommend_status != null) {
            $query->where('recommend_status', '=', $recommend_status);
        }
        if ($keywords != null) {
            foreach ($keywords as $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query
                        ->where('book.name', 'LIKE', "%$keyword%")
                        ->orWhere('author.name', 'LIKE', "%$keyword%")
                        ->orWhere('series.name', 'LIKE', "%$keyword%")
                        ->orWhere('genre.name', 'LIKE', "%$keyword%");
                });
            }
        }

        //並び替え
        switch ($order_rule) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'release_date_asc':
                $query->orderBy('release_date', 'asc');
                break;
            case 'release_date_desc':
            default:
                $query->orderBy('release_date', 'desc');
                break;
        }

        $query->groupBy('book.book_no');
        return $this->getResult($query, $limit, $use_paginate);
    }

    public function getSeriesList()
    {
        return Series::all();
    }

    public function getGenres()
    {
        return DB::table('genre')->get();
    }

    private function getResult($query, $limit, $use_paginate)
    {
        if ($use_paginate) {
            return $query->paginate($limit);
        } else {
            return $query->limit($limit)->get();
        }
    }

    private function selectBookSalesInfo()
    {
        $image_host = config('app.hondana_url') ?? url('') . ':81';
        $reviews = DB::table('book_reviews')
          ->select('book_no', DB::raw('COUNT(*) as review_cnt, AVG(stars) as review_rate'))->groupBy('book_no');
        return  Book::select(
            'book.book_no',
            'book.name',
            DB::raw('CONCAT(\'' . $image_host . '\',book.image) as image'),
            'book.release_date',
            'book.price',
            'book.page',
            'stock_status.name as stock_status',
            DB::raw('IFNULL(reviews.review_cnt,\'0\') as post_cnt'),
            DB::raw('IFNULL(reviews.review_rate,\'0\') as rate')
        )
        ->leftJoinSub($reviews, 'reviews', function ($join){
          $join->on('book.book_no', '=', 'reviews.book_no');
        })
        ->leftJoin('stock_status', 'book.stock_status_no', '=', 'stock_status.stock_status_no');
    }
}
