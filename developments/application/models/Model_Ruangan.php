<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Ruangan extends CI_Model 
{
	var $table = 'tb_ruangan';

	public function tampil()
    {
        return $this->db->get($this->table);
    }

	public function total_ruangan()
    {
		$this->db->select('count(*) as total_ruangan');
		$this->db->from($this->table);
		$query = $this->db->get();
		return $query->result_array();
    }

	public function ruangan_tersedia()
    {
		$this->db->select('count(*) as ruangan_tersedia');
		$this->db->from($this->table);
		$this->db->where('status', 'Tersedia');
		$query = $this->db->get();
		return $query->result_array();
    }

    public function buat($data)
	{		
		return $this->db->insert($this->table, $data);
	}

	public function perbarui($data, $where)
	{
		return $this->db->update($this->table, $data, $where);
	}

	public function hapus($where)
	{
		return $this->db->delete($this->table, $where);
	}
}