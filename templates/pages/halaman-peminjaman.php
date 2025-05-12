<?php date_default_timezone_set('Asia/Jakarta'); ?>

<!-- Notifikasi Flashdata [Awal] -->
<?php if ($this->session->flashdata('success')): ?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<?php echo $this->session->flashdata('success'); ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<?php echo $this->session->flashdata('error'); ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php endif; ?>
<!-- Notifikasi Flashdata [Akhir] -->

<!-- Daftar Data Peminjaman Ruang [Awal] -->
<table>
	<tr>
		<th>No.</th>
		<th>ID Peminjaman</th>
		<th>Pengguna</th>
		<th>Ruang</th>
		<th>Keterangan</th>
		<th>Instansi</th>
		<th>Waktu Pengajuan</th>
		<th>Tanggal Peminjaman</th>
		<th>Waktu Mulai</th>
		<th>Waktu Selesai</th>
		<th>Jumlah Orang</th>
		<th>Konsumsi</th>
		<th>Menu Konsumsi</th>
		<th>Status Peminjaman</th>
		<?php if ($this->session->userdata('level') != "Umum" && $this->session->userdata('level') != "Umum"): ?>
			<th>Aksi</th>
		<?php endif; ?>
	</tr>



	<?php if (empty($tb)): ?>
		<tr>
			<td align="center" colspan="9">Tidak ada data peminjaman.</td>
		</tr>
	<?php endif; ?>

	<?php $no = 1;
	foreach ($tb as $baris): ?>
		<tr>
			<td align="center"><?php echo $no; ?></td>
			<td align="center"><?php echo $baris['id_peminjaman']; ?></td>
			<td><?php echo $baris['peminjam']; ?></td>
			<td align="center"><?php echo $baris['ruangan_dipinjam']; ?></td>
			<td><?php echo $baris['keterangan']; ?></td>
			<td><?php echo $baris['instansi']; ?></td>
			<td align="center"><?php echo date('d/m/Y H:i', strtotime($baris['waktu_pengajuan'])); ?></td>
			<td align="center"><?php echo date('d/m/Y', strtotime($baris['tanggal_peminjaman'])); ?></td>
			<td align="center"><?php echo date('d/m/Y H:i', strtotime($baris['waktu_mulai'])); ?></td>
			<td align="center"><?php echo date('d/m/Y H:i', strtotime($baris['waktu_selesai'])); ?></td>
			<td align="center"><?php echo $baris['jumlah_orang']; ?></td>
			<td align="center"><?php echo $baris['konsumsi']; ?></td>
			<td align="center"><?php echo $baris['menu_konsumsi']; ?></td>
			<td align="center">
				<div>
					<?php echo $baris['status_pinjam']; ?>

					<?php if ($this->session->userdata('level') == "Bagian Umum" or $this->session->userdata('level') == "Pengguna Ruangan"): ?>
						<?php if ($baris['status_pinjam'] == 'Menunggu' && $this->session->userdata('level') == "Bagian Umum" or $baris['status_pinjam'] == 'Menunggu' && $this->session->userdata('level') == "Pengguna Ruangan" or $baris['status_pinjam'] == 'Disetujui' && $this->session->userdata('level') == "Bagian Umum"): ?>
							<a class="dropdown-status" id="dropdown-status" data-toggle="dropdown">…</a>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ($baris['status_pinjam'] != 'Selesai' && $baris['status_pinjam'] != 'Dibatalkan'): ?>
						<div <?php if ($baris['status_pinjam'] == 'Disetujui' && $this->session->userdata('level') == "Pengguna Ruangan" or $this->session->userdata('level') == "Biro Pendidikan" or $this->session->userdata('level') == "Kabag/Kaprodi")
							echo "class='sembunyikan'"; ?>
							class="dropdown-menu" aria-labelledby="dropdown-status">

							<?php if ($baris['status_pinjam'] == 'Menunggu'): ?>
								<?php if ($this->session->userdata('level') == "Bagian Umum"): ?>
									<a class="dropdown-item" href="" data-toggle="modal"
										data-target="#setujui<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static">Setujui</a>
								<?php endif; ?>

								<?php if ($this->session->userdata('level') == "Bagian Umum" or $this->session->userdata('level') == "Pengguna Ruangan"): ?>
									<a class="dropdown-item" href="" data-toggle="modal"
										data-target="#batalkan<?php echo $baris['id_peminjaman']; ?>"
										data-backdrop="static">Batalkan</a>
								<?php endif; ?>
							<?php endif; ?>

							<?php if ($baris['status_pinjam'] == 'Disetujui' && $this->session->userdata('level') == "Bagian Umum"): ?>
								<a class="dropdown-item" href="" data-toggle="modal"
									data-target="#selesaikan<?php echo $baris['id_peminjaman']; ?>"
									data-backdrop="static">Selesai</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</td>
			<?php if ($this->session->userdata('level') != "" && $this->session->userdata('level') != ""): ?>
				<td align="center">
					<div <?php if ($baris['status_pinjam'] == 'Selesai' or $baris['status_pinjam'] == 'Dibatalkan' or $baris['status_pinjam'] == 'Disetujui')
						echo "style='pointer-events: none; opacity: 0.35;'"; ?>
						class="mini-edit">
						<a href="" data-toggle="modal" data-target="#suntingpinjam<?php echo $baris['id_peminjaman']; ?>"
							data-backdrop="static"><span class="lnr lnr-pencil"></span></a>
					</div>
					<?php if ($this->session->userdata('level') == "Bagian Umum"): ?>
						<div class="mini-delete">
							<a href="" data-toggle="modal" data-target="#hapuspinjam<?php echo $baris['id_peminjaman']; ?>"
								data-backdrop="static"><span class="lnr lnr-trash"></span></a>
						</div>
					<?php endif; ?>
				</td>
			<?php endif; ?>
		</tr>


		<?php $no++; endforeach; ?>
</table>
<!-- Daftar Data Peminjaman Ruang [Akhir] -->


<!-- Fungsi untuk Cetak ID Peminjaman Otomatis [Awal] -->
<?php foreach ($tb_idpinjam as $baris_id): ?>
	<?php
	// Mengambil string setelah karakter ke-4 sebanyak 5 karakter
	$kode = substr($baris_id['id_peminjaman'], 4, 5);

	// Menambahkan 1 nilai
	$tambah = (int) $kode + 1;

	if ($tambah < 10) {
		$id_pinjam = "DPK-0000" . $tambah;
	} else {
		$id_pinjam = "DPK-000" . $tambah;
	}
?>
<?php endforeach; ?>
<!-- Fungsi untuk Cetak ID Peminjaman Otomatis [Akhir] -->


<!-- Modal Pengajuan Pinjam Ruang [Awal] -->
<div id="ajukanpinjam" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Ajukan Peminjaman Ruang
				<button type="button" class="close" data-dismiss="modal">
					<span class="lnr lnr-cross-circle"></span>
				</button>
			</div>
			<div class="modal-body">
				<?php if ($this->session->flashdata('error')): ?>
					<div class="alert alert-danger">
						<?php echo $this->session->flashdata('error'); ?>
					</div>
				<?php endif; ?>
				<?php echo form_open('dashboard/pinjam-ruang'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $id_pinjam; ?>">
					<li>
						<div><i class="lnr lnr-user"></i></div>
						<input type="text" value="<?php echo $id_pinjam; ?>" disabled />
					</li>
					<input type="hidden" name="peminjam" value="<?php echo $this->session->userdata('namalengkap'); ?>">
					<input type="hidden" name="waktu_pengajuan" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<div><i class="lnr lnr-apartment"></i></div>
						<input type="text" name="instansi" placeholder="Instansi" required />
					</li>
					<li>
						<div><i class="lnr lnr-layers"></i></div>
						<select name="nama_ruangan" required="required">
							<option value="" selected>Ruang</option>
							<?php foreach ($tb_ruangan as $baris_ruangan): ?>
								<?php if ($baris_ruangan['status'] == 'Tersedia'): ?>
									<option value="<?php echo $baris_ruangan['nama_ruangan']; ?>">
										<?php echo $baris_ruangan['nama_ruangan']; ?>
									</option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</li>
					<li>
						<div><i class="lnr lnr-users"></i></div>
						<input type="text" name="jumlah_orang" placeholder="Jumlah Orang" required="required" />
					</li>
					<!-- Bagian Konsumsi -->
					<li>
						<div><i class="lnr lnr-dinner"></i></div>
						<select id="konsumsi" name="konsumsi" required="required" onchange="toggleMenuOptions()">
							<option value="" selected>Konsumsi</option>
							<option value="perlu">Perlu</option>
							<option value="tidak">Tidak</option>
						</select>
					</li>
					<!-- Sub-opsi untuk jenis makanan -->
					<li id="menu-options" style="display:none;">
						<div><i class="lnr lnr-dinner"></i></div>
						<select name="menu_konsumsi">
							<option value="" selected>Pilih Menu</option>
							<option value="makanan_berat">Makanan Berat</option>
							<option value="makanan_ringan">Makanan Ringan</option>
						</select>
					</li>
					<li>
						<div><i class="lnr lnr-text-format"></i></div>
						<input type="text" name="keterangan" placeholder="Keterangan" required />
					</li>
					<!-- Form untuk Tanggal Peminjaman - UI Disamakan -->
					<li>
						<div><i class="lnr lnr-calendar-full"></i></div>
						<input type="text" name="tanggal_peminjaman" placeholder="Tanggal Peminjaman" required
							onfocus="(this.type='date')" />
					</li>
					<!-- Form untuk Jam Mulai dan Selesai - UI Disamakan -->
					<li>
						<div><i class="lnr lnr-clock"></i></div>
						<input type="text" name="waktu_mulai" placeholder="Waktu Mulai" required
							onfocus="(this.type='time')" />
					</li>
					<li>
						<div><i class="lnr lnr-clock"></i></div>
						<input type="text" name="waktu_selesai" placeholder="Waktu Selesai" required
							onfocus="(this.type='time')" />
					</li>
					<br />
					<hr />
					<li>
						<input type="submit" name="tombol_tambah" value="Ajukan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
			<div class="modal-footer">
				<span>Pastikan data telah terisi dengan benar.</span>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<!-- Modal Pengajuan Pinjam Ruang [Akhir] -->

<!-- Tambahkan JavaScript untuk menampilkan opsi menu konsumsi -->
<script>
	function toggleMenuOptions() {
		var konsumsi = document.getElementById("konsumsi").value;
		var menuOptions = document.getElementById("menu-options");
		menuOptions.style.display = (konsumsi === "perlu") ? "block" : "none";
	}
</script>


<!-- Modal Hapus Peminjaman Ruang [Awal] -->
<?php foreach ($tb as $baris): ?>
	<div id="hapuspinjam<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Konten Modal [Awal] -->
			<div class="modal-content">
				<div class="modal-header">
					Hapus Peminjaman Ruang
					<button type="button" class="close" data-dismiss="modal"><span
							class="lnr lnr-cross-circle"></span></button>
				</div>

				<div class="modal-body">
					<?php echo form_open('dashboard/hapus-peminjaman'); ?>
					<ul>
						<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
						<li>
							<p>Apakah Anda yakin ingin menghapus peminjaman
								<span><?php echo $baris['id_peminjaman']; ?></span> dari sistem?
							</p>
						</li>
						<br />
						<li>
							<input type="submit" name="tombol_hapus" value="Hapus" />
						</li>
					</ul>
					<?php echo form_close(); ?>
				</div>
			</div>
			<!-- Konten Modal [Akhir] -->
		</div>
	</div>
<?php endforeach; ?>
<!-- Modal Hapus Peminjaman Ruang [Akhir] -->


<!-- Modal Penyetujuan Peminjaman Ruang [Awal] -->
<?php foreach ($tb as $baris): ?>
	<div id="setujui<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Konten Modal [Awal] -->
			<div class="modal-content">
				<div class="modal-header">
					Setujui Peminjaman Ruang
					<button type="button" class="close" data-dismiss="modal"><span
							class="lnr lnr-cross-circle"></span></button>
				</div>

				<div class="modal-body">
					<?php echo form_open('dashboard/setujui-peminjaman'); ?>
					<ul>
						<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
						<input type="hidden" name="waktu_penyetujuan" value="<?php echo date('Y-m-d H:i:s'); ?>">
						<li>
							<p>Apakah Anda yakin ingin menyetujui pengajuan
								<span><?php echo $baris['id_peminjaman']; ?></span> untuk Ruang
								<?php echo $baris['ruangan_dipinjam']; ?>?
							</p>
						</li>
						<?php foreach ($tb_ruangan as $baris_ruangan): ?>
							<?php if ($baris_ruangan['status'] == 'Menunggu' && $baris_ruangan['nama_ruangan'] == $baris['ruangan_dipinjam']): ?>
								<input type="hidden" name="id_ruangan" value="<?php echo $baris_ruangan['id_ruangan']; ?>">
							<?php endif; ?>
						<?php endforeach; ?>
						<br />
						<li>
							<input type="submit" name="tombol_setujui" value="Setujui" />
						</li>
					</ul>
					<?php echo form_close(); ?>
				</div>
			</div>
			<!-- Konten Modal [Akhir] -->
		</div>
	</div>
<?php endforeach; ?>
<!-- Modal Penyetujuan Peminjaman Ruang [Akhir] -->


<!-- Modal Pembatalan Peminjaman Ruang [Awal] -->
<?php foreach ($tb as $baris): ?>
	<div id="batalkan<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Konten Modal [Awal] -->
			<div class="modal-content">
				<div class="modal-header">
					Batalkan Peminjaman Ruang
					<button type="button" class="close" data-dismiss="modal"><span
							class="lnr lnr-cross-circle"></span></button>
				</div>

				<div class="modal-body">
					<?php echo form_open('dashboard/batalkan-peminjaman'); ?>
					<ul>
						<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
						<input type="hidden" name="waktu_pembatalan" value="<?php echo date('Y-m-d H:i:s'); ?>">
						<li>
							<p>Apakah Anda yakin ingin membatalkan pengajuan
								<span><?php echo $baris['id_peminjaman']; ?></span> untuk Ruang
								<?php echo $baris['ruangan_dipinjam']; ?>?
							</p>
						</li>
						<?php foreach ($tb_ruangan as $baris_ruangan): ?>
							<?php if ($baris_ruangan['status'] == 'Menunggu' && $baris_ruangan['nama_ruangan'] == $baris['ruangan_dipinjam']): ?>
								<input type="hidden" name="id_ruangan" value="<?php echo $baris_ruangan['id_ruangan']; ?>">
							<?php endif; ?>
						<?php endforeach; ?>
						<br />
						<li>
							<input type="submit" name="tombol_batalkan" value="Batalkan" />
						</li>
					</ul>
					<?php echo form_close(); ?>
				</div>
			</div>
			<!-- Konten Modal [Akhir] -->
		</div>
	</div>
<?php endforeach; ?>
<!-- Modal Pembatalan Peminjaman Ruang [Akhir] -->


<!-- Modal Selesaikan Peminjaman Ruang [Awal] -->
<?php foreach ($tb as $baris): ?>
	<div id="selesaikan<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Konten Modal [Awal] -->
			<div class="modal-content">
				<div class="modal-header">
					Selesaikan Peminjaman Ruang
					<button type="button" class="close" data-dismiss="modal"><span
							class="lnr lnr-cross-circle"></span></button>
				</div>

				<div class="modal-body">
					<?php echo form_open('dashboard/selesaikan-peminjaman'); ?>
					<ul>
						<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
						<input type="hidden" name="waktu_pengembalian" value="<?php echo date('Y-m-d H:i:s'); ?>">
						<li>
							<p>Apakah Anda yakin ingin menyelesaikan pengajuan
								<span><?php echo $baris['id_peminjaman']; ?></span> untuk Ruang
								<?php echo $baris['ruangan_dipinjam']; ?>?
							</p>
						</li>
						<?php foreach ($tb_ruangan as $baris_ruangan): ?>
							<?php if ($baris_ruangan['status'] == 'Sedang digunakan' && $baris_ruangan['nama_ruangan'] == $baris['ruangan_dipinjam']): ?>
								<input type="hidden" name="id_ruangan" value="<?php echo $baris_ruangan['id_ruangan']; ?>">
							<?php endif; ?>
						<?php endforeach; ?>
						<br />
						<li>
							<input type="submit" name="tombol_selesaikan" value="Selesaikan" />
						</li>
					</ul>
					<?php echo form_close(); ?>
				</div>
			</div>
			<!-- Konten Modal [Akhir] -->
		</div>
	</div>
<?php endforeach; ?>
<!-- Modal Selesaikan Peminjaman Ruang [Akhir] -->


<!-- Modal Laporan Peminjaman Ruang [Awal] -->
<div id="lap-peminjaman" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Laporan Peminjaman Ruang
				<button type="button" class="close" data-dismiss="modal"><span
						class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/laporan-peminjaman'); ?>
				<ul>
					<li>
						<div><i class="lnr lnr-calendar-full"></i></div><input type="text" name="tgl_awal"
							class="datepicker-report" placeholder="Tanggal awal" required />
					</li>
					<li>
						<div><i class="lnr lnr-calendar-full"></i></div><input type="text" name="tgl_akhir"
							class="datepicker-report" placeholder="Tanggal akhir" required />
					</li>
					<br />
					<hr />
					<li>
						<input type="submit" value="Tampilkan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>

			<div class="modal-footer">
				<span>Pastikan data telah terisi dengan benar.</span>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<!-- Modal Laporan Peminjaman Ruang [Akhir] -->

<!-- JavaScript untuk Auto-Dismiss Alert -->
<script>
	// Auto-dismiss alert setelah 5 detik
	setTimeout(function () {
		var alerts = document.querySelectorAll('.alert');
		alerts.forEach(function (alert) {
			alert.classList.remove('show');
			alert.classList.add('fade');
			setTimeout(function () {
				alert.remove();
			}, 150);
		});
	}, 5000);
</script>

<script type="text/javascript">
	$(document).ready(function () {
		$('.datepicker-report').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true
		});
	});
</script>