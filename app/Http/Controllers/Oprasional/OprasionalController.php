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

  public function ppjk()
  {
    $multilevel = menuadmins::get_data();
    $index      = menuadmins::where('part','oprasional\ppjk')->first();
    $aktif_menu = menuadmins::aktif_menu($index['id']);
    return view('backend.oprasional.ppjk', compact('multilevel','aktif_menu'));
  }
  public function dl()
  {
    $multilevel = menuadmins::get_data();
    $index      = menuadmins::where('part','oprasional\dl')->first();
    $aktif_menu = menuadmins::aktif_menu($index['id']);
    return view('backend.oprasional.laporanopr', compact('multilevel','aktif_menu'));
  }
  public function lhp()
  {
    $multilevel = menuadmins::get_data();
    $index      = menuadmins::where('part','oprasional\lhp')->first();
    $aktif_menu = menuadmins::aktif_menu($index['id']);
    return view('backend.oprasional.lhpopr', compact('multilevel','aktif_menu'));
  }
  public function bstdo()
  {
    $multilevel = menuadmins::get_data();
    $index      = menuadmins::where('part','oprasional\bstdo')->first();
    $aktif_menu = menuadmins::aktif_menu($index['id']);
    return view('backend.oprasional.bstdo', compact('multilevel','aktif_menu'));
  }
  public function report()
  {
    $multilevel = menuadmins::get_data();
    $index      = menuadmins::where('part','oprasional\report')->first();
    $aktif_menu = menuadmins::aktif_menu($index['id']);
    return view('backend.oprasional.report', compact('multilevel','aktif_menu'));
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
  public function masteroper()
  {
    $multilevel = menuadmins::get_data();
    $index      = menuadmins::where('part','oprasional\masteroper')->first();
    $aktif_menu = menuadmins::aktif_menu($index['id']);
    return view('backend.oprasional.masteroper', compact('multilevel','aktif_menu'));
  }

  public function mkapal(){
    return view('backend.oprasional.submasterdata.mkapal');
  }
  public function magen(){
      return view('backend.oprasional.submasterdata.magen');
  }
  public function mpc(){
    return view('backend.oprasional.submasterdata.mpc');
  }
  public function mdermaga(){
      return view('backend.oprasional.submasterdata.mdermaga');
  }
  public function mmooring(){
      return view('backend.oprasional.submasterdata.mmooring');
  }
}
