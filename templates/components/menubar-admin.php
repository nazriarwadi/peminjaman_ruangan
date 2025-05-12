<?php
// Pastikan variabel $hal dan $tb tersedia
// $hal: Nama halaman aktif (misalnya, "Beranda", "Data Peminjaman")
// $tb: Array data peminjaman dari database
?>
<!-- Menubar Admin: Bagian Umum -->
<ul>
	<li <?php if ($hal == "Beranda")
		echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard'); ?>">Dashboard</a>
	</li>
	<li <?php if ($hal == "Kelola Akun Pengguna")
		echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/akun-pengguna'); ?>">Akun Pengguna</a>
	</li>
	<li <?php if ($hal == "Kelola Data Ruangan")
		echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/data-ruangan'); ?>">Data Ruangan</a>
	</li>
	<li <?php if ($hal == "Data Peminjaman" || $hal == "Laporan Peminjaman")
		echo "class='active'"; ?>>
		<a href="<?php echo base_url('dashboard/data-peminjaman'); ?>">Data Peminjaman
			<?php if ($hal == "Data Peminjaman"): ?>
				<?php
				// Hitung jumlah peminjaman dengan status "Menunggu"
				$jumlah_menunggu = 0;
				foreach ($tb as $baris) {
					if ($baris['status_pinjam'] == "Menunggu") {
						$jumlah_menunggu++;
					}
				}
				// Tampilkan badge hanya jika ada peminjaman dengan status "Menunggu"
				if ($jumlah_menunggu > 0): ?>
					<span class="badge badge-pill badge-secondary"><?php echo $jumlah_menunggu; ?></span>
				<?php endif; ?>
			<?php endif; ?>
		</a>
	</li>
</ul>