	<div class="panel panel-default">
		<div class="panel-heading" style="height:auto">			
			<a href="?page=wip" style="pading-bottom:5px" class="btn btn-warning btn-sm"><span class="fa fa-arrow-left"></span> Back</a>
			<div></div>
		</div>
		
		<div class="panel-body">
		<?php
		
			$id = [];
			$shift = [];
			$selectData = pg_query($conn,"SELECT * FROM tbl_load_fg");
			
			while($showData 	= pg_fetch_array($selectData)){
				$id[] = $showData['id'];
				$shift[] = $showData['nomor_label'];
			}
			//print_r($id);
			
			$arrData = array(); //array declare
			
				//input data 1 s/d 200
				for($i=4000;$i<=4549;$i++){
					array_push($arrData,array(
							'number' => $i,
							'status'=>'#607d8b'
						)
					);
				}
			
//database data
$noUrut = $id;


//looping data 1 s/d 200
for($i=0;$i<count($arrData);$i++){

	//check the data if same data change red to green
	for($j=0;$j<count($noUrut);$j++){
		if($arrData[$i]['number'] == $noUrut[$j]){
			$no = $arrData[$i]['number'];
			$selectNo = pg_query($conn,"SELECT * FROM tbl_load_fg WHERE id=$no");
			$fetchShift = pg_fetch_assoc($selectNo);
			if($fetchShift['shift']==1){
				$arrData[$i]['status'] = '#0f2a10';
				$produk 		= substr($fetchShift['nomor_label'],24,7);
				$brand 			= substr($fetchShift['nomor_label'],9,3);
				$namaProduk 	= substr($fetchShift['nomor_label'],13,6);
				$singkatan		= substr($fetchShift['nomor_label'],13,3);
			}elseif($fetchShift['shift']==2){
				$arrData[$i]['status'] = '#1b2b73';
				$produk 		= substr($fetchShift['nomor_label'],24,7);
				$brand 			= substr($fetchShift['nomor_label'],9,3);
				$namaProduk 	= substr($fetchShift['nomor_label'],13,6);
				$singkatan		= substr($fetchShift['nomor_label'],13,3);
			}elseif($fetchShift['shift']==3){
				$arrData[$i]['status'] = '#ff9800';
				$produk 		= substr($fetchShift['nomor_label'],24,7);
				$brand 			= substr($fetchShift['nomor_label'],9,3);
				$namaProduk 	= substr($fetchShift['nomor_label'],13,6);
				$singkatan		= substr($fetchShift['nomor_label'],13,3);
			}elseif($fetchShift['shift']==4){
				$arrData[$i]['status'] = 'white';
				$produk = $fetchShift['nomor_label'];
				$produk = substr($fetchShift['nomor_label'],9,-2);
			}else{
				$arrData[$i]['status'] = '#607d8b';
			}
		}
	}

	//jus print
	if($arrData[$i]['status'] == '#607d8b'){
		?>
	<a href="?page=cetakLabelWip&aksi=scanBarcode&idUrut=<?=$arrData[$i]['number']?>&id=1" style="width:40px;height:40px;background-color:<?=$arrData[$i]['status']?>;float:left;margin:2px;color:white;text-align:center;text-decoration:none;font-size:12px"></a>
	<?php
	}elseif($arrData[$i]['status'] == 'white'){?>
		<div style="width:40px;height:40px;background-color:<?=$arrData[$i]['status']?>;float:left;margin:2px;color:white;text-align:center;text-decoration:none;" data-toggle="tooltip" data-placement="top" title="<?=$fetchShift['nomor_label']."|".$arrData[$i]['number']?>"></div>
	<?php }elseif($arrData[$i]['status'] == '#ff9800'){
		?>
	<div style="width:40px;height:40px;background-color:<?=$arrData[$i]['status']?>;float:left;margin:2px;color:black;text-align:center;text-decoration:none;"><div style="font-size:10px"><?=$singkatan?></div><div style="font-size:9px"><?=$produk?></div></div>
	<?php
	}
	else{
		?>
	<div style="width:40px;height:40px;background-color:<?=$arrData[$i]['status']?>;float:left;margin:2px;color:white;text-align:center;text-decoration:none;"><div style="font-size:10px"><?=$singkatan?></div><div style="font-size:9px"><?=$produk?></div></div>
	<?php
	}
} 
		?>
		</div>
	</div>
