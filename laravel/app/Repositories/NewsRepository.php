<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Support\Facades\DB;

class NewsRepository
{
    public function getNewsList($limit, $use_paginate = false)
    {
        $news_list_query = News::select('news.news_no', 'news.name', 'news.public_date', 'news_category.name as category')
            ->orwhere('news_category.news_category_no','2')
            ->orwhere('news_category.news_category_no','3')
            ->leftJoin('news_category', 'news.news_category_no', '=', 'news_category.news_category_no')
            ->orderBy('public_date', 'desc');

        if ($use_paginate) {
            return $news_list_query->paginate($limit);
        } else {
            return $news_list_query->limit($limit)->get();
        }
    }

    public function getNewsDetail($news_no)
    {
        return News::select('news.name', 'news.value', 'news.u_stamp as update_date')
            ->where('news.news_no', $news_no)
            ->first();
    }
}
