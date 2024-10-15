<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $hal; ?> · Aplikasi Peminjaman Ruang Rapat</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>">
	<link rel="icon" href="<?php echo base_url('assets/img/gambar.png'); ?>">
	<script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/login.js'); ?>"></script>
</head>
<body>

	<div class="container-fluid">

		<div class="row baris-utama">

			<!-- Kolom Offset -->
			<div class="col-sm-2-offset col-sm-2"></div>
			<!-- Kolom Offset -->

			<div class="col-sm-8 kotak-login clearfix">
				<!-- Kolom Gambar Selamat Datang -->
				<div class="gambar-login" style="background-image: url('<?php echo base_url('assets/img/interiornew.jpg'); ?>');">
					
				</div>

				<!-- Kolom Gambar Selamat Datang -->
				
				<!-- Form Login -->
				<div class="login-form">
				<img src="<?php echo base_url('assets/img/gambar.png'); ?>" alt="gambar" style="width: 30%;" />
					<h3>Peminjaman Ruangan Rapat</h3>

					<?php echo form_open('login/proses'); ?>
					<ul>
						<li>
							<input type="text" name="username" placeholder="Nama pengguna" required />
						</li>
						<li>
							<input type="password" name="password" placeholder="Kata sandi" required />
						</li>
						<li>
							<input type="submit" name="tombol_login" value="Login" />
						</li>
					</ul>
					<?php echo form_close(); ?>
				</div>
				<!-- Form Login -->
			</div>
			
		</div>

		<div class="row baris-footer">
			<!-- Kolom Copyright -->
			
			<!-- Kolom Copyright -->
		</div>

	</div>

</body>
</html>