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
	<img src="{{public_path().'\\pic\\logo.png'}}" width="125px">
	<div style="position:absolute; top:10; left:100"><b>PT. PELABUHAN CILEGON MANDIRI<br />SLIP GAJI </b></div>
</div>
 <!-- style="margin: 0px 5px 0px 5px;" -->
<table width="680px" style='border: 1px solid black;' >
	<tr>
		<td width="300px" style="padding: 0px 0px 0px 5px;">
			<table width="95%" align="center">
				<tr><td width="80px" class="left top button">Nama </td> <td class="top right button">: {{$row->nama}} </td></tr>
				<tr><td></td> <td></td></tr>
				<tr><td class="left top button">Jabatan</td> <td class="top right button">: {{$row->nmjabatan}} </td></tr>
				<tr><td></td> <td></td></tr>
				<tr><td class="left top button">NIK</td> <td class="top right button">: {{$row->nip}}</td></tr>
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
		<td width="300px" style="padding: 0px 5px 0px 0px;">
			<table width="95%" align="center">
				<tr><td width="80px" class="left top button">Divisi </td> <td class="top right button">: {{$row->nmdivisi}} </td></tr>
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
		<td valign='top align' style="padding: 0px 0px 0px 5px;">
			<table width="95%" align="center">
				<tr>
					<td width="10px"> A </td> <td colspan="2" width="190px">Upah Pokok </td><td align="center">:  </td><td width="80px" class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;

						@if (GajiHelpers::upah($row->id,'pokok',$start))
							{{number_format(GajiHelpers::upah($row->id,'pokok',$start))}}
						@elseif (GajiHelpers::upah($row->id,'honor',$start))
							{{number_format(GajiHelpers::upah($row->id,'honor',$start))}}
						@endif

					&nbsp;</td>
				</tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>B</td> <td colspan="2">Tunjangan-tunjangan</td><td align="center">&nbsp;</td><td >&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Perumahan </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'perum',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				@if ($row->wkerja == 1)
					<tr><td>&nbsp;</td> <td colspan="2">Shift </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::htshift($row->id,$start,$end)['tshift'])}}&nbsp;</td></tr>
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

				<tr><td>&nbsp;</td> <td>Makan  </td><td align="right" class="left top right button number">&nbsp;{{GajiHelpers::rabsen($row->id,$start,$end)['hkerja']}} hari&nbsp;</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'umakan',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>


				<tr><td>&nbsp;</td> <td>Transporttasi </td><td align="right" class="left top right button number">&nbsp;{{GajiHelpers::rabsen($row->id,$start,$end)['hkerja']}} hari&nbsp;</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::upah($row->id,'utransport',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>


				<tr><td>&nbsp;</td> <td colspan="2">Ins. Tambahan waktu kerja </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::rupah($row->id,$start,$end)['lembur'])}}&nbsp;</td></tr>
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
		<td valign='top align' style="padding: 0px 5px 0px 0px;">

			<table width="95%" align="center">
				<tr><td width="10px"> D </td> <td colspan="2" width="190px">PEMOTONGAN TANGGUNGAN KARYAWAN </td><td></td><td width="80px">&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				@if (GajiHelpers::potongan($row->id,'absen',$start))
					<tr><td>&nbsp;</td> <td colspan="2">Indisipliner Absen </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::potongan($row->id,'absen',$start))}}&nbsp;</td></tr>
					<tr><td></td><td></td><td></td><td></td><td></td></tr>
				@endif

				<tr><td>&nbsp;</td> <td colspan="2">Bank Jabar </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::potongan($row->id,'absen',$start))}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">BPJS Kesehatan </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::bpjskes($row->id,$start)['karyawan'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Baziz </td><td align="center">:</td><td class="left top right button  number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::baziz($row->id,$start)['total'])}}&nbsp;</td></td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td></td><td></td><td></td><td></td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td>BPJS Ketenagakerjaan</td><td>&nbsp;</td><td align="center">&nbsp;</td><td>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Jaminan Hari Tua 2% </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>{{number_format(GajiHelpers::bpjsker($row->id,$start)['jhtk'])}}&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Jaminan Pensiun 1% </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Koprasi </td><td></td><td></td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Simpanan Pokok </td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Simpanan Wajib</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">Simpanan Sukarela</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span> &nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td>Angsuran  </td><td align="right" class="left top right button">
					&nbsp;</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>



				<tr><td>&nbsp;</td> <td colspan="2">Emergency Loan</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

				<tr><td>&nbsp;</td> <td colspan="2">DPLK</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>

			</table>
		</td>
	</tr>
	<tr >
		<td valign='top align' style="padding: 0px 0px 0px 5px;">
			<table width="95%" align="center">
				<tr><td width="10px"> C </td><td colspan="2" width="190px">KEKUARANGAN BULAN LALU</td><td align="center">:</td><td width="80px" class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp; &nbsp;</td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">TOTAL</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			</table>
		</td>
		<td>&nbsp;</td>
		<td valign='top align' style="padding: 0px 5px 0px 0px;">
			<table width="95%" align="center">
				<tr><td width="10px"> E </td><td colspan="2" width="190px">KELEBIHAN BULAN LALU</td><td align="center">:</td><td width="80px" class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp; &nbsp;</td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">TOTAL</td><td align="center">:</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			</table>
		</td>
	</tr>
	<tr >
		<td colspan=3 style="padding: 0px 5px 0px 5px;">

			<table style='border: 1px solid;' width='95%' align='center'><tr><td align='center' height='50px' style='background:url({{url('pic/dotted.jpg')}})'><font style='font: bold 15px;'>
			Jumlah upah dibayar &nbsp;&nbsp;&nbsp;&nbsp;Rp.&nbsp;&nbsp;&nbsp;
			</font></td></tr></table>
		</td>
	</tr>
	<tr >
		<td valign='top align' style="padding: 0px 0px 0px 5px;">
			<table width="95%" align="center">
				<tr><td> F </td> <td colspan="4">PEMBAYARAN TANGGUNGAN PERUSAHAAN</td></tr>
				<tr><td width="10px">1</td> <td colspan="2" width="165px">BPJS Ketenagakerjaan </td><td align="center">&nbsp;</td><td width="80px">&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">JKM (Jaminan Kematian)</td><td align="center">0.30% :</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">JKK (Jaminan Kecelakaan Kerja)</td><td align="center">0.89% :</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">JHT (Jaminan Hari Tua)</td><td align="center">3.70% :</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
				<tr><td>&nbsp;</td> <td colspan="2">JP (Jaminan Pensiun)</td><td align="center">2.00% :</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			</table>
		</td>
		<td>&nbsp;</td>

		<td valign='top align' style="padding: 0px 5px 0px 0px;">
			<table width="95%" align="center">
				<tr><td>&nbsp;</td> <td colspan="4">&nbsp;</td></tr>
				<tr><td width="10px">2</td> <td colspan="2" width="165px">DPLK : </td><td align="center">60% :</td><td width="80px"  class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
				<tr><td>3</td> <td colspan="2">Pajak Penghasilan</td><td align="center">5% :</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
				<tr><td>4</td> <td colspan="2">BPJS Kesehatan</td><td align="center">4% :</td><td class="left top right button number">&nbsp;<span style='position: absolute;'>Rp. </span>&nbsp;</td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td></tr>
			</table>
		</td>
	</tr>
</table>

<div id="footer">
  <p class="page">Page </p>

</div>

@stop
