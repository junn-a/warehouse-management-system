<div class="panel panel-default">
	<div class="panel-heading">
		<b>Scan Here - Transfer to Logistik</b>
	</div>
	
	<div class="panel-body">
		<h3>Doc <?=$_GET['id']?></h3>
		<form action="page/gateLog/cetakLabel.php" method="post">
			<div hidden>
				<input type="text" class="form-control" name="id_doc" value="<?=$_GET['id']?>">
			</div>
				<input type="text" class="form-control" name="nomor_label" autofocus required>
			<div hidden>
				<input type="submit" class="form-control kirim">
			</div>
		</form>
	</div>
	<div class="tampil-data">
	</div>
</div>
<script src="assets/js/jquery-3.3.1.js"></script>
<script>
	$(".kirim").click(function(){
			var id = <?=$_GET['id']?>;
			var post = 'id='+id;
			
			$.ajax({
					type:"post",
					url: "page/gateLog/loaderContent.php", 
					data:post,
					success: function(result){
				  $(".tampil-data").html(result);
			}});
	});
	
</script>