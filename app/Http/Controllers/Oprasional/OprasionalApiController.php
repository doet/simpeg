<?php

namespace App\Http\Controllers\Oprasional;
date_default_timezone_set('Asia/Jakarta');

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;

class OprasionalApiController extends Controller
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
  // * Show the application dashboard.
  // *
  // * @return \Illuminate\Http\Response
  // */
  public function json(Request $request){
    $datatb = $request->input('datatb', '');
    $id = $request->input('iddata', '');
    switch ($datatb) {
      case 'loadlaporan':
        $query = DB::table('tb_dls')
          ->join('tb_agens', function ($join) {
            $join->on('tb_dls.agens_id', '=', 'tb_agens.id');
          })
          ->join('tb_kapals', function ($join) {
            $join->on('tb_dls.kapals_id', '=', 'tb_kapals.id');
          })
          ->join('tb_jettys', function ($join) {
            $join->on('tb_dls.jetty_id', '=', 'tb_jettys.id');
          })
          ->select(
            'tb_agens.code as agenCode',
            'tb_kapals.value as kapalsName',
            'tb_kapals.jenis as kapalsJenis',
            'tb_kapals.grt as kapalsGrt',
            'tb_kapals.loa as kapalsLoa',
            'tb_kapals.bendera as kapalsBendera',
            'tb_jettys.value as jettyName',
            // 'tb_jettys.color as jettyColor',
            'tb_dls.*'
          )
          ->where('tb_dls.id', $id)
          ->get();
        foreach($query as $row) {
          $responce['ppjk']=$row->ppjk;
          $responce['agen']=$row->agenCode;
          $responce['date']=date("d-m-Y H:i",$row->date);
          $responce['kapal']=$row->kapalsName;
          $responce['dermaga']=$row->jetty_id;
          $responce['ops']=$row->ops;
          $responce['bapp']=$row->bapp;
          $responce['pc']=$row->pc;
          $responce['tunda']=json_decode($row->tunda);
          $responce['on']=date("H:i",$row->on);
          $responce['off']=date("H:i",$row->off);
          $responce['dd']=$row->dd;
          $responce['ket']=$row->ket;
          $responce['kurs']=$row->kurs;
        }
      break;
      case 'dermaga':
        $query = DB::table('tb_jettys')
          ->get();
        foreach($query as $row) {
          $responce[$row->id]=$row->value;
        }
      break;
    }
    return  Response()->json($responce);
  }

  public function autoc(Request $request){
    $datatb = $request->input('datatb', '');

    switch ($datatb) {
      case 'agen':
        $cari = $request->input('cari');
        $query = DB::table('tb_agens')
          // ->distinct('code')
          ->where('code','like',$cari.'%')
          ->orderBy('code', 'asc')
          ->get();
        $i=0;
        $value_n='';
        foreach($query as $row) {
          if ($row->code != $value_n){
            $responce[$i] = $row->code;
            $i++;
            $value_n=$row->code;
          }
        }
        if(empty($responce))$responce[0]='Null';
      break;
      case 'kapal':
        $cari = $request->input('cari');
        $query = DB::table('tb_kapals')
          // ->distinct('code')
          ->where('value','like',$cari.'%')
          ->orderBy('value', 'asc')
          ->get();
        $i=0;
        $value_n='';
        foreach($query as $row) {
          if ($row->value != $value_n){
            // $responce[$i] = '('.$row->jenis.') '.$row->value;
            $responce[$i] = $row->value;
            $i++;
            $value_n=$row->value;
          }
        }
        if(empty($responce))$responce[0]='Null';
      break;
      case 'dermaga':
        $cari = $request->input('cari');
        $query = DB::table('tb_jettys')
          // ->distinct('code')
          ->where('value','like',$cari.'%')
          ->orderBy('value', 'asc')
          ->get();
        $i=0;
        $value_n='';
        foreach($query as $row) {
          if ($row->value != $value_n){
            // $responce[$i] = '('.$row->jenis.') '.$row->value;
            $responce[$i] = $row->value;
            $i++;
            $value_n=$row->value;
          }
        }
        if(empty($responce))$responce[0]='Null';
      break;
    }
    return  Response()->json($responce);
  }

  public function cud(Request $request){
    $datatb = $request->input('datatb', '');
    $oper = $request->input('oper','');
    $id = $request->input('id');

    switch ($datatb) {
      case 'dl':

        $agen = DB::table('tb_agens')
          ->where(function ($query) use ($request){
              $query->where('code',$request->input('agen'));
          })->first();
        if (!isset($agen)){$agen = '{"id":""}'; $agen = json_decode($agen);}

        $kapal = DB::table('tb_kapals')
          ->where(function ($query) use ($request){
              $query->where('value',$request->input('kapal'));
          })->first();
        if (!isset($kapal)){$kapal = '{"id":""}'; $kapal = json_decode($kapal);}

        $date = $request->input('date');
        $d = explode(" ",$date);

        if($request->input('tunda') !== ''){
          $tunda = $request->input('tunda');
          $t = explode(",",$tunda);
          $tunda = array();
          foreach($t as $row) {
            array_push($tunda, $row);
          }
          $tunda = json_encode($tunda);
        }

        $datanya=array(
          'ppjk'=>$request->input('ppjk'),
          'agens_id'=>$agen->id,
          'date'=>strtotime($date),
          'kapals_id'=>$kapal->id,
          'jetty_id'=>$request->input('dermaga',''),
          'ops'=>$request->input('ops',''),
          'bapp'=>$request->input('bapp',''),
          'pc'=>$request->input('pc',''),
          'tunda'=>$tunda,
          'on'=>strtotime($d[0].' '.$request->input('on','')),
          'off'=>strtotime($d[0].' '.$request->input('off','')),
          'dd'=>$request->input('dd',''),
          'ket'=>$request->input('ket',''),
          'kurs'=>$request->input('kurs',''),
        );

        if ($oper=='add')DB::table('tb_dls')->insert($datanya);
        if ($oper=='edit')DB::table('tb_dls')->where('id', $id)->update($datanya);
        if ($oper=='del')DB::table('tb_dls')->delete($id);

        $responce = array(
          'status' => $datanya,
          //"suscces",
          'msg' => 'ok',
        );
      break;
      case 'mkapal':
        $datanya=array(
          'value'=>$request->input('value',''),
          'jenis'=>$request->input('jenis',''),
          'grt'=>$request->input('grt',''),
          'loa'=>$request->input('loa',''),
          'bendera'=>$request->input('bendera',''),
        );

        if ($oper=='add')DB::table('tb_kapals')->insert($datanya);
        if ($oper=='edit')DB::table('tb_kapals')->where('id', $id)->update($datanya);
        if ($oper=='del')DB::table('tb_kapals')->delete($id);

        $responce = array(
          'status' => $datanya,
          //"suscces",
          'msg' => 'ok',
        );
      break;
    }

    return  Response()->json($responce);
  }
  public function jqgrid(Request $request){

      $datatb = $request->input('datatb', '');
      $cari = $request->input('cari', '0');

      $page = $request->input('page', '1');
      $limit = $request->input('rows', '10');
      $sord = $request->input('sord', 'asc');
      $sidx = $request->input('sidx', 'id');

      $mulai = $request->input('start', '0');
      $akhir = $request->input('end', '0');
      switch ($datatb) {
        case 'dl':   // Vaariabel Master
          $qu = DB::table('tb_dls')
            ->join('tb_agens', function ($join) {
              $join->on('tb_dls.agens_id', '=', 'tb_agens.id');
            })
            ->join('tb_kapals', function ($join) {
              $join->on('tb_dls.kapals_id', '=', 'tb_kapals.id');
            })
            ->join('tb_jettys', function ($join) {
              $join->on('tb_dls.jetty_id', '=', 'tb_jettys.id');
            })
            ->where(function ($query) use ($mulai,$akhir){
                $mulai = strtotime($mulai);
                $akhir = strtotime($akhir);
                if($akhir==0)$akhir = $mulai+(60 * 60 * 24);
                $query->where('date', '>=', $mulai)
                  ->Where('date', '<=', $akhir);
            })
            ->select(
              'tb_agens.code as agenCode',
              'tb_kapals.value as kapalsName',
              'tb_kapals.jenis as kapalsJenis',
              'tb_kapals.grt as kapalsGrt',
              'tb_kapals.loa as kapalsLoa',
              'tb_kapals.bendera as kapalsBendera',
              'tb_jettys.value as jettyName',
              'tb_jettys.code as jettyCode',
              // 'tb_jettys.color as jettyColor',
              'tb_dls.*'
            );
        break;
        case 'mkapal':
          $qu = DB::table('tb_kapals');
        break;
      }
      $count = $qu->count();

      if( $count > 0 ) {
        $total_pages = ceil($count/$limit);    //calculating total number of pages
      } else {
        $total_pages = 0;
      }

      if ($page > $total_pages) $page=$total_pages;
      $start = $limit*$page - $limit; // do not put $limit*($page - 1)
      $start = ($start<0)?0:$start;  // make sure that $start is not a negative value

      $responce['page'] = $page;
      $responce['total'] = $total_pages;
      $responce['records'] = $count;

  // Mengambil Nilai Query //
      $query = $qu->orderBy($sidx, $sord)
        ->skip($start)->take($limit)
        ->get();

      $i=0;
      foreach($query as $row) {
        switch ($datatb) {
          case 'dl':   // Variabel Master
            $responce['rows'][$i]['id'] = $row->id;
            $responce['rows'][$i]['cell'] = array(
              $row->id,
              $row->ppjk,
              $row->agenCode,
              date("d-m-Y H:i",$row->date),
              '('.$row->kapalsJenis.') '.$row->kapalsName,
              $row->kapalsGrt,
              $row->kapalsLoa,
              $row->kapalsBendera,
              '('. $row->jettyCode .')'.$row->jettyName,
              $row->ops,
              $row->bapp,
              $row->pc,
              $row->tunda,
              date("H:i",$row->on),
              date("H:i",$row->off),
              $row->dd,
              $row->ket,
              $row->kurs,
            );
            $i++;
          break;
          case 'mkapal':   // Variabel Master
            $responce['rows'][$i]['id'] = $row->id;
            $responce['rows'][$i]['cell'] = array(
              $i+1,
              $row->value,
              $row->bendera,
              $row->jenis,
              $row->grt,
              $row->loa,
            );
            $i++;
          break;
        }
      }
      return  Response()->json($responce);
  }
}
