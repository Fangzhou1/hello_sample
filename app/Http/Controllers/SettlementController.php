<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settlement;
use Auth;


class SettlementController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index()
    {
        // $page=10;
        // $settlements = Settlement::paginate($page);
        return view('settlements.index');
    }

  public function importpage()
    {
        // $page=10;
        // $settlements = Settlement::paginate($page);
        return view('settlements.importpage');
    }

    public function import()
      {
          // $page=10;
          // $settlements = Settlement::paginate($page);
          return view('settlements.importpage');
      }


}
