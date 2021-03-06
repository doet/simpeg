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
SLIP GAJI {{$idu}}</b></div>    

</div>
  <div id="footer">
    <p class="page">Page </p>
  </div>
<?php
foreach ($query as $row) {
?>
<table width="680px" style='border: 1px solid black;'>
	<tr>
		<td width="320px">
			<table width="95%" align="center">
				<tr><td width="80px" class="left top button">Nama </td> <td class="top right button">: {{$row->nama}} </td></tr>
				<tr><td></td> <td></td></tr>
				<tr><td class="left top button">Jabatan</td> <td class="top right button">: {{AppHelpers::view_nilai($row->jabatan,'jabatan')}} </td></tr>
				<tr><td></td> <td></td></tr>
				<tr><td class="left top button">NIK</td> <td class="top right button">: {{$row->nip}} </td></tr>
				<tr><td></td> <td></td></tr>
				<tr><td class="left top button">Jam Kerja</td> <td class="top right button">:
				@if ($row->wkerja==0)
					Non Shift
				@else
					Shift
				@endif
				 </td></tr>
				<tr><td></td> <td></td></tr>
			</table>
		</td>
		<td width="40px">&nbsp;</td>
		<td width="320px">
			<table width="95%" align="center">
				<tr><td width="80px" class="left top button">Divisi </td> <td class="top right button">: {{AppHelpers::view_nilai($row->divisi,'divisi')}} </td></tr>
				<tr><td></td> <td></td></tr>
				<tr><td class="left top button">Priode</td> <td class="top right button">: {{$start}} s.d. {{$end}}</td></tr>
				<tr><td></td> <td></td></tr>
				<tr><td class="left top button">tmb</td> <td class="top right button">: {{date('d F Y', $row->tmb)}} </td></tr>
				<tr><td></td> <td></td></tr>
				<tr><td class="left top button">No Rek</td> <td class="top right button">: {{$row->rekbank}}</td></tr>
				<tr><td></td> <td></td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign='top align'>

			<table width="95%" align="center">
				<tr>
					<td width="10px"> A </td> <td colspan="2" width="190px">Upah Pokok </td><td align="center">:  </td><td width="80px" class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;
					@if (GajiHelpers::rupah($row->id_u,$start,$end)['pokok'])
						{{number_format(GajiHelpers::rupah($row->id_u,$start,$end)['pokok'])}}
					@elseif (GajiHelpers::rupah($row->id_u,$start,$end)['honor'])
						{{number_format(GajiHelpers::rupah($row->id_u,$start,$end)['honor'])}}
					@endif

					&nbsp;</td>
				</tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>B</td> <td colspan="2">Tunjangan-tunjangan</td><td align="center">&nbsp;</td><td >&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>


				<tr><td>&nbsp;</td> <td colspan="2">Perumaahn </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'perum',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>


			@if ($row->wkerja == 1)
				<tr><td>&nbsp;</td> <td colspan="2">Shift </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::htshift($row->id_u,$start,$end)['tshift'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			@endif


				<tr><td>&nbsp;</td> <td colspan="2">Jabatan </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'jabatan',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

			@if ($row->divisi == 1)
				<tr><td>&nbsp;</td> <td colspan="2">Pemanduan </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'pandu',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			@endif

			@if (GajiHelpers::upah($row->id,'profesi',$start))
				<tr><td>&nbsp;</td> <td colspan="2">Beban Kerja </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'profesi',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			@endif

			@if (GajiHelpers::upah($row->id,'bkerja',$start))
				<tr><td>&nbsp;</td> <td colspan="2">Beban Kerja </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'bkerja',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			@endif

				<tr><td>&nbsp;</td> <td>Makan  </td><td align="right" class="left top right button number">&nbsp;{{GajiHelpers::rabsen($row->id_u,$start,$end)['hkerja']}} hari&nbsp;</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'umakan',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>


				<tr><td>&nbsp;</td> <td>Transporttasi </td><td align="right" class="left top right button number">&nbsp;{{GajiHelpers::rabsen($row->id_u,$start,$end)['hkerja']}} hari&nbsp;</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'utransport',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>


				<tr><td>&nbsp;</td> <td colspan="2">Ins. Tambahan waktu kerja </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::rupah($row->id_u,$start,$end)['lembur'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Bantuan Cuti </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'bcuti',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

			@if (GajiHelpers::upah($row->id,'tkendaraan',$start))
				<tr><td>&nbsp;</td> <td colspan="2">Kendaraan </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'tkendaraan',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			@endif

			@if (GajiHelpers::upah($row->id,'bbm',$start))
				<tr><td>&nbsp;</td> <td colspan="2">B B M </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'bbm',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			@endif

			@if (GajiHelpers::upah($row->id,'pkendaraan',$start))
				<tr><td>&nbsp;</td> <td colspan="2">Perawatan Kendaraan </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'pkendaraan',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			@endif

				<tr><td>&nbsp;</td> <td colspan="2">Pengembalian Rawat Jalan </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(0)}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Tunjangan Hari Raya </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(0)}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Jasa Produksi </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(0)}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

			</table>
		</td>
		<td>&nbsp;</td>
		<td valign='top align'>

			<table width="95%" align="center">
				<tr><td width="10px"> D </td> <td colspan="2" width="190px">PEMOTONGAN TANGGUNGAN KARYAWAN </td><td></td><td width="80px">&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			@if (GajiHelpers::rpotongan($row->id_u,$start,$end)['absen'])
				<tr><td>&nbsp;</td> <td colspan="2">Indisipliner Absen </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::rpotongan($row->id_u,$start,$end)['absen'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			@endif


				<tr><td>&nbsp;</td> <td colspan="2">Bank Jabar </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::rpotongan($row->id_u,$start,$end)['bjb'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>



				<tr><td>&nbsp;</td> <td colspan="2">BPJS Kesehatan </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::bpjskes($row->id,$start)['karyawan'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>



				<tr><td>&nbsp;</td> <td colspan="2">Baziz </td><td align="center">:</td><td class="left top right button  number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::baziz($row->id,$start)['total'])}}&nbsp;</td></td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>


				<tr><td>&nbsp;</td> <td></td><td></td><td></td><td></td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td>BPJS Ketenagakerjaan</td><td>&nbsp;</td><td align="center">&nbsp;</td><td>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Jaminan Hari Tua 2% </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::bpjsker($row->id_u,$start)['jhtk'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Jaminan Pensiun 1% </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::bpjsker($row->id_u,$start)['jpk'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Koprasi </td><td></td><td></td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Simpanan Pokok </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::tkoperasi($row->id_u,0)['pokok'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Simpanan Wajib</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::tkoperasi($row->id_u,0)['wajib'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Simpanan Sukarela</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span> {{number_format(GajiHelpers::tkoperasi($row->id_u,0)['sukarela'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td>Angsuran  </td><td align="right" class="left top right button"> ke : {{GajiHelpers::pkoperasi($row->id_u,$start)['selisih']}} | sisa : {{GajiHelpers::pkoperasi($row->id_u,$start)['stenor']}} bln
					&nbsp;</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::pkoperasi($row->id_u,'')['angsur'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>



				<tr><td>&nbsp;</td> <td colspan="2">Emergency Loan</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::tkoperasi($row->id_u,'')['el'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">DPLK</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::dplk($row->id,$start)['karyawan'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

			</table>
		</td>
	</tr>
	<tr >
		<td valign='top align'>
			<table width="95%" align="center">
				<tr><td> C </td> <td colspan="2">KEKUARANGAN BULAN LALU</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::rupah($row->id_u,$start,$end)['kbl'])}}&nbsp;</td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">TOTAL</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::rupah($row->id_u,$start,$end)['st'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			</table>
		</td>
		<td>&nbsp;</td>
		<td valign='top align'>
			<table width="95%" align="center">
				<tr><td> E </td> <td colspan="2">KELEBIHAN BULAN LALU</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>0&nbsp;</td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">TOTAL</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::rpotongan($row->id_u,$start,$end)['sp'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			</table>
		</td>
	</tr>
	<tr >
		<td colspan=3>
		<?php
		$totalterima = GajiHelpers::rupah($row->id_u,$start,$end)['st'] - GajiHelpers::rpotongan($row->id_u,$start,$end)['sp'];
		?>
			<table style='border: 1px solid;' width='95%' align='center'><tr><td align='center' height='50px' style='background:url({{url('pic/dotted.jpg')}})'><font style='font: bold 15px;'>
			Jumlah upah dibayar &nbsp;&nbsp;&nbsp;&nbsp;Rp.&nbsp;&nbsp; {{number_format($totalterima)}}&nbsp;
			</font></td></tr></table>
		</td>
	</tr>
	<tr >
		<td valign='top align'>
			<table width="95%" align="center">
				<tr><td> F </td> <td colspan="4">PEMBAYARAN TANGGUNGAN PERUSAHAAN</td></tr>
				<tr><td width="10px">1</td> <td colspan="2" width="165px">BPJS Ketenagakerjaan </td><td align="center">&nbsp;</td><td width="80px">&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">JKM (Jaminan Kematian)</td><td align="center">0.30% :</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::bpjsker($row->id_u,$start)['jkm'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">JKK (Jaminan Kecelakaan Kerja)</td><td align="center">0.89% :</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::bpjsker($row->id_u,$start)['jkk'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">JHT (Jaminan Hari Tua)</td><td align="center">3.70% :</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::bpjsker($row->id_u,$start)['jhtp'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">JP (Jaminan Pensiun)</td><td align="center">2.00% :</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::bpjsker($row->id_u,$start)['jpp'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			</table>
		</td>
		<td>&nbsp;</td>

		<td valign='top align'>
			<table width="95%" align="center">
				<tr><td>&nbsp;</td> <td colspan="4">&nbsp;</td></tr>
				<tr><td width="10px">2</td> <td colspan="2" width="165px">DPLK : </td><td align="center">60% :</td><td width="80px"  class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::dplk($row->id_u,$start)['perusahaan'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
				<tr><td>3</td> <td colspan="2">Pajak Penghasilan</td><td align="center">5% :</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(0)}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
				<tr><td>4</td> <td colspan="2">BPJS Kesehatan</td><td align="center">4% :</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::bpjskes($row->id_u,$start)['perusahaan'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			</table>
		</td>
	</tr>
</table>
<?php
}
?>
@stop
