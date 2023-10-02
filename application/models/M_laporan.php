<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('tgl_indo');

	}
	public function read($status)
	{

		if ($status == '1') {
			$xfilter = 1;
			$sql = "WHERE statustanah = '$xfilter' ";
		} elseif ($status == '2') {
			$xfilter = 2;
			$sql = "WHERE statustanah = '$xfilter' ";
		} else {
			$xfilter = '';
			$sql = '';
		}

		$query = "
							SELECT l.*, d.kodeberkas
							FROM lokasi l
							LEFT JOIN dms d ON l.id::text = d.uname
							$sql
							order by l.id, d.kodeberkas
    			 ";
		return $this->db->query($query)->result_array();
	}

	public function readdetail($id)
	{
		$query = "
							SELECT * FROM lokasi
							WHERE id = '$id'
    			";
		return $this->db->query($query)->row_array();
	}

	public function readdetaillokasi($id)
	{
		$query = "
    			SELECT * from lokasi
				 WHERE id = '$id'
    			 ";
		return $this->db->query($query)->row_array();
	}

	public function readdokumen($id)
	{
		$query = "

    			SELECT * FROM dms WHERE uname = '$id' AND is_delete != true
    	";

		return $this->db->query($query)->result_array();
	}
}