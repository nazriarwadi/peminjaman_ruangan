<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Peminjaman extends CI_Model
{
	var $table = 'tb_peminjaman';

	public function tampil()
	{
		return $this->db->order_by('id_peminjaman', 'DESC')->get($this->table);
	}

	public function peminjaman_aktif()
	{
		$this->db->select('count(*) as peminjaman_aktif');
		$this->db->from($this->table);
		$this->db->where('status_pinjam', 'Disetujui');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function tampil_detail($where)
	{
		return $this->db->order_by('id_peminjaman', 'DESC')->get_where($this->table, $where);
	}

	public function tampil_id()
	{
		return $this->db->select_max('id_peminjaman')->get($this->table);
	}

	public function buat($data_isi)
	{
		return $this->db->insert($this->table, $data_isi);
	}

	public function perbarui($data, $where)
	{
		return $this->db->update($this->table, $data, $where);
	}

	public function hapus($where)
	{
		return $this->db->delete($this->table, $where);
	}

	public function get_bookings_by_date($date)
	{
		$this->db->where('tanggal_peminjaman', $date);
		$query = $this->db->get($this->table);
		return $query->result_array();
	}

	public function get_peminjaman_by_status($status)
	{
		$this->db->where('status_pinjam', $status);
		return $this->db->get('tb_peminjaman')->result();
	}

	public function get_peminjaman_by_date_range($tgl_awal, $tgl_akhir)
	{
		$this->db->where('tanggal_peminjaman >=', $tgl_awal);
		$this->db->where('tanggal_peminjaman <=', $tgl_akhir);
		$this->db->order_by('tanggal_peminjaman', 'ASC');
		return $this->db->get('tb_peminjaman')->result_array();
	}

	public function get_all_peminjaman()
	{
		$this->db->order_by('tanggal_peminjaman', 'ASC');
		return $this->db->get('tb_peminjaman')->result_array();
	}

	public function check_room_availability($room, $start_datetime, $end_datetime)
	{
		// Query to check for overlapping bookings with status "Disetujui"
		$this->db->where('ruangan_dipinjam', $room);
		$this->db->where('status_pinjam', 'Disetujui');
		$this->db->where('tanggal_peminjaman', date('Y-m-d', strtotime($start_datetime))); // Match the date
		$this->db->where("(
            (waktu_mulai <= '$end_datetime' AND waktu_selesai >= '$start_datetime')
        )");

		$query = $this->db->get('tb_peminjaman');

		// If any rows are found, the room is booked during the requested time
		return $query->num_rows() > 0;
	}

	// Other methods like buat(), get_all_peminjaman(), etc.
}