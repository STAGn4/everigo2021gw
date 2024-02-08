<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BlogRepository;

class BlogController extends Controller
{
    protected $blog_repository;

    public function __construct(BlogRepository $blog_repository)
    {
        $this->blog_repository = $blog_repository;
    }

    public function index()
    {
        $blog_list = $this->blog_repository->getblogList(limit: 10, use_paginate: true);
        return view('blog.index', ['blog_list' => $blog_list]);
    }

    public function detail($news_no)
    {
        $blog = $this->blog_repository->getblogDetail($news_no);
        if (is_null($blog)) {
            abort(404);
        }
        return view('blog.detail', ['blog' => $blog]);
    }

}
