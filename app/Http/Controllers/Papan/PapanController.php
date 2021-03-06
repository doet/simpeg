<?php

namespace App\Http\Controllers\Papan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\menuadmins;

class PapanController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $multilevel = menuadmins::get_data();
    $index      = menuadmins::where('part','papan')->first();
    $aktif_menu = menuadmins::aktif_menu($index['id']);
    return view('backend.papan.dasboard', compact('multilevel','aktif_menu'));
  }
  public function trxharian()
  {
    // $multilevel = menuadmins::get_data();
    // $index      = menuadmins::where('part','bank\trxharian')->first();
    // $aktif_menu = menuadmins::aktif_menu($index['id']);
    // return view('backend.bank.dasboard', compact('multilevel','aktif_menu'));
  }
}
