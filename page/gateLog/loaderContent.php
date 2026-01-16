							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>No</th>
											<th>Kode Material</th>
											<th>SKU</th>
											<th>Jumlah GI</th>
											<th>Act Carton</th>
											<th>Act Pallet</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$id = $_POST['id'];
											include "../../connection.php";
											$noNew = 1;
											$selectDet = pg_query($conn,"SELECT tbl_detail_master_gi.*, master_produk.nama_produk FROM tbl_detail_master_gi INNER JOIN master_produk ON tbl_detail_master_gi.kode_material=master_produk.kode_material WHERE tbl_detail_master_gi.id_doc='$id'");
											$arrayData = array();
											$data = pg_fetch_all($selectDet);
											foreach($data AS $key => $value){
												$arrayData[$value['kode_material']] = array(
													'kode_material'	=> $value['kode_material'],
													'sku' 			=> $value['nama_produk'],
													'id_doc'  		=> $value['id_doc'],
													'jumlah' 		=> $value['jumlah']
												);
												// Act Carton
												$selectJmlAct = pg_query($conn,"SELECT SUM(serah_terima.jumlah) AS jml_act FROM serah_terima INNER JOIN tbl_gate_logistik ON serah_terima.nomor_label=tbl_gate_logistik.nomor_label WHERE tbl_gate_logistik.id_doc=$id AND serah_terima.kode_material='$value[kode_material]'");
												$row = pg_fetch_array($selectJmlAct);
												$isi ="-";
												if(!empty($row)){
													$isi = $row['jml_act'];
												}
												$arrayData[$value['kode_material']]['jml_act'] = $isi;
												// Act Pallet
												$selectActPallet = pg_query($conn,"SELECT COUNT(serah_terima.jumlah) AS act_pallet FROM serah_terima INNER JOIN tbl_gate_logistik ON serah_terima.nomor_label=tbl_gate_logistik.nomor_label WHERE tbl_gate_logistik.id_doc=$id AND serah_terima.kode_material='$value[kode_material]'");
												$row2 = pg_fetch_array($selectActPallet);
												$isi2 ="-";
												if(!empty($row2)){
													$isi2 = $row2['act_pallet'];
												}
												$arrayData[$value['kode_material']]['act_pallet'] = $isi2;
											}
											foreach($arrayData AS $table => $tab){
										?>
										<tr>
											<td><?=$noNew++?></td>
											<td><?=$tab['kode_material']?></td>
											<td><?=$tab['sku']?></td>
											<td><?=$tab['jumlah']?></td>
											<td><?=$tab['jml_act']?></td>		
											<td><?=$tab['act_pallet']?></td>
										</tr>
										<?php }?>
									</tbody>	
								</table>
							</div>