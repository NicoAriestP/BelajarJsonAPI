<?php 
        $tahun = $_GET['tahun'];

        // master
        $kategori = ["makanan", "minuman"];
        $bulan = [
            array(
                "nama" => "Jan",
                "totalPerBulan" => null,
            ),
            array(
                "nama" => "Feb",
                "totalPerBulan" => null,
            ),
            array(
                "nama" => "Mar",
                "totalPerBulan" => null,
            ),
            array(
                "nama" => "Apr",
                "totalPerBulan" => null,
            ),
            array(
                "nama" => "Mei",
                "totalPerBulan" => null,
            ),
            array(
                "nama" => "Jun",
                "totalPerBulan" => null,
            ),
            array(
                "nama" => "Jul",
                "totalPerBulan" => null,
            ),
            array(
                "nama" => "Agu",
                "totalPerBulan" => null,
            ),
            array(
                "nama" => "Sep",
                "totalPerBulan" => null,
            ),
            array(
                "nama" => "Okt",
                "totalPerBulan" => null,
            ),
            array(
                "nama" => "Nov",
                "totalPerBulan" => null,
            ),
            array(
                "nama" => "Des",
                "totalPerBulan" => null,
            )
        ];

        // menu
         $getMenu = file_get_contents('menu.json');
        $menu = json_decode($getMenu);

        // transaksi
        $getTrans = file_get_contents("tes_".$tahun.".json");
        $trans = json_decode($getTrans);

        $arrayTotalPerBulan = [];
    ?>
        <table class="table table-bordered mt-4 table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th class="text-center" rowspan="2" colspan="2">Menu</th>
                    <th class="text-center" colspan="<?php echo count($bulan) ?>">Periode Pada <?php echo $tahun; ?> </th>
                    <th class="text-center" rowspan="2" colspan="2">Total</th>
                </tr>
                <tr>
                    <?php foreach ($bulan as $keybulan => $valbulan){ ?>
                        <th><?php echo $valbulan['nama']; ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kategori as $keykategori => $valkategori){ ?>
                <tr>
                    <!-- pakai text transform karena value array kategori akan disamakan dengan value kategori dari menu.json -->
                    <td style="text-transform: capitalize;" colspan="<?php echo count($bulan) + 4 ?>" class="table-secondary"><?= $valkategori; ?></td>
                </tr>
                <?php for ($i=0; $i < count($menu); $i++) { 
                    // var_dump($menu[$i]->kategori);
                    //[$i]=indeks array. kategori = akses key kategori objek 
                    //if untuk menyamakan kategori makanan dengan jenis makanan yg dilooping
                    if ($menu[$i]->kategori == $valkategori) {
                        ?>
                        <tr>
                            <td colspan="2"><?= $menu[$i]->menu; ?></td>
                            <?php 
                                for ($ib=0; $ib < count($bulan); $ib++) { 
                                // karna index dimulai dari 0 maka +1 biar sesuai misal 1 = januari, 2=februari, dst
                                $bulanKe = $ib+1;
                                // echo $bulanKe.'<br>';
                                //format tanggal 2021-01-01 terus difilter.0 untuk format bulan seperti 01,02 dst. 2 untuk maks desimal value. d untuk value type desimal
                                $filterTahunBulan = $tahun.'-'.sprintf("%02d", $bulanKe);
                                // echo $filterTahunBulan.' ';
                                $subTotalPerBulanByKategori = 0;
                                $subTotalPerBulan = 0;
                                $subTotalPerKategori = 0;
                                for ($t=0; $t < count($trans); $t++) { 
                                     // explode berfungsi untuk memecahkan string jadi array dengan pemisah, dibawah ini pemisahnya strip "-"
                                            $tanggalPesan = explode("-", $trans[$t]->tanggal);

                                            // $tanggalPesan[0] = tahunnya (misal: 2021)
                                            // $tanggalPesan[1] = bulannya (misal 01)
                                            // echo $tanggalPesan[1];
                                            $tanggalPesanTahunBulan = $tanggalPesan[0]."-".$tanggalPesan[1];
                                            // echo $tanggalPesanTahunBulan." ";

                                            // filter total per bulan berdasarkan kategori
                                            if($menu[$i]->menu==$trans[$t]->menu &&
                                                $tanggalPesanTahunBulan==$filterTahunBulan){
                                                $subTotalPerBulanByKategori += $trans[$t]->total;
                                            }
                                            
                                            // filter total per bulan
                                            if($filterTahunBulan==$tanggalPesanTahunBulan){
                                                $subTotalPerBulan += $trans[$t]->total;
                                            }

                                            // filter total beradasarkan kategori
                                            if($menu[$i]->menu==$trans[$t]->menu){ 
                                                $subTotalPerKategori += $trans[$t]->total;
                                            }
                                        }
                                        $bulan[$ib]['totalPerBulan'] = $subTotalPerBulan;
                                        $menu[$i]->totalPerKategori = $subTotalPerKategori;
                                        ?>
                                        <td><?php echo $subTotalPerBulanByKategori; ?></td>
                                <?php } ?>
                                <td><?php echo $subTotalPerKategori; ?></td>
                        </tr>
                <?php 
                        }
               
                    } 
                ?>
            <?php } ?>
                        <!-- total -->
            <tr>
                <td colspan="2">Total</td>
                <?php 
                    $totalAll = 0;
                    for ($it=0; $it < count($bulan); $it++) {  
                        $totalAll += $bulan[$it]['totalPerBulan'];
                ?>
                            <td><?=$bulan[$it]['totalPerBulan']?></td>
                <?php 
                    } 
                ?>
                <td><?=$totalAll?></td>
            </tr>
            </tbody>
        </table>