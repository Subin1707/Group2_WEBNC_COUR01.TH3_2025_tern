<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class HomeController extends Controller
{
    public function index(){
        $trendingMovies = Movie::orderBy('id', 'desc')->take(4)->get();
        return view('home', compact('trendingMovies'));
    }
}
