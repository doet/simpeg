<?php

namespace App\Http\Controllers\Oprasional;
date_default_timezone_set('Asia/Jakarta');

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;

class PDFController extends Controller
{
  // /**
  //  * Create a new controller instance.
  //  *
  //  * @return void
  //  */
  // public function __construct()
  // {
  //     $this->middleware('auth');
  // }
  //
  // /**
  //  * Show the application dashboard.
  //  *
  //  * @return \Illuminate\Http\Response
  //  */

  public function PDFMarker(Request $request){
    $mulai = $request->input('start', '0');
    $akhir = $request->input('end', '0');
    // $akhir = '05 March 2019';
    $sord = $request->input('sord', 'asc');
    $sidx = $request->input('sidx', 'id');

    $category = $request->input('page', 'unknow');
    switch ($category) {
      case 'dl-dompdf': //Pengajuan Pembiyayaan
        $result = DB::table('tb_dls')
        ->leftJoin('tb_agens', function ($join) {
          $join->on('tb_dls.agens_id', '=', 'tb_agens.id');
        })
        ->leftJoin('tb_kapals', function ($join) {
          $join->on('tb_dls.kapals_id', '=', 'tb_kapals.id');
        })
        ->leftJoin('tb_jettys', function ($join) {
          $join->on('tb_dls.jetty_id', '=', 'tb_jettys.id');
        })
        ->where(function ($query) use ($mulai,$akhir){
          $mulai = strtotime($mulai);
          $akhir = strtotime($akhir);
          if($akhir==0)$akhir = $mulai+(60 * 60 * 24);
          $query->where('date', '>=', $mulai)
            ->Where('date', '<', $akhir);
        })
        ->select(
          'tb_agens.code as agenCode',
          'tb_kapals.value as kapalsName',
          'tb_kapals.jenis as kapalsJenis',
          'tb_kapals.grt as kapalsGrt',
          'tb_kapals.loa as kapalsLoa',
          'tb_kapals.bendera as kapalsBendera',
          'tb_jettys.name as jettyName',
          'tb_jettys.code as jettyCode',
          // 'tb_jettys.color as jettyColor',
          'tb_dls.*'
          )
          ->orderBy($sidx, $sord)
          ->orderBy('ppjk', 'desc')
          ->get();
          // $result = json_encode(json_decode($qu));
          // $result = json_decode($result,true);
          // if ($result['records']>1) $result = $result['rows']; else $result = array();
          // $result = $request->data;
          // print_r ($query);

          $page = 'backend.oprasional.pdf.'.$request->input('page');
          $nfile = $request->input('file');
          $orientation = 'landscape';

          $view =  \View::make($page, compact('result','mulai'))->render();
      break;
      case 'lhp1-dompdf':
        $result = DB::table('tb_dls')
        ->leftJoin('tb_agens', function ($join) {
          $join->on('tb_dls.agens_id', '=', 'tb_agens.id');
        })
        ->leftJoin('tb_kapals', function ($join) {
          $join->on('tb_dls.kapals_id', '=', 'tb_kapals.id');
        })
        ->leftJoin('tb_jettys', function ($join) {
          $join->on('tb_dls.jetty_id', '=', 'tb_jettys.id');
        })
        ->where(function ($query) use ($mulai,$akhir){
          $mulai = strtotime($mulai);
          $akhir = strtotime($akhir);
          if($akhir==0)$akhir = $mulai+(60 * 60 * 24);
          $query
            ->where('lhp_date', '>=', $mulai)
            ->Where('lhp_date', '<', $akhir);
          // $query->where('lhp_date', '!=', '');
        })
        ->select(
          'tb_agens.code as agenCode',
          'tb_kapals.value as kapalsName',
          'tb_kapals.jenis as kapalsJenis',
          'tb_kapals.grt as kapalsGrt',
          'tb_kapals.loa as kapalsLoa',
          'tb_kapals.bendera as kapalsBendera',
          'tb_jettys.name as jettyName',
          'tb_jettys.code as jettyCode',
          // 'tb_jettys.color as jettyColor',
          'tb_dls.*'
        )
        ->orderBy($sidx, $sord)
        ->get();
        // $result = json_encode(json_decode($qu));
        // $result = json_decode($result,true);
        // if ($result['records']>1) $result = $result['rows']; else $result = array();
        // $result = $request->data;
        // print_r ($query);

        // $mulai = strtotime($mulai);
        // dd($mulai);

        $page = 'backend.oprasional.pdf.'.$request->input('page');
        $nfile = $request->input('file');
        $orientation = 'landscape';

        $view =  \View::make($page, compact('result','mulai'))->render();
      break;
    }

    // return view($page, compact('result','mulai'));

    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view)
        //->setOrientation($orientation)
        ->setPaper('a4',$orientation);

    return $pdf->stream($nfile);

    // } else { echo "page tidak dapat di diperbaharui, silahkan kembali kehalaman sebelum";}
  }
}
