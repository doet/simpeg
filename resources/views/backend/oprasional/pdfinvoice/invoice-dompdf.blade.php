<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page { margin: 150px 30px 80px 30px }
            header { position: fixed; top: -60px; left:0px; right: 10px;  }

            /* main { position: fixed; top: 50px; left: 0px; bottom: -10px; right: 0px;  } */

            footer { position: fixed; left: 10px; bottom: -15px; right: 0px;}
            footer .page:after { content: counter(page, normal); }

            header {
                /* position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px; */

                /** Extra personal styles **/
                /* background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px; */
            }

            footer {
                /* position: fixed;
                bottom: -60px;
                left: 0px;
                right: 0px;
                height: 50px; */

                /** Extra personal styles **/
                /* background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px; */
            }
            /* #footer .page:after { content: counter(page, normal); } */

            thead {
              text-align: center;
              vertical-align: middle;
            }

            table {
                border-collapse: collapse;
              /* border: 1px dotted; */

              border-spacing: 0;
              margin-top:10px;
              width: 100%;
              margin-bottom:10px;
              max-height:50px;
              height:40px ;
              font-family :"Arial", Helvetica, sans-serif !important;
              font-size: 10px;
            }
            .right{
                border-right: 1px dotted;
            }
            .left{
              border-left: 1px dotted;
            }
            .top{
                border-top: 1px dotted;
            }
            .button{
            	border-bottom: 1px dotted;
            }

            .zebra tr:nth-child(even) {
                 background-color: #f9f9f9;
            }
            .zebra tr:nth-child(odd) {
                 background-color: #DCDCDC;
            }
            .blue {
                 background-color: #5373D1;
                 color: #FFFFFF;
            }
            .kuning {
                 background-color: #FFFF00;
                 /* color: #FFFFFF; */
            }
            .ungu {
                 background-color: #800080;
                 color: #FFFFFF;
            }
        </style>
    </head>
    <body style="font-family:'Arial', Helvetica, sans-serif ; font-size:12px;">
        <!-- Define header and footer blocks before your content -->
        <!-- <header>
          <img src="{{public_path().'\\pic\\logo.png'}}" width="125px"><div style="position:absolute; top:10; left:100"><b>PT. PELABUHAN CILEGON MANDIRI<br />
        Divisi Pemanduan dan Penundaan</b></div>
        </header> -->

        <footer>

          <!-- <p class="page">Halaman </p> -->
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->

        <main>
            <div style="page-break-after: avoid;">
              <div style="position:absolute; top:-90; left:30; width:300">
                <img src="{{public_path().'\\images\\pemda.png'}}" width="100px">
              </div>
              <div style="position:absolute; top:-88; left:110">
                <b>BADAN USAHA MILIK DAERAH<br />
                  PEMERINTAH KOTA CILEGON<br />
                  PT. PELABUHAN CILEGON MANDIRI<br />
                  Jl. Yos Sudarso No. 20 Kec. Pulo Merak, Cilegon - Banten 42438  Tel. 0254-574000  Fax. 574894
                </b>
              </div>
              <?php
                $totalTarif = 0;
                $area=$tundaon=$dari=$ke= '';

                $code=$name=$isi=array();
                $i=0;

                foreach ($query as $row ) {
                  $isi[$i]['i']=$i;
                  if (substr($row->code,0,1)=='S'){
                    if(!in_array('Serang',$code))array_push($code,'Serang');
                    // $area='Serang';
                  } else {
                    if(!in_array('Cilegon',$code))array_push($code,'Cilegon');
                    // $area='Cilegon';
                  }

                  if(!in_array($row->name,$name))array_push($name,$row->name);
                  if(in_array('Cigading',$name)){
                    if ($result->rute == '$') $headstatus='Cigading 1'; else $headstatus='Cigading 2';
                  } else {
                    if ($result->rute == '$') $headstatus='Non Cigading 1'; else $headstatus='Non Cigading 2';
                  }

                  if ($row->ops=='Berth'){
                    if ($row->shift!='on'){
                      $isi[$i]['dari'] = 'Laut/<i>Sea</i>';
                      $isi[$i]['ke'] = $row->name;
                      $dari=$row->name;
                      $isi[$i]['daria']=$isi[$i]['kea']=substr($row->code,0,1);
                    } else {
                      $isi[$i]['dari'] = $dari;
                      $isi[$i]['ke'] = $row->name;
                      $dari=$row->name;
                      $isi[$i]['daria']=$isi[$i-1]['kea'];
                      $isi[$i]['kea']=substr($row->code,0,1);
                    }
                  }

                  if ($row->ops=='Unberth'){
                    if ($row->shift!='on'){
                      $isi[$i]['dari'] = $dari;
                      $isi[$i]['ke'] = 'Laut/<i>Sea</i>';
                      $tundaon='';
                      $isi[$i]['daria']=$isi[$i-1]['kea'];
                      $isi[$i]['kea']=$isi[$i-1]['kea'];
                    } else {
                      // $isi[$i]['dari'] = $dari;
                      $dari=$row->name;
                      $tundaon=$row->tundaon;
                      $isi[$i]['daria']='';
                      $isi[$i]['kea']='';
                    }
                  }

                  if ($tundaon!=''){
                    $isi[$i]['tundaon']=date('d/m/y H:i',$tundaon);
                    $row->tundaon = $tundaon;
                  } else $isi[$i]['tundaon']=date('d/m/y H:i',$row->tundaon);

                  $isi[$i]['tundaoff']=date('d/m/y H:i',$row->tundaoff);

                  $isi[$i]['selisihWaktu']=$selisihWaktu=number_format(($row->tundaoff-$row->tundaon)/3600,2);
                  $exWaktu = explode(".",$selisihWaktu);

                  if ($exWaktu[1]<=50)$selisihWaktu2=$exWaktu[0]+0.5; else $selisihWaktu2=ceil($selisihWaktu);
                  if ($selisihWaktu2<1)$selisihWaktu2=1;
                  $isi[$i]['selisihWaktu2']=$selisihWaktu2=number_format($selisihWaktu2,2);

                  if ($isi[$i]['daria']!='S' && $isi[$i]['kea']!='S') $isi[$i]['mobilisasi']=$mobilisasi=2;
                  else if ($isi[$i]['daria']!='S' && $isi[$i]['kea']=='S') $isi[$i]['mobilisasi']=$mobilisasi=2.25;
                  else if ($isi[$i]['daria']=='S' && $isi[$i]['kea']!='S') $isi[$i]['mobilisasi']=$mobilisasi=2.25;
                  else if ($isi[$i]['daria']=='S' && $isi[$i]['kea']=='S') $isi[$i]['mobilisasi']=$mobilisasi=2.5;

                  $isi[$i]['jumlahWaktu']=$jumlahWaktu=$mobilisasi+$selisihWaktu2;

                  $kapalsGrt = $result->kapalsGrt;
                  if ($kapalsGrt<=3500)$isi[$i]['tariffix'] = 152.25*$kurs->nilai;
                  else if ($kapalsGrt<=8000)$isi[$i]['tariffix'] = 386.25*$kurs->nilai;
                  else if ($kapalsGrt<=14000)$isi[$i]['tariffix'] = 587.1*$kurs->nilai;
                  else if ($kapalsGrt<=18000)$isi[$i]['tariffix'] = 770*$kurs->nilai;
                  else if ($kapalsGrt<=40000)$isi[$i]['tariffix'] = 1220*$kurs->nilai;
                  else if ($kapalsGrt<=75000)$isi[$i]['tariffix'] = 1300*$kurs->nilai;
                  else if ($kapalsGrt>75000)$isi[$i]['tariffix'] = 1700*$kurs->nilai;

                  $isi[$i]['jumlahTariffix']=$jumlahTariffix=$isi[$i]['tariffix']*$isi[$i]['jumlahWaktu'];

                  if ($kapalsGrt<=14000)$tarifvar=0.005*$kurs->nilai;
                  else if ($kapalsGrt<=40000)$tarifvar=0.004*$kurs->nilai;
                  else if ($kapalsGrt>40000)$tarifvar=0.002*$kurs->nilai;

                  $isi[$i]['jumlahTarifvar']=$jumlahTarifvar=$tarifvar*$kapalsGrt*$jumlahWaktu;

                  $isi[$i]['jumlahTarif']=$jumlahTarif=$jumlahTarifvar+$jumlahTariffix;

                  $totalTarif = $jumlahTarif+$totalTarif;
                  if ($row->ops=='Berth'){
                    if ($row->shift!='on'){
                      $i++;
                    } else {
                      $i++;
                    }
                  }

                  if ($row->ops=='Unberth'){
                    if ($row->shift!='on'){
                      $i++;
                    } else {

                    }
                  }

                }
                // dd($kea);
                $bht99=$totalTarif*(99/100);
                $bht5=$bht99*(5/100);
                $bhtPNBP=$bht99-$bht5;
                $ppn=$bhtPNBP*(10/100);
                $totalinv=$bhtPNBP+$ppn;
              ?>

              <div style="position:absolute; top:-90; left:600;">
                <table>
                  <tr>
                    <td class="left top right button" align="center"><b><?php echo $headstatus?></b></td>
                    <td width='50px'>&nbsp;</td>
                    <td>
                      Distribusi/Distribution<br>
                      (1) Pengguna Jasa<br>
                      (2) Keuangan PT PCM<br>
                      (3) Komersil PT PCM<br>
                      (4) Subdin Hubla<br>
                    </td>
                  </tr>
                </table>
                <table>
                  <tr>
                    <td class="left top right" align="center" style="background-color: #DCDCDC;" height='18px'>&nbsp;Nomor Faktur Pajak</td>
                    <td class="top right" align="center" style="background-color: #DCDCDC;">&nbsp;Nomor Invoice</td>
                    <td class="top right" align="center" style="background-color: #DCDCDC;">&nbsp;Tanggal / <i>Date</i></td>
                  </tr>
                  <tr>
                    <td class="left top right button" align="center" height='18px'>&nbsp;<?php echo $result->pajak?></td>
                    <td class="top right button" align="center">&nbsp;<?php echo $result->noinv?></td>
                    <td class="top right button" align="center">&nbsp;<?php echo date('d M Y', $result->tglinv)?></i></td>
                  </tr>
                </table>
              </div>


              <b><i>NOTA TAGIHAN / INVOICE</i></b>
              <table >
                  <tr>
                    <!-- rowspan="2" colspan="2" -->
                    <td class="left top right" colspan="2" style="background-color: #DCDCDC;">&nbsp;Kepada / <i>To :</i></td>
                    <td class="top right" colspan="2" style="background-color: #DCDCDC;">&nbsp;Berdasarkan / <i>Base on :</i></td>
                    <td class="top right" colspan="2" style="background-color: #DCDCDC;">&nbsp;Untuk / <i>For Ship :</i></td>
                  </tr>
                  <tr>
                    <td class="left top right" width="150px">&nbsp;Perusahaan / <i>Company</i></td>
                    <td class="top right" width="300px">&nbsp;<?php echo $result->agenName?></i></td>
                    <td class="top right" width="150px">&nbsp;PPJ No.</td>
                    <td class="top right" width="300px">&nbsp;<?php echo $result->ppjk?></td>
                    <td class="top right" width="150px">&nbsp;Nama kapal / <i>Vessel name</i></td>
                    <td class="top right">&nbsp;<?php echo $result->kapalsJenis.'. '.$result->kapalsName?></td>
                  </tr>
                  <tr>
                    <td class="left top right" rowspan="2">&nbsp;Alamat / <i>Address</i></td>
                    <td class="top right" rowspan="2">&nbsp;<?php echo $result->agenAlamat?></td>
                    <td class="top right">&nbsp;Ref.No</td>
                    <td class="top right">&nbsp;<?php echo $result->refno?></td>
                    <td class="top right">&nbsp;GRT(Ton)</td>
                    <td class="top right">&nbsp;<?php echo number_format($result->kapalsGrt)?></td>
                  </tr>
                  <tr>
                    <td class="top right">&nbsp;BASTDO No.</td>
                    <td class="top right">&nbsp;<?php echo $result->bstdo?></td>
                    <td class="top right">&nbsp;Jalur</td>
                    <td class="top right">&nbsp;<?php if($result->rute == '$') echo 'International'; else if($result->rute == 'Rp') echo 'Domestic'?></td>
                  </tr>
                  <tr>
                    <td class="left top right button">&nbsp;Telepon / <i>Telephone</i></td>
                    <td class="top right button">&nbsp;<?php echo $result->agenTlp?></td>
                    <td class="top right button">&nbsp;Area</td>
                    <td class="top right button">&nbsp;<?php if (count($code)>1) echo 'Cilegon/Serang'; else echo $code[0]; ?></td>
                    <td class="top right button"></td>
                    <td class="top right button"></td>
                  </tr>
              </table>

              Silahkan dibayarkan tagihan berikut / <i>Please pay invoice as follow :</i>
              <table>
                <thead>
                  <tr>
                    <!-- rowspan="2" colspan="2" -->
                    <td class="left top right" rowspan="3" width='35px'>LSTP<br>No</td>
                    <td class="top right" rowspan="2" colspan="2">Lokasi / <i>Location</i></td>
                    <td class="top right" rowspan="3" width='70px'>Uraian /<br> <i>Description</i></td>
                    <td class="top right" rowspan="3" width='90px'>Mulai / <i>Start</i><br> <i>(hr/bln/th jam:mnt)</i><br> <i>(dd/mm/yy hr:mnt)</i></td>
                    <td class="top right" rowspan="3" width='90px'>Selesai / <i>Finish</i><br> <i>(hr/bln/th jam:mnt)</i><br> <i>(dd/mm/yy hr:mnt)</i></td>
                    <td class="top right" colspan="4">Jumlah Waktu (Jam) / <i>Duration</i> (hour)</td>
                    <td class="top right" colspan="5">Perhitungan Tagihan / <i>Calculation of Invoice</i></td>
                    <td class="top right" rowspan="3">Total / <i>Total</i></td>
                  </tr>
                  <tr>
                    <td class="top right" rowspan="2" width='55px'>Waktu / <br><i>Time</i></td>
                    <td class="top right" rowspan="2" width='55px'>Terhitung / <br><i>Counted</i></td>
                    <td class="top right" rowspan="2" width='55px'>Mobilisasi / <br><i>Mobilize</i></td>
                    <td class="top right" rowspan="2" width='55px'>Total / <br><i>Total</i></td>

                    <td class="top right" colspan="2">Tetap / <i>Fixed</i></td>
                    <td class="top right" colspan="3">Variabel / <i>Variable</i></td>
                  </tr>
                  <tr>
                    <td class="top right" width='90px'>Dari / <i>From</i></td>
                    <td class="top right" width='90px'>Ke / <i>To</i></td>

                    <td class="top right">Tarif / <i>Tariff</i></td>
                    <td class="top right">Jumlah / <i>Amount</i></td>
                    <td class="top right">Tarif / <i>Tariff</i></td>
                    <td class="top right" width='50px'>GRT</td>
                    <td class="top right">Jumlah / <i>Amount</i></td>
                  </tr>
                  <tr>
                    <td class="top" colspan="16" ></td>
                  </tr>
                </thead>
                <tbody class="zebra">
              <?php
                foreach ($isi as $row) {
                  echo '<tr>';
                  echo '<td class="left top right" align="center"> '.$row['i'].' </td>';
                  echo '<td class="top right" align="center"> '.$row['dari'].' </td>';
                  echo '<td class="top right" align="center"> '.$row['ke'].' </td>';
                  echo '<td class="top right" align="center"> Tunda/<i>Towing</i> </td>';
                  echo '<td class="top right" align="center"> '.$row['tundaon'].' </td>';
                  echo '<td class="top right" align="center"> '.$row['tundaoff'].' </td>';
                  echo '<td class="top right" align="right"> '.number_format($row['selisihWaktu'],2).'&nbsp; </td>';
                  echo '<td class="top right" align="right"> '.number_format($row['selisihWaktu2'],2).'&nbsp;  </td>';
                  echo '<td class="top right" align="right"> '.number_format($row['mobilisasi'],2).'&nbsp;  </td>';
                  echo '<td class="top right" align="right"> '.number_format($row['jumlahWaktu'],2).'&nbsp;  </td>';
                  echo '<td class="top right" align="right">Rp. '.number_format($row['tariffix']).'&nbsp;</td>';
                  echo '<td class="top right" align="right">Rp. '.number_format($row['jumlahTariffix']).'&nbsp;</td>';
                  echo '<td class="top right" align="right">Rp. '.ceil($tarifvar).'&nbsp;</td>';
                  echo '<td class="top right" align="right"> '.number_format($kapalsGrt).'&nbsp;</td>';
                  echo '<td class="top right" align="right">Rp. '.number_format($row['jumlahTarifvar']).'&nbsp;</td>';
                  echo '<td class="top right" align="right">Rp. '.number_format($row['jumlahTarif']).'&nbsp;</td>';
                  echo '</tr>';
                }
              ?>

                </tbody>
                <tr>
                  <td class="top" colspan="6" rowspan="4">



                  </td>
                  <td class="top" colspan="9" align="right">Total Tunda</td>
                  <td class="left top right" align="right">Rp. <?php echo number_format($totalTarif)?>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="9" align="right">Bagi Hasil Tunda setelah PNBP</td>
                  <td class="left top right" align="right">Rp. <?php echo number_format($bhtPNBP)?>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="9" align="right">PPn / Total after VAT</td>
                  <td class="left top right" align="right">Rp. <?php echo number_format($ppn)?>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="9" align="right">Total Tagihan Bagi Hasil / Total Invoice</td>
                  <td class="left top right button" align="right">Rp. <?php echo number_format($totalinv)?>&nbsp;</td>
                </tr>
              </table>
            </div>

            <div style="position:absolute; top:260; left:30; width:300; font-family:'Arial', Helvetica, sans-serif ; font-size:11px;">
              Kurs Jual Bank Indonesia 1 USD / <?php echo date('d M Y', $kurs->date)?>	= Rp. <?php echo number_format($kurs->nilai)?>
              <table>
                <thead>
                  <tr>
                    <td class="left top right" style="background-color: #DCDCDC;" colspan="2" height='17'>Dibayarkan ke / <i>Payable</i></td>
                    <td class="top right" style="background-color: #DCDCDC;">Tanggal jatuh tempo / <i>Due</i></td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="left top right button">&nbsp;Bank BNI (IDR)</td>
                    <td class="top right button">&nbsp;231.05.45</td>
                    <td class="top right button" rowspan="3" align="center">&nbsp;<b><?php echo date('d M Y', $result->tglinv)?></b></i></td>
                  </tr>
                  <tr>
                    <td class="left top right button">&nbsp;Bank Mandiri (IDR)</td>
                    <td class="top right button">&nbsp;116.000.458.7292</td>
                  </tr>
                  <tr>
                    <td class="left top right button">&nbsp;Bank Jabar (IDR)</td>
                    <td class="top right button">&nbsp;28.00.01.006542.7</td>
                  </tr>
                  <tr>
                    <td class="left top right button">&nbsp;Atas nama / <i>Favour</i></td>
                    <td class="top right button" colspan="2">&nbsp;PT. Pelabuhan Cilegon Mandiri</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div style="position:absolute; top:350; left:30; width:350; font-family:'Arial', Helvetica, sans-serif ; font-size:11px;" align='center'>
              PT. PELABUHAN CILEGON MANDIRI<br>Pelaksana Pelayanan Jasa<br><br><br><br><br><br><br>
              H. ARIEF RIVA'I, SH, MH,M.SI<br>Direktur Utama
            </div>
<div style="position:absolute; top:350; left:530; width:350;font-family:'Arial', Helvetica, sans-serif ; font-size:10px;" class="left top right button">
            <ol>
              Keterangan :
            <li>Pembayaran dianggap sah  apabila bukti  transfer pembayaran telah disah-kan oleh Bank  dan bukti transfer tersebut diserahkan ke PT. Pelabuhan Cilegon Mandiri / Payment  valid when the transfer document has been legalized by the bank and submit to PT. Pelabuhan Cilegon Mandiri .</li>
            <li>Mohon pembayaran agar dilunasi sebelum jatuh tempo. The payment shall be paid before due date.</li>
            <li>Keluhan mengenai invoice bila ada agar di ajukan 3(tiga) hari sebelum jatuh tempo. If there is any complain about the invoice, please inform us 3(three) days before due date.</li>
            </ol>
</div>



            <!-- <p style="page-break-after: never;">
                Content Page 2
            </p> -->
        </main>
    </body>
</html>