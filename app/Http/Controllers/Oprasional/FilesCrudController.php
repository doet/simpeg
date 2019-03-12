<?php

namespace App\Http\Controllers\Oprasional;
date_default_timezone_set('Asia/Jakarta');

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\menuadmins;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

use DB;
use Auth;
use File;

class FilesCrudController extends Controller
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
  public function json(Request $request)
  {
    $datatb = $request->input('datatb','');
    $oper = $request->input('oper','');
    $id = $request->input('id','');
    $cari = $request->input('cari','');


    switch ($datatb) {
        case 'files':
            $tree_data_2['status']="OK" ;
            $i=0;
            if ($id == 0) {
                $tree_data_2['data'][0]['text'] = 'DL';
                $tree_data_2['data'][0]['icon-class'] = "red";
                $tree_data_2['data'][0]['type'] = 'folder';
                $tree_data_2['data'][0]['attr']['id'] = 1;
                $tree_data_2['data'][0]['additionalParameters']['id'] = 1;
                $tree_data_2['data'][0]['additionalParameters']['children'] = true;

                $tree_data_2['data'][1]['text'] = 'LHP';
                $tree_data_2['data'][1]['icon-class'] = "red";
                $tree_data_2['data'][1]['type'] = 'folder';
                $tree_data_2['data'][1]['attr']['id'] = 2;
                $tree_data_2['data'][1]['additionalParameters']['id'] = 2;
                $tree_data_2['data'][1]['additionalParameters']['children'] = true;
            }else{
                // Buka Folder
                // $folder = "./files/oprasional/"; //Sesuaikan Folder nya
                $folder = "./public/files/oprasional"; //Sesuaikan Folder nya
                if(!($buka_folder = opendir($folder))) die ("eRorr... Tidak bisa membuka Folder");

                $file_array = array();
                $filterfile=0;
                while($baca_folder = readdir($buka_folder)){
                    if($id == 1)$filterfile = strpos($baca_folder,"DL"); else $filterfile = strpos($baca_folder,"LHP");
                        if ($filterfile === 0 ) $file_array[] = $baca_folder;
                }

                // print_r ($file_array);


                $jumlah_array = count($file_array);
                for($i=0; $i<$jumlah_array; $i++){
                    $nama_file = $file_array;
                    //echo "$nama_file[$i-2] (". round(filesize($nama_file[$i])/1024,1) . "kb)<br/>";
                    $tree_data_2['data'][$i]['text'] =  '<i class="ace-icon fa fa-file-excel-o blue"></i>'.$nama_file[$i];
                    $tree_data_2['data'][$i]['fname'] =  $nama_file[$i];
                    $tree_data_2['data'][$i]['type'] = 'item';
                }
                closedir($buka_folder);

                if (empty($tree_data_2['data'])){
                  $tree_data_2['data'][$i]['text'] = '.:: Empty ::.';
                  $tree_data_2['data'][$i]['fname'] = '.:: Empty ::.';
                  $tree_data_2['data'][$i]['type'] = 'item';
                };
            }
            return $tree_data_2;
        break;
        case 'prepost':
          $tmp = array();
          $tmp['nfile']=$request->input('fname');
          return $tmp;
        break;
        case 'ReaderFiles':
          return $this->ReadXlsx($request);
        break;
    }
  }

  public function save(Request $request){
    $datatb = $request->input('datatb', '');
    $cari = $request->input('cari', '0');
    $oper = $request->input('oper');
    $id = $request->input('id');

    $path= public_path().'\files\oprasional/';

    switch ($datatb) {
      case 'uploadfiles':

        if(isset($_FILES)){
          $ret = array();

          if (!is_dir($path)) File::makeDirectory($path);
          //print_r($_FILES['file']);
          $fs = $request->file('file');
          $fn = $fs->getClientOriginalName();


          // print_r($path);

          $name = explode('.', $fs->getClientOriginalName());
          if ($name[1]=='xlsx' || $name[1]=='xls'){
              $fileName = $name[0].'-'.strtotime(date('d-m-Y')).'.'.$name[1];
          }

          // $fileName   = $_FILES['file']['name'];
          // $file       = $path.$fileName;

          //simpan file ukuran sebenernya
        //  $realImagesName     = $_FILES["file"]["tmp_name"];
        //  move_uploaded_file($realImagesName, $file);

          $request->file('file')->move($path, $fileName);
        }
      break;

      case 'delfile':
          $fileName = $request->input('fname');
          $file       = $path.$fileName;
          unlink($file);
      break;
      case 'savetodb':
        $data = $this->ReadXlsx($request);
        foreach ($data['isinya'] as $row) {
          $tunda = array();
          // agen
          $agen = DB::table('tb_agens')->where(['code' => $row[2]])->first();

          if(!$agen) $agen['id'] = DB::table('tb_agens')->insertGetId(['code' => $row[2]]); $agen = (object) $agen;

          // kapal
          $kapal = DB::table('tb_kapals')->where(['value' => $row[6]])->first();
          if(!$kapal) $kapal['id'] = DB::table('tb_kapals')->insertGetId([
            'value'   => $row[6],
            'jenis'   => $row[5],
            'grt'     => $row[7],
            'loa'     => $row[8],
            'bendera' => $row[9]
          ]); $kapal = (object) $kapal;

          // dermaga
          $dermaga = DB::table('tb_jettys')->where(['code' => $row[10]])->first();
          if(!$dermaga) $dermaga['id'] = DB::table('tb_jettys')->insertGetId(['code' => $row[10],'value' => $row[11]]); $dermaga = (object) $dermaga;

          $d1 = explode('/', $row[3]);
          if ($row[4]!='SHIFT')$d2 = $row[4];
          $date = '2019-'.$d1[1].'-'.$d1[0].' '.$d2;

          $dateon = '2019-'.$d1[1].'-'.$d1[0].' '.$row[20];
          $dateoff = '2019-'.$d1[1].'-'.$d1[0].' '.$row[21];

          // $tunda = $row[19];
          if ($row[15] != '') array_push($tunda,$row[15]);
          if ($row[16] != '') array_push($tunda,$row[16]);
          if ($row[17] != '') array_push($tunda,$row[17]);
          if ($row[18] != '') array_push($tunda,$row[18]);
          if ($row[19] != '') array_push($tunda,$row[19]);

          // DB::table('tb_dls')->insert([
          //    'ppjk'       => $row[1],
          //    'agens_id'   => $agen->id,
          //    'date'       => strtotime($date),
          //    'kapals_id'  => $kapal->id,
          //    'jetty_id'   => $dermaga->id,
          //    'ops'        => $row[12],
          //    'bapp'       => $row[13],
          //    'pc'         => $row[14],
          //    'tunda'      => json_encode($tunda),
          //    'on'         => strtotime($dateon),
          //    'off'        => strtotime($dateoff),
          //    'dd'         => $row[22],
          //    'ket'        => $row[23],
          //    'kurs'       => $row[24]
          //  ]);
          echo $data['isinya'];
        }
        //return
      break;
    }
  }
  public function ReadXlsx($request){
    $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
    //$reader = ReaderFactory::create(Type::CSV); // for CSV files
    //$reader = ReaderFactory::create(Type::ODS); // for ODS files
    if ($request->input('fname'))$fname = 'oprasional/'.$request->input('fname'); else $fname = 'oprasional/blank.xlsx';
    $reader->open(public_path().'\files\/'.$fname);

    $arrytmp=$tmp=$header=$isinya=array();
    // $tgl=array('No','PPJK','Agen','Waktu','Kapal','GRT','LOA','Bendera','Bendera','Dermaga','Ops','Bapp','PC','Tunda','Waktu','DD','Ket','Kurs');
    // $tgllibur=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
    //
    // $priode=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
    $l=0;
    $tmp['nfile']=$request->input('fname');
    foreach ($reader->getSheetIterator() as $sheet) {
      foreach ($sheet->getRowIterator() as $row) {///row
        if ($l==0){
          for( $i=0 ; $i < count($row) ; $i++ ){
              array_push($header, $row[$i]);
          }
        }else{
          $isinya[$l]=array();
          for( $i=0 ; $i < count($row) ; $i++ ){
            if (is_object($row[$i]) == 'true')$row[$i] = date_format($row[$i], 'H:i');
            array_push($isinya[$l],$row[$i]);
          }
        }
        $l++;
      }
    }
    $tmp['header']=$header;
    $tmp['isinya']=$isinya;
    return $tmp;
  }

  public function chart(Request $request){
    $tmp = array();
    $start = 1567270800;
    $end = 1567702800;
    $day1 = (60 * 60 * 24);

    // ////////////// data dalam range ///////////////////
    // $jetty2 = DB::table('tb_dls')
    //   ->join('tb_jettys', function ($join) {
    //     $join->on('tb_dls.jetty_id', '=', 'tb_jettys.id');
    //   })
    //   ->select('tb_jettys.value as jettyName', 'tb_dls.*')
    //   ->get();
    //
    // foreach ($jetty2 as $row) {
    //   $val[] = $row->jetty_id;
    //   $name[$row->jetty_id] = $row->jettyName;
    // }
    //
    // $countjetty = array_count_values($val); // data jjety dalam 1 bulan
    // // arsort($countjetty);
    // $tmp['countjetty'] = $countjetty;
    // $i= 0;
    // foreach ($countjetty as $key=>$va) {
    //   $tmp['ds'][$i]['backgroundColor'] = ["rgba(105, 0, 132, .2)"];
    //   $tmp['ds'][$i]['borderColor'] = ["rgba(200, 99, 132, .7)"];
    //   $tmp['ds'][$i]['borderWidth'] = 2;
    //   $tmp['ds'][$i]['data'] = [28, 48, 40, 19, 86, 27, 90];
    //   $tmp['ds'][$i]['fill'] = false;
    //   $tmp['ds'][$i]['label'] = $name[$key];
    //   $i++;
    // }
    $i=$n= 0;
    /////////////////////// data harian
    for($start; $start < $end; $start = $start+$day1) {
      ////////////// data dalam 1 tanggal //////////////
      $tmp['label'][] = $start; // ambil tanggal sumbu x

      $jetty = DB::table('tb_dls')
        ->join('tb_jettys', function ($join) {
          $join->on('tb_dls.jetty_id', '=', 'tb_jettys.id');
        })
        ->where(function ($query) use ($start,$day1){
            $query->where('date', '>', $start)
              ->Where('date', '<', $start+$day1);
        })
        ->select('tb_jettys.value as jettyName','tb_jettys.color as jettyColor', 'tb_dls.*')
        ->get();
        $jty=0;
      foreach ($jetty as $row) {
        $jettyname[$row->jetty_id] = $row->jettyName;
        $jettycolor[$row->jetty_id] = $row->jettyColor;
        $subdata[$start][] = $row->jetty_id;
        $subdata2[$row->jetty_id][$n][] = $row->jetty_id;
      }
      $tmp['subdata'][$start] = array_count_values($subdata[$start]); // data jetty dalam satu hari
      $n++;
    }

    foreach ($jettyname as $key=>$jn){
      $jm=0;
      for($il=0; $il < count($tmp['label']); $il++) {
        // if (isset($subdata2[$key][$il])) $hasil[$key][] = array_count_values($subdata2[$key][$il]); else $hasil[$key][] = array($key=>0);
        if (isset($subdata2[$key][$il])) $jm = count($subdata2[$key][$il]); else $jm = 0;
        $tmp['pro'][$key][] = $jm;
      }

      $tmp['ds'][$i]['backgroundColor'] = ["$jettycolor[$key]"];
      $tmp['ds'][$i]['borderColor'] = ["$jettycolor[$key]"];
      $tmp['ds'][$i]['borderWidth'] = 2;
      $tmp['ds'][$i]['data'] = $tmp['pro'][$key];
      $tmp['ds'][$i]['fill'] = false;
      $tmp['ds'][$i]['label'] = $jn;
      $i++;
    }
    // $tmp['hasil'] = $tmp['pro'][1][0][1];
    return $tmp;
  }
}
