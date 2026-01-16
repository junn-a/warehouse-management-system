		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable">
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
						<th>Isi</th>
						<th>Size</th>
						<th>Rasa</th>
						<th>Singkatan</th>
						<th>Brand</th>
						<th style="text-align:center">Detail</th>
						<th style="text-align:center">Edit</th>
						<th style="text-align:center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
					include "../../connection.php";
					session_start();
					$no 			= 1;
					$arrayData 		= array(); 
					
					
					$selectMasterJadwalProduksi = mysqli_query($conn3,"SELECT * FROM master_produk ORDER BY nama_produk ASC");
					$dataMasterJadwalProduksi	= mysqli_fetch_all($selectMasterJadwalProduksi, MYSQLI_ASSOC);
					
					foreach($dataMasterJadwalProduksi AS $key => $value){
						$arrayData[$value['kode_material']]=array(
							'kode_material' 	=> $value['kode_material'],
							'nama_produk' 		=> $value['nama_produk'],
							'isi'				=> $value['isi'],
							'size'				=> $value['size'],
							'rasa'				=> $value['rasa'],
							'singkatan'			=> $value['singkatan'],
							'brand'				=> $value['brand']
						);
					}
					foreach($arrayData AS $table => $tab){
				   ?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$tab['kode_material']?></td>
						<td><?=$tab['nama_produk']?></td>
						<td><?=$tab['isi']?></td>
						<td><?=$tab['size']?></td>
						<td><?=$tab['rasa']?></td>
						<td><?=$tab['singkatan']?></td>
						<td><?=$tab['brand']?></td>
						<td style="text-align:center"><a href="?page=jadwalProduksi&aksi=detail&id=<?=$tab['kode_material']?>" class="btn btn-info"><span class="fa fa-th-list"></span></a></td>
						<td style="text-align:center"><a href="?page=jadwalProduksi&aksi=detail&id=<?=$tab['kode_material']?>" class="btn btn-warning"><span class="fa fa-edit"></span></a></td>
						<td style="text-align:center"><a href="?page=jadwalProduksi&aksi=detail&id=<?=$tab['kode_material']?>" class="btn btn-danger"><span class="fa fa-trash"></span></a></td>
					</tr>
					<?php }?>
                </tbody>
            </table>
		</div>