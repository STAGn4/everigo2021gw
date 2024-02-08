<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\Opus;
use App\Models\Series;
use Illuminate\Support\Facades\DB;
use App\Models\BookGenre;
use App\Models\Genre;
// GW1 モデル追加
use App\Models\Label;
use App\Models\BookLabel;

class LabelRepository
{
    // 本の詳細取得
    public function getBookDetail($book_no, $series_books_limit)
    {
        //本の情報を取得aa
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
        )
            ->where('book_no', $book_no)
            ->leftJoin('book_size', 'book.book_size_no', '=', 'book_size.book_size_no')
            ->leftJoin('stock_status', 'book.stock_status_no', '=', 'stock_status.stock_status_no')
            ->first();
        if(is_null($book)){
            return null;
        }

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
        $series_books = $this->selectLabelSalesInfo()
            ->whereIn('book.book_no', $series_books_no)
            ->orderBy('release_date', 'desc')
            ->limit($series_books_limit)
            ->get();
        $book->series_books = $series_books;

        return $book;
    }

    // GW1 レーベルの新刊情報用
    public function getNewLabels($limit)
    {
        $image_host = config('app.hondana_url') ?? url('') . ':81';
        return  Book::select(
            'book.book_no',
            'book.name',
            DB::raw('CONCAT(\'' . $image_host . '\',image) as image'),
            'release_date',
            'price',
            'content',
            'page',
            'stock_status.name as stock_status'
        )
            ->leftJoin('book_label', 'book.book_no', '=', 'book_label.book_no')
            ->where('book_label.label_no','=',5)
            ->whereRaw('DATE_FORMAT(release_date, \'%Y%m\') = DATE_FORMAT(NOW(), \'%Y%m\')')
            ->leftJoin('stock_status', 'book.stock_status_no', '=', 'stock_status.stock_status_no')
            ->orderBy('release_date', 'asc')
            ->paginate($limit);
    }

    // おすすめページの追加
    public function getRecommendBooks($limit)
    {
        $image_host = config('app.hondana_url') ?? url('') . ':81';
        return  Book::select(
            'book.book_no',
            'book.name',
            DB::raw('CONCAT(\'' . $image_host . '\',image) as image'),
            'release_date',
            'book.price',
            'book.content',
            'book.page',
            'stock_status.name as stock_status'
        )
            ->where('book.recommend_status', 1)
            ->leftJoin('stock_status', 'book.stock_status_no', '=', 'stock_status.stock_status_no')
            ->orderBy('release_date', 'asc')
            ->paginate($limit);
    }

    // GW1 レーベルページに雑誌のみ抽出
    public function getLabelSalesInfoList(
        $limit,
        $use_paginate = false,
        $order_rule = 'release_date_desc',
        $keywords = null,
        $name = null,
        $author_name = null,
        $series_no = null,
        $label_no = 5,
        $genre_no = null,
        $isbn = null,
        $min_release_date = null,
        $max_release_date = null,
        $recommend_status = null,
    ) {
        $query = $this->selectLabelSalesInfo();

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
            if ($label_no != null) {
                $query
                    ->leftJoin('book_label', 'book.book_no', 'book_label.book_no');
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
        if ($label_no != null) {
            $query->where('book_label.label_no', $label_no);
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

    // GW1 レーベルページに雑誌のジャンル別に表示させる
    public function getGenres()
    {
        return DB::table('genre')
        ->orwhere('genre_no',15)
        ->orwhere('genre_no',16)
        ->orwhere('genre_no',17)
        ->get();
    }

    // GW1 モデルの適用
    public function getLabels()
    {
        return DB::table('label')->get();
    }

    private function getResult($query, $limit, $use_paginate)
    {
        if ($use_paginate) {
            return $query->paginate($limit);
        } else {
            return $query->limit($limit)->get();
        }
    }

    private function selectLabelSalesInfo()
    {
        $image_host = config('app.hondana_url') ?? url('') . ':81';
        return  Book::select(
            'book.book_no',
            'book.name',
            DB::raw('CONCAT(\'' . $image_host . '\',book.image) as image'),
            'book.release_date',
            'book.price',
            'book.page',
            'stock_status.name as stock_status'
        )
        ->leftJoin('stock_status', 'book.stock_status_no', '=', 'stock_status.stock_status_no');
    }
    public function getLabelGenreBooks($genre_no,$limit)
    {
        $image_host = config('app.hondana_url') ?? url('') . ':81';
        return  Book::select(
            'book.book_no',
            'book.name',
            DB::raw('CONCAT(\'' . $image_host . '\',image) as image'),
            'book.release_date',
            'book.price',
            'book.content',
            'page',
            'stock_status.name as stock_status',
            'book_genre.genre_no as genre_no',
            'genre.name as genrename',
            'genre.genre_no'
        )
            ->leftJoin('stock_status', 'book.stock_status_no', '=', 'stock_status.stock_status_no')
            ->leftJoin('book_genre', 'book.book_no','=','book_genre.book_no')
            ->leftjoin('genre','book_genre.genre_no','=','genre.genre_no')
            ->where('book_genre.genre_no', $genre_no)
            ->orderBy('release_date', 'asc')
            ->paginate($limit);

    }
}
