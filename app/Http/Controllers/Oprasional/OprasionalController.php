<?php

namespace App\Http\Controllers\Oprasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\menuadmins;

class OprasionalController extends Controller
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
  // public function index()
  // {
  //   $multilevel = menuadmins::get_data();
  //   $index      = menuadmins::where('part','bank')->first();
  //   $aktif_menu = menuadmins::aktif_menu($index['id']);
  //   return view('backend.oprasional.uploadxls', compact('multilevel','aktif_menu'));
  // }

  public function laporan()
  {
    $multilevel = menuadmins::get_data();
    $index      = menuadmins::where('part','oprasional\laporan')->first();
    $aktif_menu = menuadmins::aktif_menu($index['id']);
    return view('backend.oprasional.laporanopr', compact('multilevel','aktif_menu'));
  }

  public function upload()
  {
    $multilevel = menuadmins::get_data();
    $index      = menuadmins::where('part','oprasional\upload')->first();
    $aktif_menu = menuadmins::aktif_menu($index['id']);
    return view('backend.oprasional.files', compact('multilevel','aktif_menu'));
  }
  public function chart()
  {
    $multilevel = menuadmins::get_data();
    $index      = menuadmins::where('part','oprasional\chart')->first();
    $aktif_menu = menuadmins::aktif_menu($index['id']);
    return view('backend.oprasional.chart', compact('multilevel','aktif_menu'));
  }
  public function mkapal()
  {
    $multilevel = menuadmins::get_data();
    $index      = menuadmins::where('part','oprasional\mkapal')->first();
    $aktif_menu = menuadmins::aktif_menu($index['id']);
    return view('backend.oprasional.mkapal', compact('multilevel','aktif_menu'));
  }

}