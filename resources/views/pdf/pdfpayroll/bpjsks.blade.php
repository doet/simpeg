@extends('pdf.mpdf')
@section('content')
			<style type="text/css">
body {
/*	width: 500px;
	margin: 40px auto;
	color: #444;*/
	font-family: :"Arial", Helvetica, sans-serif !important;
	font-size: 11px;

}
    @page { margin: 110px 20px 40px 60px }
    #header { position: fixed; top: -90px; left:-10px; right: -10px; height: 80px; }
    #footer { position: fixed; left: -10px; bottom: -30px; right: -10px; height: 40px; }
    #footer .page:after { content: counter(page, normal); }

table {
    border-collapse: collapse; /* IE7 and lower */
    border-spacing: 0;
	margin-top:10px;
    width: 100%;
	margin-bottom:10px;
	max-height:50px;
	height:40px ;
	font-family :"Arial", Helvetica, sans-serif !important;
	font-size: 9px;
}



.left{
    border-left: 1px solid;
}
.right{
    border-right: 1px solid;
}
.top{
    border-top: 1px solid;
}
.button{
	border-bottom: 1px solid;
}

.zebra tr:nth-child(even) {
     background-color: #f9f9f9;
}
.zebra tr:nth-child(odd) {
     background-color: #DCDCDC;
}

.number {
	text-align:right
}

</style>



<div id="header">
	<img src="{{public_path().'\\pic\\logo.png'}}" width="125px"><div style="position:absolute; top:10; left:100"><b>PT. PELABUHAN CILEGON MANDIRI<br />
SDM & Hukum</b></div>
    <center>Iuran BPJS Kesehatan<br />
	<font size="-1">Priode : {{ $start }} s.d. {{ $end }}</font></center>

</div>


  <div id="footer">
    <p class="page">Page </p>
  </div>

<?php


echo '<table width="690px">
	<tr>
		<th class="left top right" align="center" width="20px" rowspan="2">No</th>
		<th class="left top right" align="center" width="50px" rowspan="2">NIP</th>
		<th class="top right" align="center" rowspan="2">Nama Pegawai</th>
		<th class="top right" align="center" width="55px" rowspan="2">Gaji</th>
		<th class="top right" align="center" width="55px" rowspan="2">Tunjangan Tetap</th>
		<th class="top right" align="center" width="55px" rowspan="2">Total Gaji</th>
		<th class="top right" align="center" width="55px" rowspan="2">Gaji Untuk Perhitungan Iuran</th>
		<th class="top right" align="center" width="55px" colspan="3">Iuran</th>
		<th class="top right" align="center" width="25px" rowspan="2">KLS</th>
	</tr>

	<tr>
		<th class="top right" align="center" width="55px">Perusahaan <br>4%</th>
		<th class="top right" align="center" width="55px">Karyawan <br>1%</th>
		<th class="top right" align="center" width="55px">Total <br>5%</th>
	</tr>';

/*	<tr>
		<td class="left top right" colspan="11" style="background-color: #5BD7FF">Non Shift</td>
	</tr>';*/
	$no=1;
	$headwaktu=0;

	$ttutp=$tjkm=$tjkk=$tjhtk=$tjhtp=$tjpk=$tjpp=0;
	$perusahaan=$karyawan=$tiuran=0;
	foreach ($query as $row) {

		$perusahaan=GajiHelpers::bpjskes($row->id,$start)['perusahaan']+$perusahaan;
		$karyawan=GajiHelpers::bpjskes($row->id,$start)['karyawan']+$karyawan;
		$tiuran=GajiHelpers::bpjskes($row->id,$start)['tiuran']+$tiuran;

		echo '<tr>
				<td class="left top right" align="center"> '.$no.'</td>
				<td class="left top right" align="center"> '.$row->nip.'</td>
				<td class="top right"> &nbsp;'.$row->nama.'</td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::upah($row->id,'pokok',$start)+GajiHelpers::upah($row->id,'honor',$start)).'&nbsp; </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::upah($row->id,'perum',$start)).'&nbsp; </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjskes($row->id,$start)['tgaji']).'&nbsp;  </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjskes($row->id,$start)['itung']).'&nbsp;  </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjskes($row->id,$start)['perusahaan']).'&nbsp;  </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjskes($row->id,$start)['karyawan']).'&nbsp;  </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjskes($row->id,$start)['tiuran']).'&nbsp;  </td>
				<td class="top right" align="center"> '.GajiHelpers::bpjskes($row->id,$start)['kls'].' </td>
			</tr>';

	/*	if ($headwaktu!=$row->wkerja){
			echo'<tr>
					<td class="left top right" colspan="11" style="background-color: #5BD7FF">Shift</td>
				</tr>';
			$headwaktu=1;
		}*/
		$no++;
	}
	echo'<tr>
			<td class="left top right" colspan="11">  </td>
		</tr>';
	echo '<tr>
		<td class="left top right" align="center" colspan="7"> &nbsp;</td>
		<td class="top right" align="right"> '.number_format($perusahaan).'&nbsp;  </td>
		<td class="top right" align="right"> '.number_format($karyawan).'&nbsp;  </td>
		<td class="top right" align="right"> '.number_format($tiuran).'&nbsp;  </td>
		<td class="top right" align="right"> &nbsp;  </td>
	</tr>';

	echo '
		<tr>
			<td class="top" colspan="11"></td>
		</tr>
		</table>
		';
	echo '<table width="800px" border="0" align="right">
		<tr>
		<td align="center" valign="top">Dibuat oleh, <br />
		Spv. SDM & Hukum<br /><br /><br /><br /><br />Fajar Prasetya</td>
		<td align="center" valign="top">Diperiksa oleh, <br />Mgr. SDM & Umum<br />
		<br /><br /><br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table>';
				//echo '<div style="page-break-after: always;"></div>';


?>
&nbsp;<br />
@stop
