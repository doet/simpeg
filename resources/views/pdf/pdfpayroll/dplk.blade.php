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
    <center>Iuran DPLK Bank Jabar<br />
	<font size="-1">Priode : {{ $start }} s.d. {{ $end }} </font></center>

</div>


  <div id="footer">
    <p class="page">Page </p>
  </div>

<?php

echo '<table width="690px">
	<tr>
		<th class="left top right" width="20px" rowspan="2" align="center">No</th>
		<th class="left top right" width="60px" rowspan="2" align="center">NIK</th>
		<th class="top right" rowspan="2" align="center">Nama</th>
		<th class="top right" width="70px" rowspan="2" align="center">Gaji Pokok</th>
		<th class="top right" width="70px" rowspan="2" align="center">DPLK (15% x GP)</th>
		<th class="top right" width="70px" colspan="2" align="center">Sumber Tanggungan Iuran</th>
		<th class="top right" width="70px" rowspan="2" align="center">Total Iuran DPLK</th>
	</tr>
	<tr>
		<th class="top right" width="70px" align="center">Karyawan 40%</th>
		<th class="top right" width="70px" align="center">Perusahaan 60%</th>
	</tr>
	<tr>
		<td class="left top right" colspan="8" align="center"><b>Transfer Iuran ke Rekening Nomor : 0002197360001 atas nama DPLK BANK JABAR</b></td>
	</tr>';/*
	<tr>
		<td class="left top right" colspan="6" style="background-color: #5BD7FF">Non Shift</td>
	</tr>';*/
	$no=1;
	$headwaktu=$tstoran=$pembulatan=0;

	$tgaji=0;
	$ttdplk=0;
	$tdplk40=0;
	$tdplk60=0;

	foreach ($query as $row){
		$tgaji=GajiHelpers::upah($row->id,'pokok',$start)+$tgaji;
		$ttdplk=GajiHelpers::dplk($row->id,$start)['dplk']+$ttdplk;
		$tdplk40=GajiHelpers::dplk($row->id,$start)['karyawan']+$tdplk40;
		$tdplk60=GajiHelpers::dplk($row->id,$start)['perusahaan']+$tdplk60;

		echo '<tr>
				<td class="left top right" align="center"> '.$no.'</td>
				<td class="left top right" align="center"> '.$row->nip.'</td>
				<td class="top right"> &nbsp;'.$row->nama.'</td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::upah($row->id,'pokok',$start)+GajiHelpers::upah($row->id,'honor',$start)).'&nbsp; </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::dplk($row->id,$start)['dplk']).'&nbsp; </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::dplk($row->id,$start)['karyawan']).'&nbsp;  </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::dplk($row->id,$start)['perusahaan']).'&nbsp;  </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::dplk($row->id,$start)['total']).'&nbsp;  </td>
			</tr>';
		$tstoran=$tstoran+GajiHelpers::baziz($row->id,$start)['total'];
		$no++;
	}
	echo'<tr>
		<td class="left top right" colspan="8"></td>
	</tr>';
	echo '<tr>
		<td class="left top right" align="center"> &nbsp; </td>
		<td class="left top right" align="center" colspan="2"><b> Total : </b></td>
		<td class="top right" align="right"><b> '.number_format($tgaji).'&nbsp; </b></td>
		<td class="top right" align="right"><b> '.number_format($ttdplk).'&nbsp; </b></td>
		<td class="top right" align="right"><b> '.number_format($tdplk40).'&nbsp;  </b></td>
		<td class="top right" align="right"><b> '.number_format($tdplk60).'&nbsp;  </b></td>
		<td class="top right" align="right"><b> '.number_format($tdplk40+$tdplk60).'&nbsp;  </b></td>
	</tr>';
	$v1=substr(round($tdplk40+$tdplk60),-2);
	if ($v1!=00)$pembulatan=round($tdplk40+$tdplk60)+100-$v1; else $pembulatan=$tdplk40+$tdplk60;
	echo '<tr>
		<td class="left top right" align="center"> &nbsp; </td>
		<td class="left top right" align="center" colspan="6"> Pembulatan : &nbsp; </td>
		<td class="top right" align="right"><b> '.number_format($pembulatan).'&nbsp;</b></td>
	</tr>';
	echo '<tr>
		<td class="left top right" align="center"> &nbsp; </td>
		<td class="top right" align="center" colspan="7"><b> Terbilang : #'.terbilang($tdplk40+$tdplk60).' # &nbsp;  </b></td>
	</tr>';

	echo '
	<tr>
		<td class="top" colspan="8"></td>
	</tr>';

	echo '</table>';
	echo '<table width="800px" border="0" align="right">
		<tr>
		<td align="center" valign="top">Dibuat oleh, <br />
		Spv. SDM & Hukum<br /><br /><br /><br /><br />Fajar Prasetya</td>
		<td align="center" valign="top">Diperiksa oleh, <br />Mgr. SDM & Umum<br />
		<br /><br /><br /><br />Herny Setiawanti</td></tr></table>';
				//echo '<div style="page-break-after: always;"></div>';

	function Terbilang($x)
	{
		$abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		if ($x < 12)
		return " " . $abil[$x];
		elseif ($x < 20)
    	return Terbilang($x - 10) . "Belas";
  		elseif ($x < 100)
    	return Terbilang($x / 10) . " Puluh" . Terbilang($x % 10);
  		elseif ($x < 200)
    	return " Seratus" . Terbilang($x - 100);
  		elseif ($x < 1000)
    	return Terbilang($x / 100) . " Ratus" . Terbilang($x % 100);
  		elseif ($x < 2000)
    	return " Seribu" . Terbilang($x - 1000);
  		elseif ($x < 1000000)
    	return Terbilang($x / 1000) . " Ribu" . Terbilang($x % 1000);
  		elseif ($x < 1000000000)
    	return Terbilang($x / 1000000) . " Juta" . Terbilang($x % 1000000);
	}
?>

@stop
