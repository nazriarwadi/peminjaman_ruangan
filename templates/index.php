<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $hal; ?> · Aplikasi Peminjaman Ruang Rapat</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/linearicons.min.css'); ?>">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
		integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="icon" href="<?php echo base_url('assets/img/form.png'); ?>">
	<script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
</head>

<body>
	<div class="container-fluid">
		<!-- Baris Menubar dan Dropdown Profil -->
		<div class="row menubar-bg">
			<div class="col-sm-1 col-sm-1-offset"></div>
			<div class="col-sm-7 menubar"><?php echo $menubar; ?></div>
			<div class="col-sm-3"><?php echo $dropdown; ?></div>
		</div>

		<!-- Baris Judul -->
		<div class="row">
			<div class="col-sm-1 col-sm-1-offset"></div>
			<div class="col-sm-10 title-pg">
				<div class="main-title"><?php echo $hal; ?></div>

				<?php if ($hal == "Kelola Akun Pengguna"): ?>
					<div class="button-add">
						<a href="" data-toggle="modal" data-target="#buatuser" data-backdrop="static"><i
								class="fas fa-user-plus"></i></a>
					</div>
				<?php endif; ?>

				<?php if ($hal == "Kelola Data Ruangan"): ?>
					<div class="button-add">
						<a href="" data-toggle="modal" data-target="#buatruangan" data-backdrop="static"><i
								class="fas fa-plus-circle"></i></a>
					</div>
				<?php endif; ?>

				<?php if ($hal == "Data Peminjaman"): ?>
					<div class="data-peminjaman-container">
						<?php if ($this->session->userdata('level') == "Bagian Umum" || $this->session->userdata('level') == "Pengguna Ruangan"): ?>
							<div class="button-add">
								<a href="" data-toggle="modal" data-target="#ajukanpinjam" data-backdrop="static"><i
										class="fas fa-plus-circle"></i></a>
							</div>
						<?php endif; ?>

						<?php if ($this->session->userdata('level') == "Bagian Umum"): ?>
							<div class="button-datapick">
								<a href="" data-toggle="modal" data-target="#lap-peminjaman" data-backdrop="static">Pilih
									Rentang Waktu</a>
								<a href="<?php echo base_url('dashboard/cetak_semua_laporan_pdf'); ?>" class="btn-cetak"><i
										class="fas fa-print"></i> Cetak PDF</a>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<style>
					/* New container style to align items horizontally */
					.data-peminjaman-container {
						display: flex;
						align-items: center;
						gap: 10px;
						/* Keep the same gap as in button-datapick for consistency */
					}

					/* Existing styles remain unchanged */
					.button-datapick {
						display: flex;
						align-items: center;
						gap: 10px;
						/* Jarak antar tombol */
					}

					.button-datapick .btn-cetak {
						margin-left: auto;
						/* Dorong ke ujung kanan */
					}

					.button-datapick .btn-cetak i {
						margin-right: 5px;
						/* Jarak antara ikon dan teks */
					}
				</style>

				<?php if ($hal == "Riwayat Akses Ruangan"): ?>
					<?php if ($this->session->userdata('level') == "Bagian Umum"): ?>
						<div class="button-datapick">
							<a href="<?php echo base_url('dashboard/unduh-akses-ruangan'); ?>"><span
									class="lnr lnr-download"></span> Unduh Data</a>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ($hal == "Laporan Peminjaman"): ?>
					<?php if ($this->session->userdata('level') == "Bagian Umum"): ?>
						<div class="button-datapick">
							<a href="" data-toggle="modal" data-target="#unduh-lap-peminjaman" data-backdrop="static"><span
									class="lnr lnr-download"></span> Unduh Data</a>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>

		<!-- Baris Konten -->
		<div class="row">
			<div class="col-sm-1 col-sm-1-offset"></div>
			<div class="col-sm-10 outer-main">
				<div class="main"><?php echo $content; ?></div>
			</div>
		</div>

		<!-- Baris Copyright -->
		<div class="row footer">

		</div>
	</div>
</body>

</html>