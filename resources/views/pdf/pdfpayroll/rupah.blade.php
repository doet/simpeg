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
    <center>REKAPITULASI TUNJANGAN GAJI KARYAWAN<br />
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
		<th class="top right" width="20px" rowspan="2">Hari<br>Kerja</th>
		<th class="top right" width="60px" rowspan="2">Upah Pokok</th>
		<th class="top right" width="50px" rowspan="2">Honorarium</th>		
		<th class="top right" colspan="14">Tunjangan - Tunjangan</th>
		<th class="top right" width="60px" rowspan="2">Sub Total Upah</th>
	</tr>

	<tr>
		<th class="top right" width="50px">Perumahan</th>
		<th class="top right" width="50px">Shift</th>
		<th class="top right" width="50px">Jabatan</th>	
		<th class="top right" width="50px">pemanduan</th>
		<th class="top right" width="50px">Profesi</th>
		<th class="top right" width="50px">Beban Kerja</th>	
		<th class="top right" width="50px">Makan</th>
		<th class="top right" width="50px">Transport</th>
		<th class="top right" width="50px">Lembur</th>	
		<th class="top right" width="50px">B.Cuti</th>
		<th class="top right" width="50px">K.BL</th>
		<th class="top right" width="50px">Kendaraan</th>
		<th class="top right" width="50px">BBM</th>
		<th class="top right" width="50px">Perawatan<br>Kendaraan</th>
	</tr>';
	$no=1;
	//$headwaktu=$tgajipokok=$thonor=$tperumahan=$tshift=$tjabatan=$tpandu=$tprofesi=$tbkerja=$tum=$ttp=$tlembur=$tcuti=$tkbl=$tkendaraan=$stt=0;
	$stt=0;

	foreach ($isi as $key=>$value){
		
		if ($key!='stt'){	
		if ($isi[$key]['nama']!=''){
			echo '<tr>
				<td class="left top right" align="center"> '.$no.'</td>
				<td class="top right"> '.$isi[$key]['nama'].'</td>
				<td class="top right" align="center"> '.$isi[$key]['hkerja'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['pokok'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['honor'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['perum'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['tshift'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['jabatan'].'&nbsp;</td>		
				<td class="top right" align="right"> '.$isi[$key]['pandu'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['profesi'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['bkerja'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['umakan'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['utransport'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['lembur'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['bcuti'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['kbl'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['tkendaraan'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['bbm'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['pkendaraan'].'&nbsp;</td>
				<td class="top right" align="right"> '.$isi[$key]['st'].'&nbsp;</td>
			</tr>';
			$no++;
		}}
	}
	echo '<tr>
		<td class="left top right"> &nbsp;</td>
		<td class="top right" align="center" colspan="2"> TOTAL &nbsp;</td>
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
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> &nbsp;</td>
		<td class="top right" align="right"> '.number_format($isi['stt']).'&nbsp;</td>
	</tr>';

	echo '
		<tr>
			<td class="top" colspan="20"></td>		
		</tr>
		</table>
		';
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