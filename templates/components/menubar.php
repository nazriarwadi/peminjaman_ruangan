<?php

/*
|--------------------------------------------------------------------------
| Limitasi Hak Akses Menubar
|--------------------------------------------------------------------------
|
| Membatasi menu yang bisa diakses oleh user 
| berdasarkan tingkatan akses yang dimiliki.
|
*/

// Level Akses Bagian Umum (Admin)
if($this->session->userdata('level') == "Bagian Umum")
{
	$this->load->view('components/menubar-admin');
}

// Level Akses User
if($this->session->userdata('level') == "Pengguna Ruangan")
{
	$this->load->view('components/menubar-user');
}

?>