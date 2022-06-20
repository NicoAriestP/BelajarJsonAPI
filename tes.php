<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes</title>
</head>
<body>
    <?php 
        $tahun = 2021;

        // master
        $kategori = array("makanan", "minuman");
        $bulan = array(
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
        );

        // menu
        $getMenu = file_get_contents('menu.json');
        $menu = json_decode($getMenu);

        // transaksi
        $getTrans = file_get_contents("tes_".$tahun.".json");
        $trans = json_decode($getTrans);

        $arrayTotalPerBulan = array();
    ?>

    <table border="1" cellspacing="0" cellpadding="10" width="100%">
        <thead>
            <tr>
                <td rowspan="2">Menu</td>
                <td colspan="<?php echo count($bulan) ?>">Periode <?=$tahun?></td>
                <td rowspan="2">Total</td>
            </tr>
            <tr>
                <?php foreach($bulan as $keybulan => $valbulan) {  ?>
                    <td><?php echo $valbulan['nama']; ?></td>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach($kategori as $keykategori => $valkategori ){ 
                $namaKategori = $valkategori;
            ?>
                <tr>
                    <td colspan="<?php echo count($bulan) + 2 ?>" style="background-color:#d1d2d4;text-transform:capitalize"><?php echo $namaKategori ?></td>
                </tr>
                <?php 
                    for ($j=0; $j < count($menu); $j++) {
                    //[$j]=indeks array. kategori = akses key objek 
                        var_dump($menu[$j]->kategori);
                        if($menu[$j]->kategori == $namaKategori) {
                ?>
                            <tr>
                                <td><?php echo $menu[$j]->menu; ?></td>
                                <?php 
                                    for ($ib=0; $ib < count($bulan) ; $ib++) {
                                        // karna index dimulai dari 0 maka +1 biar sesuai misal 1 = januari, 2=februari, dst
                                        $bulanKe = $ib+1;
                                        // ini formatnya jadi 2021-01 terus di filter dibawah

                                        $filterTahunBulan = $tahun."-".sprintf("%02d", $bulanKe);
                                        echo $filterTahunBulan;

                                        $subTotalPerBulanByKategori = 0;
                                        $subTotalPerBulan = 0;
                                        $subTotalPerKategori = 0;

                                        for ($t=0; $t < count($trans) ; $t++) { 
                                            // explode berfungsi untuk memecahkan string jadi array dengan pemisah, dibawah ini pemisahnya strip "-"
                                            $tanggalPesan = explode("-", $trans[$t]->tanggal);

                                            // $tanggalPesan[0] = tahunnya (misal: 2021)
                                            // $tanggalPesan[1] = bulannya (misal 01)
                                            $tanggalPesanTahunBulan = $tanggalPesan[0]."-".$tanggalPesan[1];
                                            

                                            // filter total per bulan berdasarkan kategori
                                            if($menu[$j]->menu==$trans[$t]->menu&&$filterTahunBulan==$tanggalPesanTahunBulan){
                                                $subTotalPerBulanByKategori += $trans[$t]->total;
                                            }
                                            
                                            // filter total per bulan
                                            if($filterTahunBulan==$tanggalPesanTahunBulan){
                                                $subTotalPerBulan += $trans[$t]->total;
                                            }

                                            // filter total beradasarkan kategori
                                            if($menu[$j]->menu==$trans[$t]->menu){ 
                                                $subTotalPerKategori += $trans[$t]->total;
                                            }
                                        }

                                        $bulan[$ib]['totalPerBulan'] = $subTotalPerBulan;
                                        $menu[$j]->totalPerKategori = $subTotalPerKategori;

                                ?>
                                    <?php if ($subTotalPerBulanByKategori == 0) {
                                        ?>
                                        <td> </td>
                                        <?php }else{ ?>
                                    <td><?php echo $subTotalPerBulanByKategori; ?></td>
                                <?php 
                            }
                                    } 
                                ?>

                                <td><?php echo $subTotalPerKategori; ?></td>
                            </tr>
                <?php
                        }
                    }
                ?>
            <?php 
                }
            ?>

            <!-- total -->
            <tr>
                <td>Total</td>
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
</body>
</html>