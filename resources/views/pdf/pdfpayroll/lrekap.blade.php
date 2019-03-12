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
    <center>Data Upah Karyawan<br>Lampiran Surat nomor :   ……… /Dir/Keu-PCM/{{ date('m') }}/{{ date('Y') }}<br />
	Priode : {{ $start }} s.d. {{ $end }}</center>
    
</div>


  <div id="footer">
    <p class="page">Page </p>
  </div>

<?php
echo '<table width="650px">
	<tr>
		<th class="left top right" width="20px">No</th>
		<th class="top right">Nama Karyawan</th>
		<th class="top right" width="50px">Bank</th>
		<th class="top right" width="100px">No Rekening</th>
		<th class="top right" width="80px">Jumlah</th>
	</tr>';
	$no=1;

	foreach ($isi as $key=>$value){
		if ($key!='tpembulatan'){					
			$bank=explode("-",$isi[$key]['rekbank']);
			echo '
			<tr>
				<td class="left top right" align="center"> '.$no.'</td>
				<td class="top right">&nbsp;'.$isi[$key]['nama'].'</td>
				<td class="top right" align="center"> &nbsp;'.$bank[0].'</td>
				<td class="top right" align="center"> &nbsp;'.$bank[1].'</td>
				<td class="top right" align="right">'.$isi[$key]['pembulatan'].'&nbsp;</td>			
			</tr>';
			$no++;

		}
	}
	echo '	
	<tr>
		<td class="left top right" align="center"> &nbsp; </td>
		<td class="top right" align="center" colspan="3" > <b> TOTAL </b>  </td>		
		<td class="top right" align="right">'.number_format($isi['tpembulatan']).'&nbsp;</td>
	</tr>
	<tr>
		<th class="top" colspan="5"></th>		
	</tr>

	</tabel>';

	echo '<table width="800px" border="0" align="right">
	<tr>
		<td align="center" valign="top">17 '.date('M Y').'<br />Yang Mengajukan, <br />Spv. SDM & Hukum<br /><br /><br /><br /><br />Diana Dwi Wiyanti</td>
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