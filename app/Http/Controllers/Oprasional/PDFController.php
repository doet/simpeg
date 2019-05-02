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
          ->join('tb_ppjks', function ($join) {
            $join->on('tb_ppjks.id','tb_dls.ppjks_id');
          })
          ->leftJoin('tb_jettys', function ($join) {
            $join->on('tb_jettys.id', '=', 'tb_ppjks.jettys_id');
          })
          ->leftJoin('tb_kapals', function ($join) {
            $join->on('tb_kapals.id', 'tb_ppjks.kapals_id');
          })
          ->leftJoin('tb_agens', function ($join) {
            $join->on('tb_agens.id', '=', 'tb_ppjks.agens_id');
          })
        // ->where(function ($query) use ($mulai,$akhir){
        //   $mulai = strtotime($mulai);
        //   $akhir = strtotime($akhir);
        //   if($akhir==0)$akhir = $mulai+(60 * 60 * 24);
        //   $query->where('date', '>=', $mulai)
        //     ->Where('date', '<', $akhir);
        // })
          ->select(
            // 'tb_jettys.color as jettyColor',
            'tb_dls.*',
            // 'tb_ppjks.*',
            'tb_ppjks.id as ppjks_id',
            'tb_ppjks.ppjk',
            'tb_jettys.code as jettyCode',
            'tb_jettys.name as jettyName',

            'tb_kapals.jenis as kapalsJenis',
            'tb_kapals.name as kapalsName',
            'tb_kapals.grt as kapalsGrt',
            'tb_kapals.loa as kapalsLoa',
            'tb_kapals.bendera as kapalsBendera',

            'tb_agens.code as agenCode'
            )
          ->orderBy($sidx, $sord)
          ->get();
          // $result = json_encode(json_decode($qu));
          // $result = json_decode($result,true);
          // if ($result['records']>1) $result = $result['rows']; else $result = array();
          // $result = $request->data;
          // print_r ($query);
          // dd($result);
          $page = 'backend.oprasional.pdf.'.$request->input('page');
          $nfile = $request->input('file');
          $orientation = 'landscape';

          $view =  \View::make($page, compact('result','mulai'))->render();
      break;
      case 'lhp1-dompdf':
        $result = DB::table('tb_dls')
          ->join('tb_ppjks', function ($join) {
            $join->on('tb_ppjks.id','tb_dls.ppjks_id');
          })
          ->leftJoin('tb_jettys', function ($join) {
            $join->on('tb_jettys.id', '=', 'tb_ppjks.jettys_id');
          })
          ->leftJoin('tb_kapals', function ($join) {
            $join->on('tb_kapals.id', 'tb_ppjks.kapals_id');
          })
          ->leftJoin('tb_agens', function ($join) {
            $join->on('tb_agens.id', '=', 'tb_ppjks.agens_id');
          })
          ->where(function ($query) use ($mulai,$akhir){
            $mulai = strtotime($mulai);
            $akhir = strtotime($akhir);
            if($akhir==0)$akhir = $mulai+(60 * 60 * 24);
            $query
              ->where('bstdo', '>=', $mulai)
              ->Where('bstdo', '<', $akhir);
            // $query->where('lhp_date', '!=', '');
          })
          ->select(
            'tb_jettys.code as jettyCode',
            'tb_kapals.jenis as kapalsJenis',
            'tb_agens.code as agenCode',
            'tb_kapals.name as kapalsName',
            'tb_kapals.grt as kapalsGrt',
            'tb_kapals.loa as kapalsLoa',
            'tb_kapals.bendera as kapalsBendera',
            'tb_jettys.name as jettyName',
            // 'tb_jettys.color as jettyColor',
            // 'tb_kapals.*',
            // 'tb_agens.*',
            // 'tb_jettys.*',
            'tb_ppjks.*',
            'tb_dls.*'
          )
          ->orderBy($sidx,$sord)
          ->orderBy('date', 'asc')
          ->get();
          // dd($result);
        // $result = json_encode(json_decode($qu));
        // $result = json_decode($result,true);
        // if ($result['records']>1) $result = $result['rows']; else $result = array();
        // $result = $request->data;
        // print_r ($query);

        $mulai = strtotime($mulai);


        $page = 'backend.oprasional.pdf.'.$request->input('page');
        $nfile = $request->input('file');
        $orientation = 'landscape';

        $view =  \View::make($page, compact('result','mulai'))->render();
      break;
      case 'bstdo-dompdf':
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
        ->orderBy($sidx,$sord)
        ->orderBy('date', 'asc')
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
        // return view($page, compact('result','mulai'));
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
