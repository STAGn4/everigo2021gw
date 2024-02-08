<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
//bookrepositoryを削除
use App\Repositories\NewsRepository;
use App\Repositories\BannerRepository;
// lebelrepositoryを追加
use App\Repositories\LabelRepository;
use App\Models\Genre;

class LabelPageServer extends Controller
{
    public function __invoke(NewsRepository $news_repository, BannerRepository $banner_repository, LabelRepository $label_repository)
    {
        //bookをlabelに変更
        $news_list = $news_repository->getNewsList(limit: 5);
        $new_label_sales_info_list = $label_repository->getLabelSalesInfoList(limit: 6, max_release_date: Carbon::now(), order_rule: 'release_date_desc');
        $upcoming_label_sales_info_list = $label_repository->getLabelSalesInfoList(limit: 6, min_release_date: Carbon::now(), order_rule: 'release_date_asc');
        $recommend_label_sales_info_list = $label_repository->getLabelSalesInfoList(limit: 6, recommend_status: 1, order_rule: 'release_date_desc');
        $banners = $banner_repository->getBanners(limit: 3);

        $book_label_genre_info_list = [];
        $genres = $label_repository->getGenres();
        foreach($genres as $genre){
            $book_label_genre_info_list[$genre->genre_no]=$label_repository->getLabelGenreBooks(genre_no: $genre->genre_no, limit: 6);
        }
        //$paramsの中のbookをlabelに変更
        $params = [
            'news_list' => $news_list,
            'new_label_sales_info_list' => $new_label_sales_info_list,
            'upcoming_label_sales_info_list' => $upcoming_label_sales_info_list,
            'recommend_label_sales_info_list' => $recommend_label_sales_info_list,
            'banners' => $banners,
            'book_label_genre_info_list' => $book_label_genre_info_list,
            'genres' => $genres,
        ];
        return view('label.magazine', $params);
    }
}
