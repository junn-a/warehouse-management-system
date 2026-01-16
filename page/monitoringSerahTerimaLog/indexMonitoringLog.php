<?php
	
	if($_SESSION['shift'] == 1){
		$shift 		= 3;
		$dateNow 	= date('Y-m-d', strtotime("-1 day", strtotime($date )));
	}else{
		$shift 		= $_SESSION['shift']-1;
		$dateNow 	= date("Y-m-d");
	}
	
	//$selectLabel = pg_query($conn,"SELECT SUM(serah_terima.jumlah) AS jml ,serah_terima.nomor_label, master_produk.nama_produk ,master_produk.brand  FROM serah_terima, master_produk WHERE serah_terima.kode_material=master_produk.kode_material && serah_terima.shift='$shift' && serah_terima.tanggal_produksi='$dateNow' GROUP BY serah_terima.kode_material ORDER BY master_produk.brand ASC");
	
	$selectLabel = pg_query($conn,"SELECT SUM(serah_terima.jumlah) AS jml , serah_terima.jumlah, serah_terima.kode_material, serah_terima.nomor_label, master_produk.nama_produk ,master_produk.brand  FROM serah_terima INNER JOIN master_produk ON serah_terima.kode_material=master_produk.kode_material WHERE serah_terima.shift='$shift' AND serah_terima.tanggal_produksi='$dateNow'  GROUP BY serah_terima.kode_material, master_produk.nama_produk , serah_terima.jumlah, serah_terima.nomor_label , master_produk.brand ORDER BY master_produk.brand ASC");
	
    $no     = 1;   
?>
<!--
<script type="text/javascript">
	    function reload(){
	    	document.location.reload();
	    }
		setTimeout(reload,2000);
	</script>-->
	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Monitoring Serah Terima FG to Logistik</b>
		</div>
		<div class="panel-body">
			<table class="table table-bordered" style="float:left;width:50%">
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>SKU</th>
                        <th style="text-align:center">In Transit (Car)</th>
						<th style="text-align:center">Logistik (Car)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $arrayData = array();
                    $showLabel = pg_fetch_all($selectLabel);
						foreach($showLabel AS $key => $value){
							$arrayData[$value['nomor_label']]= array(
								'nomor_label' 	=> $value['nomor_label'],
								'nama_produk' 	=> $value['nama_produk'],
								'kode_material' => $value['kode_material'],
								'jml'  		  	=> $value['jml'],
								'jumlah'	  	=> $value['jumlah']
							);
							// Terima Logistik
							$selectJmlLog = pg_query($conn,"SELECT SUM(jumlah) AS jml_log FROM serah_terima WHERE nomor_label='$value[nomor_label]' AND status='3' GROUP BY kode_material='$value[kode_material]'");
							$rowLog = pg_fetch_assoc($selectJmlLog);
							$isiLog ="-";
							if(!empty($rowLog)){
								$isiLog = $rowLog['jml_log'];
							}
							$arrayData[$value['nomor_label']]['jml_log'] = $isiLog;
						}
					
                   foreach($arrayData AS $table => $tab){?>
				  
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$tab['nama_produk']?></td>
                        <td style="text-align:center"><?=$tab['jml']?></td>
						<td style="text-align:center"><?=$tab['jml_log']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
		</div>
	</div>
			