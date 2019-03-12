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
SDM & Hukum</b></div><br><br>

    <center>RINCIAN REKAPITULASI SHIFT DISPATCHER DAN DRIVER  <br>
    <font size="-1">Priode : {{ $start }} s.d. {{ $end }}</font></center><br>

</div>
  <div id="footer">
    <p class="page">Page </p>
  </div>


<?php

echo '
<table width="690px">
	<tr>
		<th colspan="7">SHIFT DISPATCHER</th>
	</tr>
	<tr>
		<th class="left top right" width="30px" rowspan="2" align="center">No</th>
		<th class="top right" rowspan="2" align="center">Nama</th>
		<th class="left top right" colspan="4" align="center">TUNJANGAN SHIFT</th>
		<th class="top right" width="120px" rowspan="2" align="center">Total <br>Shift</th>
	</tr>
	<tr>
		<th class="top right" width="50px" align="center">Shift I</th>
		<th class="top right" width="100px" align="center">Jumlah</th>
		<th class="top right" width="50px" align="center">Shift III</th>
		<th class="top right" width="100px" align="center">Jumlah</th>
	</tr>';
	$tt1=0;
	$no=1;
foreach ($query as $row) {

	if($row->jabatan==10){

		echo '<tr>
			<td class="left top right" align="center"> '.$no++.'</td>
			<td class="top right"> &nbsp;'.$row->nama.'</td>
			<td class="top right" align="center">'.GajiHelpers::htshift($row->id,$start,$end)['shift1'].' Hari</td>
			<td class="top right" align="right">'.number_format(GajiHelpers::htshift($row->id,$start,$end)['tshift1']).'&nbsp;</td>
			<td class="top right" align="center">'.GajiHelpers::htshift($row->id,$start,$end)['shift3'].' Hari</td>
			<td class="top right" align="right">'.number_format(GajiHelpers::htshift($row->id,$start,$end)['tshift3']).'&nbsp;</td>
			<td class="top right" align="right">'.number_format(GajiHelpers::htshift($row->id,$start,$end)['tshift']).'&nbsp;</td>
		</tr>';

		$tt1=$tt1+GajiHelpers::htshift($row->id,$start,$end)['tshift'];
	}
}
	echo '<tr>
			<td class="left top right" align="center" colspan="6"> TOTAL </td>
			<td class="top right" align="right">'.number_format($tt1).'&nbsp;</td>
		</tr>';
echo '
	<tr>
		<th class="top" colspan="7"></th>
	</tr>
</tabel>';

echo '
<table width="690px">
	<tr>
		<th colspan="7">SHIFT DRIVER</th>
	</tr>
	<tr>
		<th class="left top right" width="30px" rowspan="2" align="center">No</th>
		<th class="top right" rowspan="2" align="center">Nama</th>
		<th class="left top right" colspan="4" align="center">TUNJANGAN SHIFT</th>
		<th class="top right" width="120px" rowspan="2" align="center">Total <br>Shift</th>
	</tr>
	<tr>
		<th class="top right" width="50px" align="center">Shift I</th>
		<th class="top right" width="100px" align="center">Jumlah</th>
		<th class="top right" width="50px" align="center">Shift III</th>
		<th class="top right" width="100px" align="center">Jumlah</th>
	</tr>';
	$tt2=0;
	$no=1;
foreach ($query as $row) {
	if($row->jabatan==22){

		echo '<tr>
			<td class="left top right" align="center"> '.$no++.'</td>
			<td class="top right"> &nbsp;'.$row->nama;
			echo'</td>
			<td class="top right" align="center">'. GajiHelpers::htshift($row->id,$start,$end)['shift1'].' Hari</td>
			<td class="top right" align="right">'.number_format(GajiHelpers::htshift($row->id,$start,$end)['tshift1']).'&nbsp;</td>
			<td class="top right" align="center">'. GajiHelpers::htshift($row->id,$start,$end)['shift3'].' Hari</td>
			<td class="top right" align="right">'.number_format(GajiHelpers::htshift($row->id,$start,$end)['tshift3']).'&nbsp;</td>
			<td class="top right" align="right">'.number_format(GajiHelpers::htshift($row->id,$start,$end)['tshift']).'&nbsp;</td>
		</tr>';

		$tt2=$tt2+GajiHelpers::htshift($row->id,$start,$end)['tshift'];
	}
}
	echo '<tr>
			<td class="left top right" align="center" colspan="6"> TOTAL </td>
			<td class="top right" align="right">'.number_format($tt2).'&nbsp;</td>
		</tr>';
echo '
	<tr>
		<th class="top" colspan="7"></th>
	</tr>
</tabel>';

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
&nbsp;<br />

@stop
