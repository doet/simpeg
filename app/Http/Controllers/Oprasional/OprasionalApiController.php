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
          // ->join('tb_agens', function ($join) {
          //   $join->on('tb_dls.agens_id', '=', 'tb_agens.id');
          // })
          // ->join('tb_kapals', function ($join) {
          //   $join->on('tb_dls.kapals_id', '=', 'tb_kapals.id');
          // })
          // ->join('tb_jettys', function ($join) {
          //   $join->on('tb_dls.jetty_id', '=', 'tb_jettys.id');
          // })
          // ->select(
          //   'tb_agens.code as agenCode',
          //   'tb_kapals.value as kapalsName',
          //   'tb_kapals.jenis as kapalsJenis',
          //   'tb_kapals.grt as kapalsGrt',
          //   'tb_kapals.loa as kapalsLoa',
          //   'tb_kapals.bendera as kapalsBendera',
          //   'tb_jettys.name as jettyName',
          //   // 'tb_jettys.color as jettyColor',
          //   'tb_dls.*'
          // )
          ->where('tb_dls.id', $id)
          ->get();
        foreach($query as $row) {
          if ($row->pcon == '')$row->pcon = $row->date;
          if ($row->pcoff == '')$row->pcoff = $row->date;
          $responce['ppjk']=$row->ppjk;
          $responce['agen']=$row->agens_id;
          $responce['date']=date("d-m-Y H:i",$row->date);
          $responce['kapal']=$row->kapals_id;
          $responce['dermaga']=$row->jetty_id;
          $responce['ops']=$row->ops;
          $responce['bapp']=$row->bapp;
          $responce['pc']=$row->pc;
          $responce['pcon']=date("d/m/y H:i",$row->pcon);
          $responce['pcoff']=date("d/m/y H:i",$row->pcoff);
          $responce['tunda']=json_decode($row->tunda);
          $responce['tundaon']=date("d/m/y H:i",$row->tundaon);
          $responce['tundaoff']=date("d/m/y H:i",$row->tundaoff);
          $responce['dd']=$row->dd;
          $responce['ket']=$row->ket;
          $responce['kurs']=$row->kurs;
        }
      break;
      case 'agen':
        $query = DB::table('tb_agens')
        ->get();
        foreach($query as $row) {
          $responce[$row->id]=$row->code;
        }
      break;
      case 'kapal':
        $query = DB::table('tb_kapals')
        ->get();
        foreach($query as $row) {
          $responce[$row->id]=$row->value;
        }
      break;
      case 'dermaga':
        $query = DB::table('tb_jettys')
          ->get();
        foreach($query as $row) {
          $responce[$row->id]=$row->name;
        }
      break;
      case 'ppjk':
        $lhp_date = $request->input('lhp_date', '');
        $query = DB::table('tb_dls')
          ->where(function ($query) use ($lhp_date){
              $lhp_date = strtotime($lhp_date);
              // $akhir = strtotime($akhir);
              // if($akhir==0)$akhir = $mulai+(60 * 60 * 24);
              // $query->where('date', '>=', $mulai)
              //   ->Where('date', '<=', $akhir);
              $query->where('lhp_date','')
                ->orWhere('lhp_date',$lhp_date)
                ->orWhere('lhp_date',null);
          })
          ->get();
        foreach($query as $row) {
          $responce['items'][$row->ppjk]=$row->ppjk;
          if ($row->lhp_date != '')$responce['selected'][$row->ppjk]='selected'; else $responce['selected'][$row->ppjk]='';
        }
        unset($responce['items'][null]);
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
          ->where('name','like',$cari.'%')
          ->orderBy('name', 'asc')
          ->get();
        $i=0;
        $value_n='';
        foreach($query as $row) {
          if ($row->name != $value_n){
            // $responce[$i] = '('.$row->jenis.') '.$row->value;
            $responce[$i] = $row->name;
            $i++;
            $value_n=$row->name;
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

        $date = strtotime($request->input('date',''));
        // $d = explode(" ",$date);

        if($request->input('tunda') !== ''){
          $tunda = $request->input('tunda');
          $t = explode(",",$tunda);
          $tunda = array();
          foreach($t as $row) {
            array_push($tunda, $row);
          }
          $tunda = json_encode($tunda);
        }

        if ($oper!='del'){
          $pcdate = str_replace('-', ',', $request->input('pcdate',''));
          $pcdate = str_replace('/', '-', $pcdate);
          $pcdate = explode(',',$pcdate);

          $tundadate = str_replace('-', ',', $request->input('tundadate',''));
          $tundadate = str_replace('/', '-', $tundadate);
          $tundadate = explode(',',$tundadate);

          if ($request->input('lstp','') || $request->input('moring','') ){
            $datanya=array(
              'lstp'=>$request->input('lstp',''),
              'moring'=>$request->input('moring',''),
            );
          } else {

            $datanya=array(
              'ppjk'=>$request->input('ppjk'),
              'agens_id'=>$request->input('agen',''),
              'date'=>$date,
              'kapals_id'=>$request->input('kapal',''),
              'jetty_id'=>$request->input('dermaga',''),
              'ops'=>$request->input('ops',''),
              'bapp'=>$request->input('bapp',''),
              'pc'=>$request->input('pc',''),
              'pcon'=>strtotime(date($pcdate[0])),
              'pcoff'=>strtotime(date(ltrim($pcdate[1]," "))),
              'tunda'=>$tunda,
              'tundaon'=>strtotime($tundadate[0]),
              'tundaoff'=>strtotime(ltrim($tundadate[1]," ")),
              'dd'=>$request->input('dd',''),
              'ket'=>$request->input('ket',''),
              'kurs'=>$request->input('kurs','')
            );
          }
        }

        if ($oper=='add')DB::table('tb_dls')->insert($datanya);
        if ($oper=='edit')DB::table('tb_dls')->where('id', $id)->update($datanya);
        if ($oper=='del')DB::table('tb_dls')->delete($id);

        $responce = array(
          'status' => $pcdate,
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
      case 'magen':
        $datanya=array(
          'code'=>$request->input('code',''),
          'name'=>$request->input('name',''),
          'alamat'=>$request->input('alamat',''),
          'user'=>$request->input('user',''),
          'tlp'=>$request->input('tlp',''),
          'npwp'=>$request->input('npwp',''),
          'ket'=>$request->input('ket',''),
        );

        if ($oper=='add')DB::table('tb_agens')->insert($datanya);
        if ($oper=='edit')DB::table('tb_agens')->where('id', $id)->update($datanya);
        if ($oper=='del')DB::table('tb_agens')->delete($id);

        $responce = array(
          'status' => $datanya,
          //"suscces",
          'msg' => 'ok',
        );
      break;
      case 'mpc':
        $datanya=array(
          'code'=>$request->input('code',''),
          'name'=>$request->input('name',''),
        );

        if ($oper=='add')DB::table('tb_pcs')->insert($datanya);
        if ($oper=='edit')DB::table('tb_pcs')->where('id', $id)->update($datanya);
        if ($oper=='del')DB::table('tb_pcs')->delete($id);

        $responce = array(
          'status' => $datanya,
          //"suscces",
          'msg' => 'ok',
        );
      break;
      case 'mdermaga':
        $datanya=array(
          'code'=>$request->input('code',''),
          'name'=>$request->input('name',''),
          'ket'=>$request->input('ket',''),
        );

        if ($oper=='add')DB::table('tb_jettys')->insert($datanya);
        if ($oper=='edit')DB::table('tb_jettys')->where('id', $id)->update($datanya);
        if ($oper=='del')DB::table('tb_jettys')->delete($id);

        $responce = array(
          'status' => $datanya,
          //"suscces",
          'msg' => 'ok',
        );
      break;
      case 'mmooring':
        $datanya=array(
          'code'=>$request->input('code',''),
          'name'=>$request->input('name',''),
          'alamat'=>$request->input('alamat',''),
          'user'=>$request->input('user',''),
          'tlp'=>$request->input('tlp',''),
          'npwp'=>$request->input('npwp',''),
        );

        if ($oper=='add')DB::table('tb_moorings')->insert($datanya);
        if ($oper=='edit')DB::table('tb_moorings')->where('id', $id)->update($datanya);
        if ($oper=='del')DB::table('tb_moorings')->delete($id);

        $responce = array(
          'status' => $datanya,
          //"suscces",
          'msg' => 'ok',
        );
      break;

      case 'lhp':
        if ($request->input('checked','') == 'true')$lhp = strtotime($request->input('lhp_date','')); else $lhp = '';
        $datanya=array(
          'lhp_date'=>$lhp,
        );
        DB::table('tb_dls')->where('ppjk', $request->input('ppjk',''))->update($datanya);

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
                  ->Where('date', '<=', $akhir);
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
            );
        break;
        case 'lhp':   // Vaariabel Master
          $qu = DB::table('tb_dls')
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
                // if($akhir==0)$akhir = $mulai+(60 * 60 * 24);
                // $query->where('date', '>=', $mulai)
                //   ->Where('date', '<=', $akhir);

                // $query->where('lhp_date', '!=', '');
                $query->where('lhp_date', $mulai);

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
            );
        break;
        case 'mkapal':
          $qu = DB::table('tb_kapals');
        break;
        case 'magen':
          $qu = DB::table('tb_agens');
        break;
        case 'mpc':
          $qu = DB::table('tb_pcs');
        break;
        case 'mdermaga':
          $qu = DB::table('tb_jettys');
        break;
        case 'mmooring':
          $qu = DB::table('tb_moorings');
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
            if ($row->kapalsJenis == '') $kapal =  $row->kapalsName; else $kapal = '('.$row->kapalsJenis.') '.$row->kapalsName;
            if ($row->tundaon == '') $tundaon=$row->tundaon; else $tundaon=date("H:i",$row->tundaon);
            if ($row->tundaoff == '') $tundaoff=$row->tundaon; else $tundaoff=date("H:i",$row->tundaoff);

            if (is_numeric($row->kapalsGrt))$grt =  number_format($row->kapalsGrt); else $grt = $row->kapalsGrt;
            if (is_numeric($row->kapalsLoa))$loa =  number_format($row->kapalsLoa); else $loa = $row->kapalsLoa;

            $responce['rows'][$i]['id'] = $row->id;
            $responce['rows'][$i]['cell'] = array(
              $row->id,
              $row->ppjk,
              $row->agenCode,
              date("d-m-Y H:i",$row->date),
              $kapal,
              $grt,
              $loa,
              $row->kapalsBendera,
              '('. $row->jettyCode .')'.$row->jettyName,
              $row->ops,
              $row->bapp,
              $row->pc,
              $row->tunda,
              $tundaon,
              $tundaoff,
              $row->dd,
              $row->ket,
              $row->kurs,
            );
            $i++;
          break;
          case 'lhp':   // Variabel Master
            if ($row->kapalsJenis == '') $kapal =  $row->kapalsName; else $kapal = '('.$row->kapalsJenis.') '.$row->kapalsName;
            if ($row->tundaon == '') $tundaon=$row->tundaon; else $tundaon=date("H:i",$row->tundaon);
            if ($row->tundaoff == '') $tundaoff=$row->tundaon; else $tundaoff=date("H:i",$row->tundaoff);

            if (is_numeric($row->kapalsGrt))$grt =  number_format($row->kapalsGrt); else $grt = $row->kapalsGrt;
            if (is_numeric($row->kapalsLoa))$loa =  number_format($row->kapalsLoa); else $loa = $row->kapalsLoa;

            $responce['rows'][$i]['id'] = $row->id;
            $responce['rows'][$i]['cell'] = array(
              $row->id,
              $row->ppjk,
              $row->agenCode,
              date("d-m-Y H:i",$row->date),
              $kapal,
              $grt,
              $loa,
              $row->kapalsBendera,
              '('. $row->jettyCode .')'.$row->jettyName,
              $row->ops,
              $row->bapp,
              $row->pc,
              $row->tunda,
              $tundaon,
              $tundaoff,
              $row->dd,
              $row->ket,
              $row->kurs,
              $row->lstp,
              $row->moring
            );
            $i++;
          break;
          case 'mkapal':   // Variabel Master
            if (is_numeric($row->grt))$grt =  number_format($row->grt); else $grt = $row->grt;
            if (is_numeric($row->loa))$loa =  number_format($row->loa); else $loa = $row->loa;
            $responce['rows'][$i]['id'] = $row->id;
            $responce['rows'][$i]['cell'] = array(
              // $i+1,
              $row->id,
              $row->value,
              $row->bendera,
              $row->jenis,
              $grt,
              $loa
            );
            $i++;
          break;
          case 'magen':   // Variabel Master
            $responce['rows'][$i]['id'] = $row->id;
            $responce['rows'][$i]['cell'] = array(
              // $i+1,
              $row->id,
              $row->code,
              $row->name,
              $row->alamat,
              $row->user,
              $row->tlp,
              $row->npwp,
              $row->ket,
            );
            $i++;
          break;
          case 'mpc':   // Variabel Master
            $responce['rows'][$i]['id'] = $row->id;
            $responce['rows'][$i]['cell'] = array(
              // $i+1,
              $row->id,
              $row->code,
              $row->name,
            );
            $i++;
          break;
          case 'mdermaga':   // Variabel Master
            $responce['rows'][$i]['id'] = $row->id;
            $responce['rows'][$i]['cell'] = array(
              // $i+1,
              $row->id,
              $row->code,
              $row->name,
              $row->ket,
            );
            $i++;
          break;
          case 'mmooring':   // Variabel Master
            $responce['rows'][$i]['id'] = $row->id;
            $responce['rows'][$i]['cell'] = array(
              // $i+1,
              $row->id,
              $row->code,
              $row->name,
              $row->alamat,
              $row->user,
              $row->tlp,
              $row->npwp,
            );
            $i++;
          break;
        }
      }
      if(!isset($responce['rows'])){
        $responce['rows'][0]['id'] = '';
        $responce['rows'][0]['cell']=array('');
      }
      // print_r(empty($responce['rows']));
      // $responce['tambah'] = strtotime($mulai);
      return  Response()->json($responce);
  }
}
