<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Memanggil library untuk templating halaman
		$this->load->library('template');

		// Pemeriksaan session masuk (login)
		if ($this->session->userdata('status-masuk') != 'masuk') {
			redirect(base_url());
		}

		// Memanggil Model
		$this->load->model('model_user');
		$this->load->model('model_ruangan');
		$this->load->model('model_peminjaman');
		$this->load->model('model_tap');
	}

	public function index()
	{
		$data['hal'] = "Beranda";
		$data['total_ruangan'] = $this->model_ruangan->total_ruangan()[0]['total_ruangan'];
		$data['peminjaman_aktif'] = $this->model_peminjaman->peminjaman_aktif()[0]['peminjaman_aktif'];
		$data['ruangan_tersedia'] = $this->model_ruangan->ruangan_tersedia()[0]['ruangan_tersedia'];

		$this->template->utama('pages/halaman-beranda', $data);
	}


	/*
																									|-----------------------------------------------------------------
																									| Fitur CRUD User
																									|-----------------------------------------------------------------
																									*/

	public function akun_pengguna()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if ($this->session->userdata('level') != "Bagian Umum") {
			redirect(base_url('dashboard'));
		}

		// Memanggil fungsi lihat data pada Model User
		$query = $this->model_user->tampil()->result_array();

		// Data disimpan sementara pada array
		$halaman = array(
			'tb' => $query,
			'hal' => 'Kelola Akun Pengguna'
		);

		$this->template->utama('pages/halaman-user', $halaman);
	}

	public function buat_user()
	{
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$fullname = $this->input->post('fullname');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$level = $this->input->post('level');

		// Data yang akan disimpan/dibuat
		$data = array(
			'fullname' => $fullname,
			'username' => $username,
			'email' => $email,  // tambahkan email di sini
			'password' => md5($password),
			'level' => $level
		);

		$query = $this->model_user->buat($data);

		if ($query) {
			redirect(base_url('dashboard/akun-pengguna'));
		} else {
			echo "Proses penambahan data gagal.";
		}
	}

	public function perbarui_user()
	{
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$fullname = $this->input->post('fullname');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$level = $this->input->post('level');

		// Data yang akan diperbarui
		$data = array(
			'fullname' => $fullname,
			'email' => $email,
			'level' => $level
		);

		// Username digunakan sebagai pengenal data mana yang akan diperbarui
		$where = array('username' => $username);

		$query = $this->model_user->perbarui($data, $where);

		if ($query) {
			redirect(base_url('dashboard/akun-pengguna'));
		} else {
			echo "Proses pengubahan data gagal.";
		}
	}

	public function hapus_user()
	{
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$username = $this->input->post('username');

		// Username digunakan sebagai pengenal data mana yang akan dihapus
		$where = array('username' => $username);

		$query = $this->model_user->hapus($where);

		if ($query) {
			redirect(base_url('dashboard/akun-pengguna'));
		} else {
			echo "Proses penghapusan data gagal.";
		}
	}



	/*
																   |-----------------------------------------------------------------
																									| Fitur CRUD Ruangan
																									|-----------------------------------------------------------------
																									*/

	public function data_ruangan()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if ($this->session->userdata('level') != "Bagian Umum") {
			redirect(base_url('dashboard'));
		}

		// Memanggil fungsi lihat data pada Model Ruangan
		$query = $this->model_ruangan->tampil()->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb' => $query,
			'hal' => 'Kelola Data Ruangan'
		);

		$this->template->utama('pages/halaman-ruangan', $halaman);
	}

	public function buat_ruangan()
	{
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_ruangan = $this->input->post('id_ruangan');
		$namaruangan = $this->input->post('nama_ruangan');

		// Data yang akan disimpan/dibuat
		$data = array
		(
			'id_ruangan' => $id_ruangan,
			'nama_ruangan' => $namaruangan
		);

		$query = $this->model_ruangan->buat($data);

		if ($query) {
			redirect(base_url('dashboard/data-ruangan'));
		} else {
			echo "Proses penambahan data gagal.";
		}
	}

	public function perbarui_ruangan()
	{
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_ruangan = $this->input->post('id_ruangan');
		$namaruangan = $this->input->post('nama_ruangan');

		// Data yang akan diperbarui
		$data = array('nama_ruangan' => $namaruangan);

		// ID ruangan digunakan sebagai pengenal data mana yang akan diperbarui
		$where = array('id_ruangan' => $id_ruangan);

		$query = $this->model_ruangan->perbarui($data, $where);

		if ($query) {
			redirect(base_url('dashboard/data-ruangan'));
		} else {
			echo "Proses pengubahan data gagal.";
		}
	}

	public function setujui_peminjaman()
	{
		$id_peminjaman = $this->input->post('id_peminjaman');
		$w_penyetujuan = $this->input->post('waktu_penyetujuan');
		$id_ruangan = $this->input->post('id_ruangan');

		// Update status peminjaman
		$data_isi = array(
			'waktu_penyetujuan' => $w_penyetujuan,
			'status_pinjam' => 'Disetujui'
		);
		$where = array('id_peminjaman' => $id_peminjaman);
		$query = $this->model_peminjaman->perbarui($data_isi, $where);

		// Update status ruangan
		$data_ruangan = array('status' => 'Sedang digunakan');
		$where_ruangan = array('id_ruangan' => $id_ruangan);
		$query_ruangan = $this->model_ruangan->perbarui($data_ruangan, $where_ruangan);

		if ($query && $query_ruangan) {
			// Ambil data peminjaman dan email peminjam
			$this->db->select('tb_user.email, tb_peminjaman.*');
			$this->db->from('tb_user');
			$this->db->join('tb_peminjaman', 'tb_user.fullname = tb_peminjaman.peminjam');
			$this->db->where('tb_peminjaman.id_peminjaman', $id_peminjaman);
			$peminjaman_result = $this->db->get()->row_array();

			if (empty($peminjaman_result)) {
				// Log data peminjam untuk debugging
				$this->db->select('peminjam');
				$this->db->from('tb_peminjaman');
				$this->db->where('id_peminjaman', $id_peminjaman);
				$peminjam_result = $this->db->get()->row_array();
				$peminjam_name = $peminjam_result['peminjam'] ?? 'Tidak ditemukan';

				// Cek apakah fullname ada di tb_user
				$this->db->select('fullname, email');
				$this->db->from('tb_user');
				$this->db->where('fullname', $peminjam_name);
				$user_result = $this->db->get()->row_array();

				// Simpan pesan error ke flashdata
				$this->session->set_flashdata('error', "Email penerima tidak ditemukan untuk peminjam: '$peminjam_name'.");
				redirect(base_url('dashboard/data-peminjaman'));
				return;
			}

			$email = $peminjaman_result['email'];
			$peminjam = $peminjaman_result['peminjam'];
			$instansi = $peminjaman_result['instansi'];
			$ruangan_dipinjam = $peminjaman_result['ruangan_dipinjam'];
			$keterangan = $peminjaman_result['keterangan'];
			$tanggal_peminjaman = date('d/m/Y', strtotime($peminjaman_result['tanggal_peminjaman']));
			$waktu_mulai = date('H:i', strtotime($peminjaman_result['waktu_mulai']));
			$waktu_selesai = date('H:i', strtotime($peminjaman_result['waktu_selesai']));
			$jumlah_orang = $peminjaman_result['jumlah_orang'];
			$konsumsi = $peminjaman_result['konsumsi'] == 'perlu' ? 'Ya' : 'Tidak';
			$menu_konsumsi = $peminjaman_result['menu_konsumsi'] ?: '-';

			// Konfigurasi email dengan SMTP perserobatam.id
			$this->load->library('email');
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'perserobatam.id';
			$config['smtp_user'] = 'ruangrapat@perserobatam.id';
			$config['smtp_pass'] = '@MasukSaja2025';
			$config['smtp_port'] = 465;
			$config['smtp_crypto'] = 'ssl';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['newline'] = "\r\n";
			$this->email->initialize($config);

			// Atur pengirim
			$this->email->from('ruangrapat@perserobatam.id', 'Admin Sistem Peminjaman Ruang');
			$this->email->to($email);
			$this->email->subject('Pengajuan Peminjaman Ruang Anda Telah Disetujui');

			// Pesan email dengan format HTML yang lebih rapi dan modern
			$message = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Peminjaman Ruang Disetujui</title>
            <style>
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background-color: #f4f4f9;
                    margin: 0;
                    padding: 0;
                    color: #333;
                }
                .container {
                    max-width: 650px;
                    margin: 30px auto;
                    background: #ffffff;
                    border-radius: 12px;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                }
                .header {
                    background: linear-gradient(90deg, #28a745, #34c759);
                    color: #ffffff;
                    padding: 30px;
                    text-align: center;
                    border-radius: 12px 12px 0 0;
                }
                .header h1 {
                    margin: 0;
                    font-size: 28px;
                    font-weight: 600;
                }
                .content {
                    padding: 30px;
                    background: #f9f9f9;
                }
                .content p {
                    font-size: 16px;
                    line-height: 1.7;
                    margin: 0 0 20px;
                }
                .content strong {
                    color: #28a745;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                    background: #ffffff;
                    border-radius: 8px;
                    overflow: hidden;
                }
                th, td {
                    padding: 14px;
                    text-align: left;
                    border-bottom: 1px solid #e0e0e0;
                    font-size: 15px;
                }
                th {
                    background: #f1f1f1;
                    color: #555;
                    font-weight: 600;
                }
                td {
                    color: #333;
                }
                .cta-button {
                    display: inline-block;
                    padding: 12px 24px;
                    background: #28a745;
                    color: #ffffff;
                    text-decoration: none;
                    border-radius: 25px;
                    font-size: 16px;
                    font-weight: 500;
                    margin-top: 20px;
                    transition: background 0.3s;
                }
                .cta-button:hover {
                    background: #218838;
                }
                .footer {
                    background: #ffffff;
                    text-align: center;
                    padding: 20px;
                    font-size: 13px;
                    color: #666;
                    border-top: 1px solid #e0e0e0;
                }
                .footer a {
                    color: #28a745;
                    text-decoration: none;
                }
                @media only screen and (max-width: 600px) {
                    .container {
                        margin: 10px;
                        border-radius: 8px;
                    }
                    .header h1 {
                        font-size: 24px;
                    }
                    .content {
                        padding: 20px;
                    }
                    th, td {
                        font-size: 14px;
                        padding: 10px;
                    }
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Peminjaman Ruang Disetujui</h1>
                </div>
                <div class='content'>
                    <p>Yth. $peminjam,</p>
                    <p>Kami dengan senang hati menginformasikan bahwa pengajuan peminjaman ruang Anda telah <strong>disetujui</strong>. Berikut adalah detail peminjaman Anda:</p>
                    <table>
                        <tr><th>ID Peminjaman</th><td>$id_peminjaman</td></tr>
                        <tr><th>Peminjam</th><td>$peminjam</td></tr>
                        <tr><th>Instansi</th><td>$instansi</td></tr>
                        <tr><th>Ruang</th><td>$ruangan_dipinjam</td></tr>
                        <tr><th>Keterangan</th><td>$keterangan</td></tr>
                        <tr><th>Tanggal Peminjaman</th><td>$tanggal_peminjaman</td></tr>
                        <tr><th>Waktu Mulai</th><td>$waktu_mulai</td></tr>
                        <tr><th>Waktu Selesai</th><td>$waktu_selesai</td></tr>
                        <tr><th>Jumlah Orang</th><td>$jumlah_orang</td></tr>
                        <tr><th>Konsumsi</th><td>$konsumsi</td></tr>
                        <tr><th>Menu Konsumsi</th><td>$menu_konsumsi</td></tr>
                    </table>
                    <p>Pastikan untuk mematuhi jadwal dan peraturan penggunaan ruang. Jika ada pertanyaan atau kebutuhan lebih lanjut, jangan ragu untuk menghubungi kami.</p>
                    <a href='mailto:ruangrapat@perserobatam.id' class='cta-button'>Hubungi Kami</a>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " Sistem Peminjaman Ruang. All rights reserved.</p>
                    <p><a href='mailto:ruangrapat@perserobatam.id'>ruangrapat@perserobatam.id</a> | Persero Batam</p>
                </div>
            </div>
        </body>
        </html>";

			$this->email->message($message);

			if (!$this->email->send()) {
				// Simpan pesan error ke flashdata
				$this->session->set_flashdata('error', 'Gagal mengirim email: ' . $this->email->print_debugger());
				redirect(base_url('dashboard/data-peminjaman'));
			} else {
				// Simpan pesan sukses ke flashdata
				$this->session->set_flashdata('success', 'Email berhasil dikirim! Peminjaman telah disetujui.');
				redirect(base_url('dashboard/data-peminjaman'));
			}
		} else {
			// Simpan pesan error ke flashdata
			$this->session->set_flashdata('error', 'Proses pengubahan data gagal.');
			redirect(base_url('dashboard/data-peminjaman'));
		}
	}

	public function hapus_ruangan()
	{
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_ruangan = $this->input->post('id_ruangan');

		// ID ruangan digunakan sebagai pengenal data mana yang akan dihapus
		$where = array('id_ruangan' => $id_ruangan);

		$query = $this->model_ruangan->hapus($where);

		if ($query) {
			redirect(base_url('dashboard/data-ruangan'));
		} else {
			echo "Proses penghapusan data gagal.";
		}
	}


	/*
																									|-----------------------------------------------------------------
																									| Fitur CRUD Peminjaman
																									|-----------------------------------------------------------------
																									*/

	public function data_peminjaman()
	{
		// Memanggil fungsi lihat data pada Model Peminjaman dan Model Ruangan
		if ($this->session->userdata('level') == "Pengguna Ruangan") {
			// Nama peminjam digunakan sebagai pengenal data mana yang akan ditampilkan
			$where = array('peminjam' => $this->session->userdata('namalengkap'));

			$query = $this->model_peminjaman->tampil_detail($where)->result_array();
		} else {
			$query = $this->model_peminjaman->tampil()->result_array();
		}

		$query_b = $this->model_ruangan->tampil()->result_array();
		$query_c = $this->model_peminjaman->tampil_id()->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb' => $query,
			'tb_ruangan' => $query_b,
			'tb_idpinjam' => $query_c,
			'hal' => 'Data Peminjaman'
		);

		$this->template->utama('pages/halaman-peminjaman', $halaman);
	}

	public function laporan_peminjaman()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if ($this->session->userdata('level') != "Bagian Umum") {
			redirect(base_url('dashboard'));
		}

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');

		// Mencegah halaman diakses langsung melalui tautan dengan kondisi data yang kosong
		if (empty($tgl_awal && $tgl_akhir)) {
			redirect(base_url('dashboard/data-peminjaman'));
		}

		// Tanggal awal dan akhir digunakan sebagai pengenal data mana yang akan ditampilkan
		$where = array
		(
			'waktu_pengajuan >=' => $tgl_awal,
			'waktu_pengajuan <=' => $tgl_akhir
		);

		$query = $this->model_peminjaman->tampil_detail($where)->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb' => $query,
			'tanggal_awal' => $tgl_awal,
			'tanggal_akhir' => $tgl_akhir,
			'hal' => 'Laporan Peminjaman'
		);

		$this->template->utama('pages/halaman-laporan', $halaman);
	}

	public function pinjam_ruang()
	{
		// Ambil data dari form
		$nama_ruangan = $this->input->post('nama_ruangan');
		$tanggal_peminjaman = $this->input->post('tanggal_peminjaman');
		$waktu_mulai = $this->input->post('waktu_mulai');
		$waktu_selesai = $this->input->post('waktu_selesai');

		// Gabungkan tanggal dan waktu untuk pengecekan
		$start_datetime = $tanggal_peminjaman . ' ' . $waktu_mulai . ':00';
		$end_datetime = $tanggal_peminjaman . ' ' . $waktu_selesai . ':00';

		// Cek apakah ruangan sedang dipakai (status Disetujui) pada rentang waktu tersebut
		$is_room_booked = $this->model_peminjaman->check_room_availability($nama_ruangan, $start_datetime, $end_datetime);

		if ($is_room_booked) {
			// Jika ruangan sedang dipakai, set flashdata untuk pesan error dan redirect
			$this->session->set_flashdata('error', 'Tidak dapat mengajukan peminjaman. Ruangan sedang dipakai pada waktu tersebut.');
			redirect('dashboard/data-peminjaman');
		}

		// Tentukan nilai menu_konsumsi berdasarkan pilihan konsumsi
		$konsumsi = $this->input->post('konsumsi');
		$menu_konsumsi = ($konsumsi === 'perlu') ? $this->input->post('menu_konsumsi') : null;

		$data_isi = array(
			'id_peminjaman' => $this->input->post('id_peminjaman'),
			'peminjam' => $this->input->post('peminjam'),
			'instansi' => $this->input->post('instansi'),
			'ruangan_dipinjam' => $nama_ruangan,
			'jumlah_orang' => $this->input->post('jumlah_orang'),
			'konsumsi' => $konsumsi,
			'menu_konsumsi' => $menu_konsumsi,
			'keterangan' => $this->input->post('keterangan'),
			'waktu_mulai' => $waktu_mulai,
			'waktu_selesai' => $waktu_selesai,
			'waktu_pengajuan' => date('Y-m-d H:i:s'),
			'tanggal_peminjaman' => $tanggal_peminjaman,
			'status_pinjam' => 'Menunggu'
		);

		$query = $this->model_peminjaman->buat($data_isi);
		if ($query) {
			redirect(base_url('dashboard/data-peminjaman'));
		} else {
			$this->session->set_flashdata('error', 'Proses penambahan data gagal.');
			redirect('dashboard/data-peminjaman');
		}
	}


	public function perbarui_peminjaman()
	{
		// Setel zona waktu
		date_default_timezone_set('Asia/Jakarta');

		// Ambil nilai dari input
		$jam_mulai = $this->input->post('jam_mulai');
		$jam_selesai = $this->input->post('jam_selesai');


		// Siapkan data yang akan diperbarui
		$data = array(
			'keterangan' => $this->input->post('keterangan'),
			'jumlah_orang' => $this->input->post('jumlah_orang'),
			'konsumsi' => $this->input->post('konsumsi'),
			'instansi' => $this->input->post('instansi'),
			'menu_konsumsi' => $this->input->post('menu_konsumsi'),
			'waktu_mulai' => date('Y-m-d H:i', strtotime($waktu_mulai)),
			'waktu_selesai' => date('Y-m-d H:i', strtotime($waktu_selesai))
		);

		// Syarat untuk update berdasarkan id_peminjaman
		$where = array('id_peminjaman' => $this->input->post('id_peminjaman'));

		// Eksekusi update
		$query = $this->model_peminjaman->perbarui($data, $where);

		if ($query) {
			redirect(base_url('dashboard/data-peminjaman'));
		} else {
			echo "Proses pengubahan data gagal.";
		}
	}


	public function batalkan_peminjaman()
	{
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		$w_pembatalan = $this->input->post('waktu_pembatalan');
		$id_ruangan = $this->input->post('id_ruangan');

		// Pengubahan status pada tabel peminjaman dari "Menunggu" menjadi "Dibatalkan"
		// Data yang akan diperbarui
		$data_isi = array
		(
			'waktu_pembatalan' => $w_pembatalan,
			'status_pinjam' => 'Dibatalkan'
		);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where = array('id_peminjaman' => $id_peminjaman);

		$query = $this->model_peminjaman->perbarui($data_isi, $where);


		// Pengubahan status pada tabel ruangan dari "Menunggu" menjadi "Tersedia"
		// Data yang akan diperbarui
		$data = array('status' => 'Tersedia');

		// ID ruangan digunakan sebagai pengenal data mana yang akan diperbarui
		$where = array('id_ruangan' => $id_ruangan);

		$query_ruangan = $this->model_ruangan->perbarui($data, $where);

		if ($query && $query_ruangan) {
			redirect(base_url('dashboard/data-peminjaman'));
		} else {
			echo "Proses pengubahan data gagal.";
		}
	}

	public function selesaikan_peminjaman()
	{
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		$w_pengembalian = $this->input->post('waktu_pengembalian');
		$id_ruangan = $this->input->post('id_ruangan');

		// Pengubahan status pada tabel peminjaman dari "Disetujui" menjadi "Selesai"
		// Data yang akan diperbarui
		$data_isi = array
		(
			'waktu_pengembalian' => $w_pengembalian,
			'status_pinjam' => 'Selesai'
		);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where = array('id_peminjaman' => $id_peminjaman);

		$query = $this->model_peminjaman->perbarui($data_isi, $where);


		// Pengubahan status pada tabel ruangan dari "Sedang digunakan" menjadi "Tersedia"
		// Data yang akan diperbarui
		$data = array('status' => 'Tersedia');

		// ID ruangan digunakan sebagai pengenal data mana yang akan diperbarui
		$where = array('id_ruangan' => $id_ruangan);

		$query_ruangan = $this->model_ruangan->perbarui($data, $where);

		if ($query && $query_ruangan) {
			redirect(base_url('dashboard/data-peminjaman'));

		} else {
			echo "Proses pengubahan data gagal.";
		}
	}

	public function hapus_peminjaman()
	{
		// Menerima input dan lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');

		// ID peminjaman digunakan sebagai pengenal data mana yang akan dihapus
		$where = array('id_peminjaman' => $id_peminjaman);

		$query = $this->model_peminjaman->hapus($where);

		if ($query) {
			redirect(base_url('dashboard/data-peminjaman'));
		} else {
			echo "Proses penghapusan data gagal.";
		}
	}


	/*
																									|-----------------------------------------------------------------
																									| Fitur Unduh Data
																									|-----------------------------------------------------------------
																									*/

	public function unduh_akses_ruangan()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if ($this->session->userdata('level') != "Bagian Umum") {
			redirect(base_url('dashboard'));
		}

		// Memanggil fungsi lihat data pada Model Tap
		$query = $this->model_tap->tampil()->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb' => $query,
			'hal' => 'Riwayat Akses Ruangan'
		);

		$this->load->view('pages/unduh-akses-ruangan', $halaman);
	}

	public function unduh_laporan_peminjaman()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if ($this->session->userdata('level') != "Bagian Umum") {
			redirect(base_url('dashboard'));
		}

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$tgl_awal = $this->input->post('tanggal_awal');
		$tgl_akhir = $this->input->post('tanggal_akhir');

		// Tanggal awal dan akhir digunakan sebagai pengenal data mana yang akan ditampilkan
		$where = array
		(
			'waktu_pengajuan >=' => $tgl_awal,
			'waktu_pengajuan <=' => $tgl_akhir
		);

		$query = $this->model_peminjaman->tampil_detail($where)->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb' => $query,
			'tanggal_awal' => $tgl_awal,
			'tanggal_akhir' => $tgl_akhir,
			'hal' => 'Laporan Peminjaman'
		);

		$unduh = $this->load->view('pages/unduh-laporan', $halaman);
	}


	/*
							 |-----------------------------------------------------------------
							 | Fitur Logout
							 |-----------------------------------------------------------------
						 */

	public function logout()
	{
		$sesi = array
		(
			'namalengkap',
			'level',
			'status-masuk'
		);

		$this->session->unset_userdata($sesi);

		redirect(base_url());
	}

	public function tampil_laporan()
	{
		// Ambil parameter tanggal dari query string (opsional)
		$tgl_awal = $this->input->get('tgl_awal') ?: date('Y-m-01'); // Default: awal bulan
		$tgl_akhir = $this->input->get('tgl_akhir') ?: date('Y-m-t'); // Default: akhir bulan

		// Validasi level pengguna
		if ($this->session->userdata('level') != 'Bagian Umum') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk melihat laporan.');
			redirect('dashboard');
		}

		// Ambil data peminjaman
		$data['peminjaman'] = $this->model_peminjaman->get_peminjaman_by_date_range($tgl_awal, $tgl_akhir);
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;
		$data['title'] = 'Laporan Peminjaman Ruang';

		// Load view untuk halaman laporan
		$this->load->view('laporan_peminjaman', $data);
	}

	public function cetak_semua_laporan_pdf()
	{
		// Validasi level pengguna
		if ($this->session->userdata('level') != 'Bagian Umum') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mencetak laporan.');
			redirect('dashboard');
		}

		// Load Dompdf
		require_once FCPATH . 'vendor/autoload.php';
		$dompdf = new \Dompdf\Dompdf([
			'isRemoteEnabled' => true,
			'defaultFont' => 'Helvetica'
		]);

		// Ambil semua data peminjaman
		$data['peminjaman'] = $this->model_peminjaman->get_all_peminjaman();

		// Path to the logo file
		$logo_path = FCPATH . 'assets/img/logo-new.png';
		$logo_data = file_exists($logo_path) ? base64_encode(file_get_contents($logo_path)) : '';
		$logo_src = $logo_data ? 'data:image/png;base64,' . $logo_data : 'https://via.placeholder.com/100x100?text=Logo';

		// Buat HTML untuk PDF
		$html = '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Laporan Peminjaman Ruang</title>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: "Helvetica", sans-serif;
                font-size: 10px;
                color: #333;
                margin: 10px;
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .header img {
                max-width: 80px;
                margin-bottom: 8px;
            }
            .header h2 {
                color: #1a73e8;
                margin: 5px 0;
                font-size: 18px;
            }
            .header p {
                color: #666;
                margin: 0;
                font-size: 12px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
                table-layout: fixed;
            }
            th, td {
                border: 1px solid #e0e0e0;
                padding: 6px 4px;
                text-align: left;
                word-wrap: break-word;
                overflow-wrap: break-word;
            }
            th {
                background-color: #1a73e8;
                color: white;
                font-weight: bold;
                text-align: center;
                font-size: 9px;
            }
            td {
                background-color: #fff;
                font-size: 9px;
            }
            tr:nth-child(even) td {
                background-color: #f9f9f9;
            }
            .center {
                text-align: center;
            }
            .footer {
                text-align: center;
                margin-top: 20px;
                color: #666;
                font-size: 9px;
            }
            .col-no { width: 2%; }
            .col-id { width: 6%; }
            .col-pengguna { width: 7%; }
            .col-ruang { width: 5%; }
            .col-keterangan { width: 7%; }
            .col-instansi { width: 7%; }
            .col-pengajuan { width: 8%; }
            .col-tanggal { width: 7%; }
            .col-mulai { width: 5%; }
            .col-selesai { width: 5%; }
            .col-orang { width: 5%; }
            .col-konsumsi { width: 5%; }
            .col-menu { width: 10%; }
            .col-status { width: 6%; }
        </style>
    </head>
    <body>
        <div class="header">
            <img src="' . $logo_src . '" alt="Logo">
            <h2>Laporan Peminjaman Ruang</h2>
            <p>Semua Data Peminjaman - Dicetak pada ' . date('d/m/Y') . '</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="col-no">No.</th>
                    <th class="col-id">ID Peminjaman</th>
                    <th class="col-pengguna">Pengguna</th>
                    <th class="col-ruang">Ruang</th>
                    <th class="col-keterangan">Keterangan</th>
                    <th class="col-instansi">Instansi</th>
                    <th class="col-pengajuan">Waktu Pengajuan</th>
                    <th class="col-tanggal">Tanggal Peminjaman</th>
                    <th class="col-mulai">Waktu Mulai</th>
                    <th class="col-selesai">Waktu Selesai</th>
                    <th class="col-orang">Jumlah Orang</th>
                    <th class="col-konsumsi">Konsumsi</th>
                    <th class="col-menu">Menu Konsumsi</th>
                    <th class="col-status">Status</th>
                </tr>
            </thead>
            <tbody>';

		if (empty($data['peminjaman'])) {
			$html .= '<tr><td colspan="14" class="center">Tidak ada data peminjaman.</td></tr>';
		} else {
			$no = 1;
			foreach ($data['peminjaman'] as $baris) {
				$html .= '
            <tr>
                <td class="center">' . $no . '</td>
                <td class="center">' . $baris['id_peminjaman'] . '</td>
                <td>' . $baris['peminjam'] . '</td>
                <td class="center">' . $baris['ruangan_dipinjam'] . '</td>
                <td>' . $baris['keterangan'] . '</td>
                <td>' . $baris['instansi'] . '</td>
                <td class="center">' . date('d/m/Y H:i', strtotime($baris['waktu_pengajuan'])) . '</td>
                <td class="center">' . date('d/m/Y', strtotime($baris['tanggal_peminjaman'])) . '</td>
                <td class="center">' . date('H:i', strtotime($baris['waktu_mulai'])) . '</td>
                <td class="center">' . date('H:i', strtotime($baris['waktu_selesai'])) . '</td>
                <td class="center">' . $baris['jumlah_orang'] . '</td>
                <td class="center">' . $baris['konsumsi'] . '</td>
                <td class="center">' . $baris['menu_konsumsi'] . '</td>
                <td class="center">' . $baris['status_pinjam'] . '</td>
            </tr>';
				$no++;
			}
		}

		$html .= '
            </tbody>
        </table>

        <div class="footer">
            <p>Laporan ini dibuat secara otomatis oleh sistem. © ' . date('Y') . ' - Sistem Peminjaman Ruang</p>
        </div>
    </body>
    </html>';

		// Load HTML ke Dompdf
		$dompdf->loadHtml($html);

		// Set ukuran kertas dan orientasi
		$dompdf->setPaper('A4', 'landscape');

		// Render PDF
		$dompdf->render();

		// Output PDF sebagai unduhan
		$current_date = date('Y-m-d');
		$dompdf->stream('Laporan_Data_Peminjaman_' . $current_date . '.pdf', ['Attachment' => 1]);
	}
}