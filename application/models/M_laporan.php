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

	public function readdetail($nip)
	{
		$query = "
    			SELECT nip,
				       nama,
				       data ->> 'agama' as agama,
				       data ->> 'ruang' as ruang,
				       data ->> 'alamat' as alamat,
				       data ->> 'nmskpd' as nmskpd,
				       data ->> 'status' as status,
				       data ->> 'tgl_lahir' as tgl_lahir,
				       -- (CASE WHEN data ->> 'tgl_lahir' IS NOT NULL THEN terbilangbulankomplit(to_char((data ->> 'tgl_lahir')::DATE,'yyyy/mm/dd')::DATE) ELSE '-' END) as tgl_lahir,
				       data ->> 'pendidikan' as pendidikan,
				       data ->> 'tempat_lahir' as tempat_lahir,
				       data ->> 'jenis_kelamin' as jenis_kelamin,
				       data ->> 'pangkat_golongan' as pangkat_golongan,
				       data ->> 'jabatan_pekerjaan' as jabatan_pekerjaan,
				       data ->> 'status_kepegawaian' as status_kepegawaian,
				       data ->> 'tmt_pangkat_golongan' as tmt_pangkat_golongan,
				       data ->> 'tmt_jabatan_pekerjaan' as tmt_jabatan_pekerjaan
				       -- (CASE WHEN data ->> 'tmt_pangkat_golongan' IS NOT NULL THEN terbilangbulankomplit(to_char((data ->> 'tmt_pangkat_golongan')::DATE,'yyyy/mm/dd')::DATE) ELSE '-' END) as tmt_pangkat_golongan,
				       -- (CASE WHEN data ->> 'tmt_jabatan_pekerjaan' IS NOT NULL THEN terbilangbulankomplit(to_char((data ->> 'tmt_jabatan_pekerjaan')::DATE,'yyyy/mm/dd')::DATE) ELSE '-' END) as tmt_jabatan_pekerjaan
				FROM (
				       SELECT nip,
				              nama,
				              convert_from(decrypt(data, nip::bytea, 'aes'), 'UTF8')::jsonb as data
				       FROM pns
				     ) X
				 WHERE nip = '$nip'
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

	public function readdokumen($nip)
	{
		$query = "

    			SELECT * FROM dms WHERE uname = '$nip' AND is_delete != true
    	";

		return $this->db->query($query)->result_array();
	}
}