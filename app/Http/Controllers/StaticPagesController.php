<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{

  public function home(Request $request)
  {
      return view('static_pages/home',['current_url'=>$request->url()]);
  }

  public function help(Request $request)
  {
      return view('static_pages/help',['current_url'=>$request->url()]);
  }

  public function about(Request $request)
  {
      return view('static_pages/about',['current_url'=>$request->url()]);
  }
}
