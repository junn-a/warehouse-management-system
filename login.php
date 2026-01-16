<?php
	include "connection.php";
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="icon" type="image/png" href="assets/img/user.png">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ProdIT | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="assets/plugins/iCheck/square/blue.css">

</head>
<body class="hold-transition login-page" style="background-image:url('assets/img/mountain.jpg');background-repeat: no-repeat;
  background-size:100% 100%;">
<div class="login-box" style="opacity:0.85">
  <div class="login-logo">
    <a href="#"><img src="assets/img/prodit2.png" width="250px"/></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="login_aksi.php" method="post">
       <div class="form-group has-feedback">
        <select class="form-control" name="username" required>
			<option value="">-Pilih User-</option>
			<?php
				$selectUser = pg_query($conn,"SELECT * FROM tbl_user");
				while($showUser = pg_fetch_array($selectUser)){
					echo "<option>".$showUser['username']."</option>";
				}
			?>
		<select>
      </div>
	  <div class="form-group has-feedback">
        <select class="form-control" name="kasie_prod" required>
			<option value="">-Pilih Kasie-</option>
			<?php
				$selectKasie = pg_query($conn,"SELECT * FROM tbl_kasie_prod");
				while($showKasie = pg_fetch_array($selectKasie)){
					echo "<option>".$showKasie['nama']."</option>";
				}
			?>
		<select>
      </div>
      <div class="form-group has-feedback">
        <select class="form-control" name="regu" required>
			<option value="">-Pilih Regu-</option>
			<option value="A">A</option>
			<option value="B">B</option>
			<option value="C">C</option>
			<option value="D">D</option>
			<option value="ALL">ALL</option>
		<select>
      </div>
	  <div class="form-group has-feedback">
        <select class="form-control" name="shift" required>
			<option value="">-Pilih Shift-</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="ALL">ALL</option>
		<select>
      </div>
	  <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
	  <div class="form-group has-feedback" hidden>
        <input type="text" class="form-control" placeholder="Password" name="jam_login" value="<?php echo $jam_login = date("H:i:s");?>">
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="assets/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
<!-- Sweetalert -->
<script src="assets/bower_components/sweetalert/sweetalert.min.js"></script>
</body>
</html>
