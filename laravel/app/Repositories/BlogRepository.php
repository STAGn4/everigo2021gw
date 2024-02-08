<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Support\Facades\DB;

class BlogRepository
{
    public function getBlogList($limit, $use_paginate = false)
    {
        $blog_list_query = News::select(
            'news.news_no',
            'news.name',
            'news.public_date',
            'news_category.name as category'

        )
            ->where('news_category.news_category_no','4')
            ->leftJoin('news_category', 'news.news_category_no', '=', 'news_category.news_category_no')
            ->orderBy('public_date', 'desc');

        if ($use_paginate) {
            return $blog_list_query->paginate($limit);
        } else {
            return $blog_list_query->limit($limit)->get();
        }
    }

    public function getBlogDetail($news_no)
    {
        return News::select(
            'news.name',
            'news.value',
            'news.u_stamp as update_date'
        )
            ->where('news.news_no', $news_no)
            ->first();
    }
}
