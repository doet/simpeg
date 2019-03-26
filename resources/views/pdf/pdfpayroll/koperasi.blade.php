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
    <center>Data Koperasi<br />
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
		<th class="top right" align="center" rowspan="2">Nama</th>
		<th class="left top right" align="center" colspan="3">Simpanan</th>
		<th class="top right" align="center" width="80px" rowspan="2">M P P A</th>
		<th class="top right" align="center" width="80px" rowspan="2">Emergency<br>Loan</th>
		<th class="top right" align="center" width="80px" rowspan="2">Angsuran</th>
		<th class="top right" align="center" width="80px" rowspan="2">Total <br>Pembayaran</th>
	</tr>
	<tr>
		<th class="top right" align="center" width="45px">Pokok</th>
		<th class="top right" align="center" width="45px">Wajib</th>
		<th class="top right" align="center" width="45px">Sukarela</th>
	</tr';/*>
	<tr>
		<td class="left top right" colspan="10" style="background-color: lime"><b>Non Shift</b></td>
	</tr>';*/
	$no=1;
	$headwaktu=$tpokok=$twajib=$tsukarela=$tmppa=$tel=$tangsuran=$ttotal=0;

	foreach ($query as $row) {

	/*	if ($headwaktu!=$row->wkerja){
			echo'<tr>
					<td class="left top right" colspan="10" style="background-color: lime"><b>Shift</b></td>
				</tr>';
			$headwaktu=1;
		}*/

		$total=GajiHelpers::tkoperasi($row->id,$start)['total'];
		$ttotal=$ttotal+$total ;

		$tpokok			= $tpokok+GajiHelpers::tkoperasi($row->id,$start)['pokok'];
		$twajib			= $twajib+GajiHelpers::tkoperasi($row->id,$start)['wajib'];
		$tsukarela	= $tsukarela+GajiHelpers::tkoperasi($row->id,$start)['sukarela'];
		$tmppa			= $tmppa+GajiHelpers::tkoperasi($row->id,$start)['mppa'];
		$tel				= $tel+GajiHelpers::tkoperasi($row->id,$start)['el'];
		$tangsuran	= $tangsuran+GajiHelpers::pkoperasi($row->id,$start)['angsur'];

		echo '
<tr>
	<td class="left top right" align="center">'.$no.'</td>
	<td class="top right"> &nbsp;'.$row->nip.'</td>
	<td class="top right"> &nbsp;'.$row->nama.'</td>
	<td class="top right" align="right">'.number_format(GajiHelpers::tkoperasi($row->id,$start)['pokok']).'&nbsp; </td>
	<td class="top right" align="right">'.number_format(GajiHelpers::tkoperasi($row->id,$start)['wajib']).'&nbsp; </td>
	<td class="top right" align="right">'.number_format(GajiHelpers::tkoperasi($row->id,$start)['sukarela']).'&nbsp; </td>
	<td class="top right" align="right">'.number_format(GajiHelpers::tkoperasi($row->id,$start)['mppa']).'&nbsp; </td>
	<td class="top right" align="right">'.number_format(GajiHelpers::tkoperasi($row->id,$start)['el']).'&nbsp; </td>
	<td class="top right" align="right">'.number_format(GajiHelpers::pkoperasi($row->id,$start)['angsur']).'&nbsp; </td>
	<td class="top right" align="right">'.number_format($total).'&nbsp;</td>
</tr>';

		$no++;

	}
	echo '<tr>
		<td class="left top right" align="center"> </td>
		<td class="top right" align="center" colspan="2"><b>TOTAL</b></td>
		<td class="top right" align="right"> <b>'.number_format($tpokok).'</b>&nbsp;</td>
		<td class="top right" align="right"> <b>'.number_format($twajib).'</b>&nbsp;</td>
		<td class="top right" align="right"> <b>'.number_format($tsukarela).'</b>&nbsp;</td>
		<td class="top right" align="right"> <b>'.number_format($tmppa).'</b>&nbsp;</td>
		<td class="top right" align="right"> <b>'.number_format($tel).'</b>&nbsp;</td>
		<td class="top right" align="right"> <b>'.number_format($tangsuran).'</b>&nbsp;</td>
		<td class="top right" align="right"> <b>'.number_format($ttotal).'</b>&nbsp;</td>
	</tr>';
	$v1=substr(round($ttotal),-2);
	if ($v1!=00)$pembulatan=round($ttotal)+100-$v1; else $pembulatan=$ttotal;

	echo '<tr>
		<td class="left top right" align="center"> </td>
		<td class="top right" align="center" colspan="8"><b>TOTAL Pembulatan</b></td>
		<td class="top right" align="right"> <b>'.number_format($pembulatan).'</b>&nbsp;</td>
	</tr>';
	echo '<tr>
		<td class="left top right" align="center"> </td>
		<td class="top right" align="center" colspan="9"><b>Terbilang : <i># '.Terbilang($pembulatan).' #</i></b></td>
	</tr>';
	echo '
	<tr>
		<td class="top" colspan="10"></td>
	</tr>
	</table>
	';
				echo '<table width="800px" border="0" align="right">
	<tr>
		<td align="center" valign="top">17 '.date('M Y').'<br />Yang Mengajukan, <br />Spv. SDM & Hukum<br /><br /><br /><br /><br />Fajar Prasetya</td>
		<td align="center" valign="top"><br />Mengetahui Oleh, <br />Mgr. SDM & Umum<br />
	<br /><br /><br /><br />Herny Setiawanti</td></tr></table>';

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
&nbsp;<br />

@stop
