<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;    
use Illuminate\Http\Request;

use App\Models\datacenter\News;

class NewsController extends Controller
{
    public function index()
    {
        $newsItems = News::where('is_active', true)
            ->orderBy('published_date', 'desc')
            ->get();

        return view('frontend.news.index', compact('newsItems'));
    }
}
