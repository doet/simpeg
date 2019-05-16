html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page { margin: 100px 30px 80px 30px }
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
        <header>
          <img src="{{public_path().'\\pic\\logo.png'}}" width="125px"><div style="position:absolute; top:10; left:100"><b>PT. PELABUHAN CILEGON MANDIRI<br />
        Divisi Pemanduan dan Penundaan</b></div>
            <!-- <center>sssssssssssss<br />
          <font size="-1"><?php echo $mulai;?></font></center> -->
        </header>

        <footer>

          <p class="page">Halaman </p>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <div style="page-break-after: avoid;">
              <table width='80px'>
                  <tr>
                    <!-- rowspan="2" colspan="2" -->
                    <td class="left top right" colspan="2" style="background-color: #DCDCDC;">&nbsp;Nomor Faktur Pajak</td>
                    <td class="top right" colspan="2" style="background-color: #DCDCDC;">&nbsp;Nomor Invoice</td>
                    <td class="top right" colspan="2" style="background-color: #DCDCDC;">&nbsp;Tanggal / Date</td>
                  </tr>
                  <tr>
                    <!-- rowspan="2" colspan="2" -->
                    <td class="left top  button right" colspan="2">&nbsp;010.003.19.81722987</td>
                    <td class="top right button" colspan="2">&nbsp;0613-00/AF19.LC</i></td>
                    <td class="top right button" colspan="2">&nbsp;14 Mei 2019</i></td>
                  </tr>
                </table>
              <table >
                  <tr>
                    <!-- rowspan="2" colspan="2" -->
                    <td class="left top right" colspan="2" style="background-color: #DCDCDC;">&nbsp;Kepada / To :</td>
                    <td class="top right" colspan="2" style="background-color: #DCDCDC;">&nbsp;Berdasarkan / <i>Base on :</i></td>
                    <td class="top right" colspan="2" style="background-color: #DCDCDC;">&nbsp;Untuk / <i>/For Ship :</i></td>
                  </tr>
                  <tr>
                    <td class="left top right">&nbsp;Perusahaan / <i>Company</i></td>
                    <td class="top right">&nbsp;PT. KRAKATAU BANDAR SAMUDERA</i></td>
                    <td class="top right">&nbsp;PPJ No.</td>
                    <td class="top right">&nbsp;PPJ-2019/12026</td>
                    <td class="top right">&nbsp;Nama kapal / <i>Vessel name</i></td>
                    <td class="top right">&nbsp;MT. EAGLE ASIA 07</td>
                  </tr>
                  <tr>
                    <td class="left top right" rowspan="2">&nbsp;Alamat / <i>Address</i></td>
                    <td class="top right" rowspan="2">&nbsp;Jl. May. Jend. S. Parman KM, 13 Cigading, Cilegon</td>
                    <td class="top right">&nbsp;Ref.No</td>
                    <td class="top right">&nbsp;BIN04-000294</td>
                    <td class="top right">&nbsp;GRT(Ton)</td>
                    <td class="top right">&nbsp;5.019</td>
                  </tr>
                  <tr>
                    <td class="top right">&nbsp;BASTDO No.</td>
                    <td class="top right">&nbsp;025</td>
                    <td class="top right">&nbsp;Jalur</td>
                    <td class="top right">&nbsp;International</td>
                  </tr>
                  <tr>
                    <td class="left top right">&nbsp;Telepon / <i>Telephone</i></td>
                    <td class="top right"></td>
                    <td class="top right">&nbsp;Area</td>
                    <td class="top right">&nbsp;Cilegon</td>
                    <td class="top right"></td>
                    <td class="top right"></td>
                  </tr>
                  <tr>
                    <td class="top" colspan="6" ></td>
                  </tr>
              </table>
              <table >
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
                    <td class="top right" rowspan="2" width='60px'>Waktu / <br><i>Time</i></td>
                    <td class="top right" rowspan="2" width='60px'>Terhitung / <br><i>Counted</i></td>
                    <td class="top right" rowspan="2" width='60px'>Mobilisasi / <br><i>Mobilize</i></td>
                    <td class="top right" rowspan="2" width='60px'>Total / <br><i>Total</i></td>

                    <td class="top right" colspan="2">Tetap / <i>Fixed</i></td>
                    <td class="top right" colspan="3">Variabel / <i>Variable</i></td>
                  </tr>
                  <tr>
                    <td class="top right" width='70px'>Dari / <i>From</i></td>
                    <td class="top right" width='70px'>Ke / <i>To</i></td>

                    <td class="top right">Tarif / <i>Tariff</i></td>
                    <td class="top right">Jumlah / <i>Amount</i></td>
                    <td class="top right">Tarif / <i>Tariff</i></td>
                    <td class="top right">GRT</td>
                    <td class="top right">Jumlah / <i>Amount</i></td>
                  </tr>
                  <tr>
                    <td class="top" colspan="16" ></td>
                  </tr>
                </thead>
                <tbody class="zebra">
                  <tr>
                    <td class="left top right" align="center">1193</td>
                    <td class="top right" align="center">Laut/Sea</td>
                    <td class="top right" align="center">BMT</td>
                    <td class="top right" align="center">Tunda/Towing</td>
                    <td class="top right" align="center">22/04/19  15:40</td>
                    <td class="top right" align="center">22/04/19  15:40</td>
                    <td class="top right" align="right">0,83 &nbsp;</td>
                    <td class="top right" align="right">1 &nbsp;</td>
                    <td class="top right" align="right">2 &nbsp;</td>
                    <td class="top right" align="right">3 &nbsp;</td>
                    <td class="top right" align="right">Rp. 5.000.000 &nbsp;</td>
                    <td class="top right" align="right">Rp. 16.000.000 &nbsp;</td>
                    <td class="top right" align="right">Rp. 71 &nbsp;</td>
                    <td class="top right" align="right">5.019 &nbsp;</td>
                    <td class="top right" align="right">Rp. 1.075.000 &nbsp;</td>
                    <td class="top right" align="right">Rp. 17.000.000 &nbsp;</td>
                  </tr>
                  <tr>
                    <td class="top" colspan="16" ></td>
                  </tr>
                  <!-- </tr>
                  <?php
                  // $i=1;
                  // $jppjk=0;
                  // $jbapp=array();
                  // $ppjk = $datetime = '';
                  //
                  // foreach ($result as $row ) {
                  //   $date = explode(" ", date("d-m-Y H:i",$row->date));
                  //   if ($ppjk == $row->ppjk){
                  //     if ($datetime == $row->date){
                  //       $date[1] = 'SHIFT';
                  //       $classShift = 'blue';
                  //     } else {
                  //       $classShift = '';
                  //       $datetime = $row->date;
                  //     }
                  //   }else{
                  //     $ppjk = $row->ppjk;
                  //     $classShift = '';
                  //     $jppjk++;
                  //     $datetime = $row->date;
                  //   }
                  //   // if ($row->bapp != '') $jbapp = ;
                  //   if (!in_array($row->bapp,$jbapp) && $row->bapp!='')$jbapp[]=$row->bapp;
                  //
                  //   if (strpos($row->jettyCode,'S.')===0) $classJetty = 'kuning'; else $classJetty = '';
                  //   // if ($row->kurs == '$') $kurs = 'ungu'; else $kurs = '';
                  //
                  //   $tunda = json_decode($row->tunda);
                  //   if (in_array('GB', $tunda))$gb = 'GB';else $gb = '';
                  //   if (in_array('GC', $tunda))$gc = 'GC';else $gc = '';
                  //   if (in_array('GS', $tunda))$gs = 'GS';else $gs = '';
                  //   if (in_array('MV', $tunda))$mv = 'MV';else $mv = '';
                  //   if (in_array('MG', $tunda))$mg = 'MG';else $mg = '';
                  //
                  //   // if ($row->kapalsLoa == '')$row->kapalsLoa =0;
                  //   if ($row->kapalsJenis == '') $kapal =  $row->kapalsName; else $kapal = '('.$row->kapalsJenis.') '.$row->kapalsName;
                  //   if ($row->tundaon == '') $tundaon=$row->tundaon; else $tundaon=date("H:i",$row->tundaon);
                  //   if ($row->tundaoff == '') $tundaoff=$row->tundaon; else $tundaoff=date("H:i",$row->tundaoff);
                  //
                  //   echo '<tr>';
                  //   echo '<td class="top right left" align="center">&nbsp;'.$i.'</td>';
                  //   echo '<td class="top right" align="center">'.$ppjk.'</td>';
                  //   echo '<td class="top right" align="center">'.$row->agenCode.'</td>';
                  //   echo '<td class="top right" align="center">'.$date[0].'</td>';
                  //   echo '<td class="top right '.$classShift.'" align="center">'.$date[1].'</td>';
                  //   echo '<td class="top right">&nbsp;'.$kapal.'</td>';
                  //   echo '<td class="top right" align="right">'.$row->kapalsGrt.'&nbsp;</td>';
                  //   echo '<td class="top right" align="right">'.$row->kapalsLoa.'&nbsp;</td>';
                  //   echo '<td class="top right">&nbsp;'.$row->kapalsBendera.'</td>';
                  //   echo '<td class="top right '.$classJetty.'">&nbsp;'.'('. $row->jettyCode .')'.$row->jettyName.'</td>';
                  //   echo '<td class="top right">&nbsp;'.$row->ops.'</td>';
                  //   echo '<td class="top right" align="center">'.$row->bapp.'</td>';
                  //   echo '<td class="top right" align="center">'.$row->pc.'</td>';
                  //
                  //   echo '<td class="top right" align="center">'.$gb.'</td>';
                  //   echo '<td class="top right" align="center">'.$gc.'</td>';
                  //   echo '<td class="top right" align="center">'.$gs.'</td>';
                  //   echo '<td class="top right" align="center"'.$mv.'</td>';
                  //   echo '<td class="top right" align="center"'.$mg.'</td>';
                  //
                  //   echo '<td class="top right" align="center">'.$row->lstp.'</td>';
                  //   echo '<td class="top right">&nbsp;'.$row->ket.'</td>';
                  //   echo '</tr>';
                  //   $bstdo = $row->bstdo;
                  //   $i++;
                  // }
                  ?>
                  <tr>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>

                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  <td class="top"></td>
                  </tr> -->
                </tbody>
              </table>
            </div>


            <!-- <p style="page-break-after: never;">
                Content Page 2
            </p> -->
        </main>
    </body>
</html>
