		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable">
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
						<th>Week</th>
						<th>Jumlah</th>
						<th style="text-align:center">Detail</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
					include "../../connection.php";
					session_start();
					$no 			= 1;
					$arrayData 		= array(); 
					$jam 			= date("Gis");
					if(@$_SESSION['shift']==3 && $jam > 0 && $jam <70000){
						$tgl = date('Y-m-d', strtotime("-1 day", strtotime($date )));
						$dateNoLabel 	= date('dm', strtotime("-1 day", strtotime($date )));
						
					}else{
						$tgl = date('Y-m-d');
						$dateNoLabel 	= date('dm');
					}
					
					$selectMasterJadwalProduksi = pg_query($conn,"SELECT * FROM master_jadwal ORDER BY tanggal_jadwal DESC LIMIT 10");
					$dataMasterJadwalProduksi	= pg_fetch_all($selectMasterJadwalProduksi);
					
					foreach($dataMasterJadwalProduksi AS $key => $value){
						$arrayData[$value['tanggal_jadwal']]=array(
							'tanggal_jadwal' 	=> $value['tanggal_jadwal'],
							'jam' 				=> $value['jam'],
							'week'				=> $value['week']
						);
						
						$jumlah = pg_query($conn,"SELECT SUM(jumlah) AS jml FROM detil_jadwal WHERE tanggal_jadwal='$value[tanggal_jadwal]'");
						$row = pg_fetch_assoc($jumlah);
						$isi = "-";
						if(!empty($row)){
							$isi = $row['jml'];
						}
						$arrayData[$value['tanggal_jadwal']]['jml']=$isi;
					}
					foreach($arrayData AS $table => $tab){
				   ?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$tab['tanggal_jadwal']?></td>
						<td><?=$tab['jam']?></td>
						<td><?=$tab['week']?></td>
						<td><?=number_format($tab['jml'])?></td>
						<td style="text-align:center"><a href="?page=jadwalProduksi&aksi=detail&id=<?=$tab['tanggal_jadwal']?>" class="btn btn-info"><span class="fa fa-th-list"></span></a></td>
					</tr>
					<?php }?>
                </tbody>
            </table>
		</div>