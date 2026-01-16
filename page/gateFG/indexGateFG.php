<?php
    $date   = date("Y-m-d");
    $jam    = date("H:i:s");
    $no     = 1;
?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Scan Barcode Gate FG</b>
		</div>
		<div class="panel-body">
			<form action="" method="post">
                <input type="text" class="form-control" name="nomor_label" autofocus>
            </form>
		</div>
		<div class="panel-body">
			<script src="assets/js/jquery-3.3.1.js"></script>
			<script type="text/javascript">
				$(document).ready(function(){
					setInterval(function(){
						$("#loaderData").load('page/gateFG/loader.php');
					},1000); 
				});
			</script>
			<div id="loaderData"></div>
		</div>
	</div>
<?php
    @$nomor_label = $_POST['nomor_label'];
    if(isset($nomor_label)){
	$updateStatus = pg_query($conn,"UPDATE serah_terima SET status=2 WHERE nomor_label='$nomor_label'");
        $selectData = pg_query($conn,"SELECT * FROM tbl_gate_fg WHERE nomor_label='$nomor_label'");
        $cek = pg_num_rows($selectData);
        if($cek < 1){
           
				$insertData = pg_query($conn,"INSERT INTO tbl_gate_fg VALUES(DEFAULT,'$date','$jam', '$nomor_label')");
				$id = 1;
				echo "<script>alert('Gate Opened');</script>";
			
        }else{
            $id = 0;
            echo "<script>alert('Kode Salah');</script>";            
        }
        
    }
?>
