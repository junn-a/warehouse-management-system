<?php
	$id = $_POST['id'];
?>
		
		<table class="table table-bordered" id="dataTable">
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>Kode Material</th>
                        <th>Nama Produk</th>
						<th>Jumlah</th>
						<th style="text-align:center">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
					include "../../connection.php";
					//$selectDetailMasterGI 	= pg_query($conn,"SELECT tbl_detail_master_gi.*, master_produk.nama_produk FROM tbl_detail_master_gi, master_produk WHERE tbl_detail_master_gi.id_doc='$id' && master_produk.kode_material=tbl_detail_master_gi.kode_material");
					
					$selectDetailMasterGI 	= pg_query($conn,"SELECT tbl_detail_master_gi.*, master_produk.nama_produk FROM tbl_detail_master_gi  INNER JOIN master_produk ON master_produk.kode_material=tbl_detail_master_gi.kode_material WHERE tbl_detail_master_gi.id_doc='$id'");
					$no = 1;
					while($fetchDetailMasterGI = pg_fetch_array($selectDetailMasterGI)){
				   ?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$fetchDetailMasterGI['kode_material']?></td>
						<td><?=$fetchDetailMasterGI['nama_produk']?></td>
						<td><?=$fetchDetailMasterGI['jumlah']?></td>
						<td style="text-align:center"><a href="?page=masterGI&aksi=hapus&id2=<?=$fetchDetailMasterGI['id_detail']?>&id1=<?=$id?>" class="btn btn-danger"><span class="fa fa-trash"></span></button></td>
					</tr>
				   <?php 
					}
				   ?>
                </tbody>
            </table>
			