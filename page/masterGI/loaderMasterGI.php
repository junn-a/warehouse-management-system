		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable">
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>No Doc</th>
                        <th>Shift/Regu</th>
						<th>Tanggal</th>
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
					$date   		= date("Y-m-d");
					$jam 			= date("Gis");
					if(@$_SESSION['shift']==3 && $jam > 0 && $jam <70000){
						$tgl = date('Y-m-d', strtotime("-1 day", strtotime($date )));
						$dateNoLabel 	= date('dm', strtotime("-1 day", strtotime($date )));
						
					}else{
						$tgl = date('Y-m-d');
						$dateNoLabel 	= date('dm');
					}
						$selectMasterGI = pg_query($conn,"SELECT * FROM tbl_master_gi WHERE shift='$_SESSION[shift]' AND regu='$_SESSION[regu]' AND tanggal='$tgl' ORDER BY tanggal DESC");
						$dataMasterGI 	= pg_fetch_all($selectMasterGI);
					
					
					foreach($dataMasterGI AS $key => $value){
						$arrayData[$value['id_doc']]=array(
							'id_doc' 	=> $value['id_doc'],
							'tanggal' 	=> $value['tanggal'],
							'user' 		=> $value['id_user'],
							'shift' 	=> $value['shift'],
							'regu' 		=> $value['regu']
						);
						
						$jumlah = pg_query($conn,"SELECT SUM(jumlah) AS jml FROM tbl_detail_master_gi WHERE id_doc='$value[id_doc]'");
						$row = pg_fetch_assoc($jumlah);
						$isi = "-";
						if(!empty($row)){
							$isi = $row['jml'];
						}
						$arrayData[$value['id_doc']]['jml']=$isi;
					}
					foreach($arrayData AS $table => $tab){
				   ?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$tab['id_doc']?></td>
						<td><?=$tab['shift']."/".$tab['regu']?></td>
						<td><?=$tab['tanggal']?></td>
						<td><?=number_format($tab['jml'])?></td>
						<td style="text-align:center"><a href="?page=masterGI&aksi=detail&id=<?=$tab['id_doc']?>" class="btn btn-info"><span class="fa fa-th-list"></span></a></td>
					</tr>
					<?php }?>
                </tbody>
            </table>
		</div>