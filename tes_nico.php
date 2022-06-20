<?php
                    $transaksi = file_get_contents('tes_2021.json');
     
                    $decoded_trans = json_decode($transaksi,TRUE);
                    foreach ($decoded_trans[0] as $key => $value) {
                      foreach ($value as $key => $juml){
                        echo ($juml['total']);
                      }
                    }
                      ?>
