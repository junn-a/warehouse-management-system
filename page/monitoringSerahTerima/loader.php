<?php
	include "../../connection.php";
	session_start();
	$time 		= date("His");
	if($_SESSION['shift'] == 3 AND $time >0 AND $time < 70000){
		$date = date('Y-m-d', strtotime("-1 day", strtotime($date )));
		 $selectLabel = pg_query($conn,"SELECT serah_terima.*, master_produk.nama_produk  FROM serah_terima INNER JOIN master_produk ON serah_terima.kode_material=master_produk.kode_material WHERE serah_terima.tanggal_produksi='$date' AND serah_terima.shift='$_SESSION[shift]' AND serah_terima.regu='$_SESSION[regu]' AND serah_terima.jam<='22:00:00' ORDER BY serah_terima.jam DESC LIMIT 20");
	}else{
		$date	 	= date("Y-m-d");
		$selectLabel = pg_query($conn,"SELECT serah_terima.*, master_produk.nama_produk  FROM serah_terima INNER JOIN master_produk ON serah_terima.kode_material=master_produk.kode_material WHERE serah_terima.tanggal_produksi='$date' AND serah_terima.shift='$_SESSION[shift]' AND serah_terima.regu='$_SESSION[regu]' ORDER BY serah_terima.jam DESC LIMIT 20");
	}
    $no     = 1;   
?>			
		<div class="table-responsive">
			<table class="table table-bordered" >
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>No Label</th>
                        <th>SKU</th>
                        <th style="text-align:center">Print Out</th>
                        <th style="text-align:center">Terima FG</th>
						<th style="text-align:center">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $arrayData = array();
                    $showLabel = pg_fetch_all($selectLabel);
                    foreach($showLabel AS $key => $value){
                        $arrayData[$value['nomor_label']]= array(
                            'nomor_label' => $value['nomor_label'],
                            'nama_produk' => $value['nama_produk'],
                            'jam_cetak'   => $value['jam'],
							'jumlah'	  => $value['jumlah']
                        );
                        $selectJam = pg_query($conn,"SELECT * FROM tbl_gate_fg WHERE nomor_label='$value[nomor_label]'");
                        $row = pg_fetch_assoc($selectJam);
                        $isi ="-";
                        if(!empty($row)){
                            $isi = $row['jam'];
                        }
                        $arrayData[$value['nomor_label']]['jam_gate_fg'] = $isi;
                    }
                   foreach($arrayData AS $table => $tab){?>
				  
                    <tr <?php if($tab['jam_gate_fg'] == "-"){echo "style='color:white;background-color:red'";} ?>>
                        <td><?=$no++?></td>
                        <td><?=$tab['nomor_label']?></td>
                        <td><?=$tab['nama_produk']?></td>
                        <td style="text-align:center"><?=$tab['jam_cetak']?></td>
                        <td style="text-align:center"><?=$tab['jam_gate_fg']?></td>
						<td style="text-align:center"><?=$tab['jumlah']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
		</div>
			