<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TES 2</title>
</head>
<body>
<?php 
	$getSekolah = file_get_contents('tes_venturo.json');
    $sekolah = json_decode($getSekolah);
    error_reporting(0);
    // var_dump($sekolah);
    // for ($i=0; $i < count($sekolah); $i++) { 
    // 	echo $sekolah[$i]."<br>";
    // }
    $tingkat = "SMA";
    foreach ($sekolah as $key => $value) {
    	// echo var_dump($key)."<br>";
        $expkey = explode(" ",$key);
        if ($expkey[0]==$tingkat) {
            echo $key.": ".$value->alamat."<br>";
            echo $key.": ".$value->tlp."<br>";
            if ($value->siswa == null) {
                echo "Tidak ada siswa <br>";
                }else{
                    foreach ($value->siswa as $key2 => $value2) {
                         echo $value2->nis."<br>";
                         echo $value2->nama."<br>";
                         echo $value2->tgl_lahir."<br>";
                }

            }
            echo "<hr>";

        }

    }
    // foreach ($sekolah as $key2 => $value2) {
    //             echo $key2.": ".$value2->alamat."<br>";
    //         }
     ?>
</body>
</html>
<!-- 
1.get tingkat
2.pecahkey

-->