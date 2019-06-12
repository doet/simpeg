<?php

namespace App\Http\Controllers\Oprasional;
date_default_timezone_set('Asia/Jakarta');

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

use App\Models\pegawai;
use DB;
use File;

class XlsOprasionalController extends Controller
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
        $multilevel = menuadmin::get_data();
        $aktif_menu = menuadmin::aktif_menu();
        return view('backend.dashboard', compact('multilevel','aktif_menu'));
    }

    public function XLSMarker(Request $request){
      $mulai = $request->input('start', '0');
      $akhir = $request->input('end', '0');

      $writer = WriterFactory::create(Type::XLSX); // for XLSX files
      //$writer = WriterFactory::create(Type::CSV); // for CSV files
      //$writer = WriterFactory::create(Type::ODS); // for ODS files
      $old_path = public_path().'\\files\\blank.xlsx';
      $new_path = public_path().'\\files\\tmp\\data_ppjk.xlsx';
      File::copy($old_path, $new_path);

      $filePath = public_path().'\\files\\tmp\\data_ppjk.xlsx';
      $writer->openToFile($filePath); // write data to a file or to a PHP stream
      //$writer->openToBrowser($fileName); // stream data directly to the browser

      $query = DB::table('tb_ppjks')
        ->leftJoin('tb_agens', function ($join) {
          $join->on('tb_ppjks.agens_id', '=', 'tb_agens.id');
        })
        ->leftJoin('tb_kapals', function ($join) {
          $join->on('tb_ppjks.kapals_id', '=', 'tb_kapals.id');
        })
        ->leftJoin('tb_jettys', function ($join) {
          $join->on('tb_ppjks.jettys_idx', '=', 'tb_jettys.id');
        })
        ->where(function ($query) use ($mulai,$akhir){
            $mulai = strtotime($mulai);
            $akhir = strtotime($akhir);
            if($akhir==0)$akhir = $mulai+(60 * 60 * 24);
            $query->where('date_issue', '>=', $mulai)
              ->Where('date_issue', '<', $akhir);
        })
        ->select(
          'tb_agens.code as agenCode',
          'tb_kapals.name as kapalsName',
          'tb_jettys.code as jettyCode',
          'tb_jettys.name as jettyName',
          'tb_ppjks.*'
        )
        ->orderBy('date_issue', 'asc')
        ->get();

      //$singleRow = array(0,0,0);
      $i=0;
      $multipleRows[$i] = array('No','date','ppjk','agen','kapal','jetty','eta','etd','asal','tujuan','etmal','cargo','muatan');

      foreach ($query as $row) {
        $i++;
        $multipleRows[$i] = array($i,date("d/m/Y",$row->date_issue),$row->ppjk,$row->agenCode,$row->kapalsName,$row->jettyName,date("d/m/Y H:i",$row->eta),date("d/m/Y H:i",$row->etd),$row->asal,$row->tujuan,$row->etmal,$row->cargo,$row->muat);
      }


      //$writer->addRow($singleRow); // add a row at a time
      $writer->addRows($multipleRows); // add multiple rows at a time

      $writer->close();

      $response = array(
          'status' => 'success',
          'msg' => 'ok',
      );
      return Response()->json($response);
    }

}
