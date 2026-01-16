		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable">
                <thead style="background-color:#8bc34a;color:white">
                    <tr>
                        <th>No</th>
                        <th>No Doc</th>
						<th>Jumlah</th>
						<th style="text-align:center">Detail</th>
						<th style="text-align:center">Barcode</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
					include "../../connection.php";
					$no 			= 1;
					$arrayData 		= array();
					session_start();
					$jam 			= date("Gis");
					if(@$_SESSION['shift']==3 && $jam > 0 && $jam <70000){
						$tgl = date('Y-m-d', strtotime("-1 day", strtotime($date )));
						
					}else{
						$tgl = date('Y-m-d');
					}
					$selectMasterGI = pg_query($conn,"SELECT * FROM tbl_master_gi WHERE status=0");
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
						<td><?=number_format($tab['jml'])?></td>
						<td style="text-align:center"><a href="" data-toggle="modal" data-target="#info<?=$tab['id_doc']?>" class="btn btn-info detail" data-value="<?=$tab['id_doc']?>"><span class="fa fa-th-list"></span></a></td>
						<td style="text-align:center"><a href="?page=gateLog&aksi=barcode&id=<?=$tab['id_doc']?>" class="btn btn-warning"><span class="fa fa-barcode"></span></a></td>
					</tr>
					<!-- Modal Add-->
					<div id="info<?=$tab['id_doc']?>" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Doc <?=$tab['id_doc']?></h4>
								</div>
								<div class="modal-body">
									<div class="load-content"></div>
								</div>
								<div class="modal-footer">
									<a type="submit" class="btn btn-danger finish" data-value="<?=$tab['id_doc']?>">Finish</a>
								</div>
						  </div>
						</div>
					</div>
					<script src="assets/js/jquery-3.3.1.js"></script>
					<script src="assets/js/sweetalert.min.js"></script>
					<script type="text/javascript">
						$(".detail").click(function(){
							var id = $(this).data('value');
							var post = 'id='+id;
							
							$.ajax({
								type: "post",
								url	: "page/gateLog/loaderContent.php",
								data: post,
								success : function(ok){
									$(".load-content").html(ok);
								}
							});
						});
						
						$(".finish").click(function(){
							
							
							swal({
							  title: "Anda Yakin Sudah Selesai?",
							  text: "Jika Transfer No Dokumen ini sudah selesai, Klik Ok!",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							})
							.then((willDelete) => {
							  if (willDelete) {
									var id = $(this).data('value');
									var post1 = 'id='+id;
									
									$.ajax({
										type: "post",
										url	: "page/gateLog/saveFinish.php",
										data: post1,
										success : function(oke){
											//$(".load").html(oke);
											//window.location="index.php?page=gateLog&aksi=index";
											location.reload(); 
										}
									});
								//location.reload(); 
							  } else {
								swal("Transfer Belum Selesai!");
							  }
							});
						});
					</script>
					<?php }?>
                </tbody>
            </table>
		</div>
			
				