<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Library\KeywordsParser;
use App\Repositories\LabelRepository;

class LabelController extends Controller
{
    protected $label_repository;

    public function __construct(LabelRepository $label_repository)
    {
        $this->label_repository = $label_repository;
    }

    public function magazine(Request $request)
    {
        $keywords = KeywordsParser::parseFromString($request->keyword);

        $limit = $request->limit ?? 20;
        if ($limit > 120) {
            $limit = 120;
        }

        $books = $this->label_repository->getLabelSalesInfoList(
            limit: $limit,
            use_paginate: true,
            keywords: $keywords,
            max_release_date: Carbon::now(),
            order_rule: $request->order_rule,
            name: $request->name,
            label_no: $request->label,
            genre_no: $request->genre,
            isbn: $request->isbn,
            author_name: $request->author,
        );

        $labels = $this->label_repository->getLabels();
        $genres = $this->label_repository->getGenres();
        $params = [
            'labels' => $labels,
            'books' => $books,
            'genres' => $genres,
        ];
        return view('label.magazine', $params);
    }

    // 12/24レーベルを作成
    public function label_index()
    {
        return view('label.index');
    }
    //

    public function labelRelease()
    {
        $books = $this->label_repository->getNewLabels(limit: 5);
        return view('book.new-release', ['books' => $books]);
    }

    public function detail($book_no)
    {
        $book = $this->label_repository->getBookDetail($book_no, series_books_limit: 6);
        if(is_null($book)){
            abort(404);
        }
        return view('book.detail', ['book' => $book]);
    }

    public function genre($genre_no)
    {
        $books = $this->label_repository->getLabelGenrebooks($genre_no,limit: 5);
        $book_genrename = $books->first()->genrename;
        if (is_null($books)) {
            abort(404);
        }

        return view('book.genre', ['books' => $books,'book_genrename'=>$book_genrename]);
    }
    // おすすめ一覧の追加
    public function Recommend()
    {
        $books = $this->label_repository->getRecommendBooks(limit: 5);
        return view('book.recommend', ['books' => $books]);
    }


}
