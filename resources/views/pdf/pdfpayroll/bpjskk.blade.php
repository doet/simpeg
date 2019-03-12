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
    <center>Iuran BPJS Ketenaga Kerjaan<br />
	<font size="-1">Priode : {{ $start }} s.d. {{ $end }} </font></center>

</div>


  <div id="footer">
    <p class="page">Page </p>
  </div>

<?php

echo '<table width="690px">
	<tr>
		<th class="left top right" width="20px" rowspan="3" align="center">No</th>
		<th class="left top right" width="50px" rowspan="3" align="center">KPJ</th>
		<th class="top right" rowspan="3" align="center">Nama</th>
		<th class="top right" width="55px" rowspan="3" align="center">Total Upah dan tunjangan tetap</th>
		<th class="top right" width="55px" colspan="6" align="center">RINCIAN IURAN (Rp)</th>
		<th class="top right" width="55px" rowspan="3" align="center">Total Iuran<br>9.89%</th>
	</tr>

	<tr>
		<th class="top right" width="55px" rowspan="2" align="center">JKM <br>0.30%</th>
		<th class="top right" width="55px" rowspan="2" align="center">JKK <br>0.89%</th>
		<th class="top right" width="55px" colspan="2" align="center">JHT</th>
		<th class="top right" width="55px" colspan="2" align="center">JP</th>
	</tr>

	<tr>
		<th class="top right" width="55px" align="center">Karyawan <br>2.00%</th>
		<th class="top right" width="55px" align="center">Perusahaan <br>3.70%</th>
		<th class="top right" width="55px" align="center">Karyawan <br>1.00%</th>
		<th class="top right" width="55px" align="center">Perusahaan <br>2.00%</th>
	</tr>';

	$no=1;
	$headwaktu=0;

	$ttutp=$tjkm=$tjkk=$tjhtk=$tjhtp=$tjpk=$tjpp=$total=0;

	foreach ($query as $row){
		$ttutp 	= GajiHelpers::bpjsker($row->id,$start,$end)['ttunjangan']+$ttutp;
		$tjkm 	= GajiHelpers::bpjsker($row->id,$start,$end)['jkm']+$tjkm;
		$tjkk 	= GajiHelpers::bpjsker($row->id,$start,$end)['jkk']+$tjkk;
		$tjhtk 	= GajiHelpers::bpjsker($row->id,$start,$end)['jhtk']+$tjhtk;
		$tjhtp 	= GajiHelpers::bpjsker($row->id,$start,$end)['jhtp']+$tjhtp;
		$tjpk 	= GajiHelpers::bpjsker($row->id,$start,$end)['jpk']+$tjpk;
		$tjpp 	= GajiHelpers::bpjsker($row->id,$start,$end)['jpp']+$tjpp;
		$total 	= $tjkm+$tjkk+$tjhtk+$tjhtp+$tjpk+$tjpp;
		echo '<tr>
				<td class="left top right" align="center"> '.$no.'</td>
				<td class="left top right" align="center"> &nbsp; </td>
				<td class="top right"> &nbsp;'.$row->nama.'</td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjsker($row->id,$start,$end)['ttunjangan']).'&nbsp; </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjsker($row->id,$start,$end)['jkm']).'&nbsp; </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjsker($row->id,$start,$end)['jkk']).'&nbsp;  </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjsker($row->id,$start,$end)['jhtk']).'&nbsp;  </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjsker($row->id,$start,$end)['jhtp']).'&nbsp;  </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjsker($row->id,$start,$end)['jpk']).'&nbsp;  </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjsker($row->id,$start,$end)['jpp']).'&nbsp;  </td>
				<td class="top right" align="right"> '.number_format(GajiHelpers::bpjsker($row->id,$start,$end)['tbpjskk']).'&nbsp;</td>
			</tr>';
		$no++;
	}
	echo'<tr>
			<td class="left top right" colspan="11">  </td>
		</tr>';
	echo '<tr>
		<td class="left top right"> &nbsp;</td>
		<td class="left top right" colspan="2" align="center"> Total</td>
		<td class="top right" align="right"> '.number_format($ttutp).'&nbsp;</td>
		<td class="top right" align="right"> '.number_format($tjkm).'&nbsp;</td>
		<td class="top right" align="right"> '.number_format($tjkk).'&nbsp;</td>
		<td class="top right" align="right"> '.number_format($tjhtk).'&nbsp;</td>
		<td class="top right" align="right"> '.number_format($tjhtp).'&nbsp;</td>
		<td class="top right" align="right"> '.number_format($tjpk).'&nbsp;</td>
		<td class="top right" align="right"> '.number_format($tjpp).'&nbsp;</td>
		<td class="top right" align="right"> '.number_format($total).'&nbsp;</td>
	</tr>';
	$v1=substr(round($total),-2);
	if ($v1!=00)$pembulatan=round($total)+100-$v1; else $pembulatan = $total;
	echo '
		<tr>
			<td class="left top right"> &nbsp;</td>
		<td class="left top right" colspan="9" align="center"> Total Pembulatan</td>
			<td class="top right" colspan="1" align="right">'.number_format($pembulatan).'&nbsp;</td>
		</tr>
		<tr>
			<td class="left top right"> &nbsp;</td>
			<td class="left top right" colspan="10" align="center"> Terbilang : # '.Terbilang($pembulatan).' Rupiah #</td>
		</tr>
		';
	echo '
		<tr>
			<td class="top" colspan="11"></td>
		</tr>
		</table>
		';
	echo '<table width="800px" border="0" align="right">
		<tr>
		<td align="center" valign="top">Dibuat oleh, <br />
		Spv. SDM & Hukum<br /><br /><br /><br /><br />Diana Dwi Wiyanti</td>
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
