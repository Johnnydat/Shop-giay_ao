<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    public function index(){
       $news = News::query()
            ->where('is_published',true)
            ->get();
       return view('client.news.index', compact('news'));
    }

    public function show($id){
      $new = News::query()
            ->where('is_published',true)
            ->findOrFail($id);
       return view('client.news.show', compact('new'));
    }
}
