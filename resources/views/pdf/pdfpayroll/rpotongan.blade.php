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
    <center>REKAPITULASI POTONGAN GAJI KARYAWAN<br />
	<font size="-1">Priode : {{ $start }} s.d. {{ $end }}</font></center>

</div>


  <div id="footer">
    <p class="page">Page </p>
  </div>

<?php


echo '<table width="1150px">
	<tr>
		<th class="left top right" width="20px" rowspan="2">No</th>
		<th class="top right" rowspan="2">Nama Pegawai</th>
		<th class="top right" colspan="10">Potongan-Potongan</th>
		<th class="top right" width="70px" rowspan="2">Sub Total <br>Potongan</th>
		<th class="top right" width="70px" rowspan="2">Total diterima</th>
		<th class="top right" width="70px" rowspan="2">Pembulatan</th>
	</tr>

	<tr>
		<th class="top right" width="60px">Angsuran BJB</th>
		<th class="top right" width="60px">Kendaraan</th>
		<th class="top right" width="60px">P. Absensi</th>
		<th class="top right" width="60px">PPH-21</th>
		<th class="top right" width="60px">L. BL</th>
		<th class="top right" width="60px">Baziz</th>
		<th class="top right" width="60px">Koprasi</th>
		<th class="top right" width="60px">DPLK</th>
		<th class="top right" width="60px">BPJS<br>Ketena...</th>
		<th class="top right" width="60px">BPJS<br>Kesehatan</th>
	</tr>';
	$no=1;
	$tpb=0;



foreach ($isi as $key=>$value){
	if ($key!='tpembulatan'){
		echo '
		<tr>
			<td class="left top right" align="center"> '.$no.'</td>
			<td class="top right">&nbsp;'.$isi[$key]['nama'].'</td>
			<td class="top right" align="right"> '.$isi[$key]['bjb'].'&nbsp;</td>
			<td class="top right" align="right"> '.$isi[$key]['kendaraan'].'&nbsp;</td>
			<td class="top right" align="right"> '.$isi[$key]['absen'].'&nbsp;</td>
			<td class="top right" align="right"> '.$isi[$key]['pph21'].'&nbsp;</td>
			<td class="top right" align="right"> '.$isi[$key]['lbl'].'&nbsp;</td>
			<td class="top right" align="right"> '.$isi[$key]['baziz'].'&nbsp;</td>
			<td class="top right" align="right"> '.$isi[$key]['tkoperasi'].'&nbsp;</td>
			<td class="top right" align="right"> '.$isi[$key]['dplk'].'&nbsp;</td>
			<td class="top right" align="right"> '.$isi[$key]['bpjsker'].'&nbsp;</td>
			<td class="top right" align="right"> '.$isi[$key]['bpjskes'].'&nbsp;</td>
			<td class="top right" align="right"> '.$isi[$key]['sp'].'&nbsp;</td>
			<td class="top right" align="right"> '.$isi[$key]['terima'].'&nbsp;</td>
			<td class="top right" align="right"> '.$isi[$key]['pembulatan'].'&nbsp;</td>
		</tr>';
		$no++;
	}
}


echo '
	<tr>
		<td class="left top right" align="center"> &nbsp;</td>
		<td class="top right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> '.number_format($isi['tpembulatan']).'&nbsp;</td>
	</tr>';
	echo '
	<tr>
		<th class="top" colspan="15"></th>
	</tr>

	</tabel>';
	//echo memory_get_usage();

				echo '<table width="800px" border="0" align="right">
					<tr>
					<td align="center" valign="top">Diajukan Oleh, <br />
					Spv. SDM & Hukum<br /><br /><br /><br /><br />Fajar Prasetya</td>
					<td align="center" valign="top">Mengetahui, <br />Mgr. SDM & Umum<br />
					<br /><br /><br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table>';
				//echo '<div style="page-break-after: always;"></div>';


?>
&nbsp;<br />
@stop
