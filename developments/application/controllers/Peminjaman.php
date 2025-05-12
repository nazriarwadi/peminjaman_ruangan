<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjaman extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_Peminjaman');
    }

    public function get_bookings()
    {
        // Ambil data tanggal dari POST
        $date = $this->input->post('date');

        // Validasi input
        if (!$date) {
            $response = array(
                'status' => 'error',
                'message' => 'Tanggal tidak valid'
            );
        } else {
            // Panggil model untuk mendapatkan data peminjaman
            $bookings = $this->Model_Peminjaman->get_bookings_by_date($date);

            // Format response
            $response = array(
                'status' => 'success',
                'bookings' => $bookings
            );
        }

        // Kembalikan response dalam format JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function update_status_otomatis()
    {
        // Set time zone to Indonesian time (WIB, UTC+7)
        date_default_timezone_set('Asia/Jakarta');

        // Ambil waktu saat ini dalam WIB
        $now = date('Y-m-d H:i:s');
        $current_date = date('Y-m-d');
        $current_time = date('H:i'); // Format to H:i to match waktu_selesai in database

        // 1. Update peminjaman yang tanggal_peminjaman < hari ini
        $this->db->where('status_pinjam', 'Disetujui')
            ->where('tanggal_peminjaman <', $current_date)
            ->update('tb_peminjaman', array(
                'status_pinjam' => 'Selesai',
                'waktu_pengembalian' => $now
            ));
        log_message('debug', 'Query 1 (Past Dates): ' . $this->db->last_query());

        // 2. Update peminjaman yang tanggal_peminjaman = hari ini dan waktu_selesai sudah lewat
        $this->db->where('status_pinjam', 'Disetujui')
            ->where('tanggal_peminjaman', $current_date)
            ->where('waktu_selesai <=', $current_time) // Include exact time match
            ->update('tb_peminjaman', array(
                'status_pinjam' => 'Selesai',
                'waktu_pengembalian' => $now
            ));
        log_message('debug', 'Query 2 (Current Date, Time Passed): ' . $this->db->last_query());

        // Update status ruangan yang terkait
        $updated_peminjaman = $this->db->select('id_ruangan')
            ->from('tb_peminjaman')
            ->where('status_pinjam', 'Selesai')
            ->where('DATE(waktu_pengembalian)', $current_date)
            ->get()->result();

        foreach ($updated_peminjaman as $pinjam) {
            $this->db->where('id_ruangan', $pinjam->id_ruangan)
                ->update('tb_ruangan', array('status' => 'Tersedia'));
        }

        log_message('info', 'Cron job update_status_otomatis dijalankan pada ' . $now);
    }

    public function api_update_status()
    {
        $this->update_status_otomatis();
        echo json_encode(['status' => 'success', 'message' => 'Status updated successfully']);
    }
    public function get_events()
    {
        $events = $this->db->select('p.id_peminjaman, p.ruangan_dipinjam, p.peminjam, 
                               p.tanggal_peminjaman, p.waktu_mulai, p.waktu_selesai, p.status_pinjam')
            ->from('tb_peminjaman p')
            ->where_in('p.status_pinjam', ['Disetujui', 'Selesai'])
            ->get()->result();

        $data_events = array();

        foreach ($events as $event) {
            $data_events[] = array(
                'id' => $event->id_peminjaman,
                'title' => $event->ruangan_dipinjam . ' - ' . $event->peminjam,
                'start' => $event->tanggal_peminjaman . 'T' . $event->waktu_mulai,
                'end' => $event->tanggal_peminjaman . 'T' . $event->waktu_selesai,
                'color' => ($event->status_pinjam == 'Disetujui') ? '#4A90E2' : '#50C878',
                'textColor' => '#FFFFFF'
            );
        }

        echo json_encode($data_events);
    }
}