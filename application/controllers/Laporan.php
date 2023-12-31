<?php
// defined('BASEPATH') or exit('No direct script access allowed');
require_once 'vendor/autoload.php';

use Dompdf\Dompdf as Dompdf;

class Laporan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_laporan');
		$this->load->helper('tgl_indo');

	}

	public function index()
	{
		if (@sizeof($this->session->userdata('user')) < 1)
			redirect('/auth/login', 'refresh');
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER', 'VIEWER']))
			redirect('/mainku/dashboard', 'refresh');

		$data = [
			'judul' => 'Laporan',
			'diskripsi' => '<hr>'
		];

		// $content = $this->load->view('laporan/index', $data, TRUE);

		// $this->load->view('main',['content'=>$content]);
		$this->template->render_page('laporan/index', $data, TRUE);
	}

	//fungsi-fungsi AJAX
	public function list($jenis = '')
	{
		if (sizeof($this->session->userdata('user')) < 1)
			die();
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER', 'VIEWER']))
			die();
		$jenis = urldecode($jenis);

		$start = (int) $this->input->post("start");
		$length = (int) $this->input->post("length");
		if ($length > 0)
			$filter = " LIMIT " . $length . " OFFSET " . $start;
		else
			$filter = "";

		switch ($jenis) {
			case "belumkgb":
				$laporan = " to_timestamp(((data->>'tmtkgbyad')::bigint - 25569) * 86400)<now() ";
				break;
			case "kgbbulanini":
				$laporan = " to_char(to_timestamp(((data->>'tmtkgbyad')::bigint - 25569) * 86400),'YYYY-MM')=to_char(now(),'YYYY-MM') ";
				break;
			case "58tahun":
				$laporan = " DATE_PART('YEAR',AGE(now(),to_timestamp(((data->>'tgllhr')::bigint - 25569) * 86400))) between 58 and 59 ";
				break;
			case "60tahun":
				$laporan = " DATE_PART('YEAR',AGE(now(),to_timestamp(((data->>'tgllhr')::bigint - 25569) * 86400))) between 60 and 64 ";
				break;
			case "65tahun":
				$laporan = " DATE_PART('YEAR',AGE(now(),to_timestamp(((data->>'tgllhr')::bigint - 25569) * 86400))) >= 65 ";
				break;
			default:
				$laporan = " 1=2 ";
				break;
		}

		$search = '';
		if ($this->input->post("search")['value'] != '')
			$search = "AND nama like '%" . $this->db->escape_str($this->input->post("search")['value']) . "%' ";
		$sql = "SELECT id,nama,data->>'nmskpd' as skpd,
					   DATE_PART('YEAR',AGE(now(),to_timestamp(((data->>'tgllhr')::bigint - 25569) * 86400))) as usia,
					   to_timestamp(((data->>'tmtkgb')::bigint - 25569) * 86400)::date as kgb,
					   to_timestamp(((data->>'tmtkgbyad')::bigint - 25569) * 86400)::date as kgbyad
				FROM (
		           SELECT id,nama,convert_from(decrypt(data, id::bytea, 'aes'),'UTF8')::jsonb as data FROM pns
				) X WHERE " . $laporan . " " . $search . " ";
		$totaldata = $this->db->query($sql)->num_rows();

		$sql = "SELECT id,nama,data->>'nmskpd' as skpd,
					   DATE_PART('YEAR',AGE(now(),to_timestamp(((data->>'tgllhr')::bigint - 25569) * 86400))) as usia,
					   to_timestamp(((data->>'tmtkgb')::bigint - 25569) * 86400)::date as kgb,
					   to_timestamp(((data->>'tmtkgbyad')::bigint - 25569) * 86400)::date as kgbyad
				FROM (
		           SELECT id,nama,convert_from(decrypt(data, id::bytea, 'aes'),'UTF8')::jsonb as data FROM pns
				) X WHERE " . $laporan . " " . $search . " ORDER BY data->>'nmskpd',id DESC " . $filter;
		$res = $this->db->query($sql);
		$data = [];
		while ($row = $res->unbuffered_row('array')) {
			$data[] = $row;
		}
		$jumlahdata = $this->db->query($sql)->num_rows();
		$result['data'] = ($data === null ? [] : $data);
		$result['draw'] = $this->input->post("draw");
		$result['recordsTotal'] = (int) $totaldata;
		$result['recordsFiltered'] = (int) $totaldata;
		echo json_encode($result);
	}


	public function listdetail()
	{
		if (sizeof($this->session->userdata('user')) < 1)
			die();
		if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER', 'VIEWER']))
			die();

		$start = (int) $this->input->post("start");
		$length = (int) $this->input->post("length");
		if ($length > 0)
			$filter = " LIMIT " . $length . " OFFSET " . $start;
		else
			$filter = "";

		$search = '';
		// if ($this->input->post("search")['value']!='') $search = "WHERE LOWER(lokasi) like '%".$this->db->escape_str($this->input->post("search")['value'])."%' ";
		if (isset($this->input->post("search")['value']) && $this->input->post("search")['value'] !== '') {
			$search = "WHERE LOWER(lokasi) LIKE '%" . $this->db->escape_str($this->input->post("search")['value']) . "%' ";
		} else {
			$search = ""; // Atau berikan nilai default jika 'value' tidak ada atau kosong.
		}
		$sql = "SELECT * FROM lokasi " . $search . " ";
		$totaldata = $this->db->query($sql)->num_rows();

		$sql = "
				       SELECT *
				       FROM lokasi " . $search . " ORDER BY id " . $filter;
		$res = $this->db->query($sql);
		$data = [];
		while ($row = $res->unbuffered_row('array')) {
			$row['detail'] = "<a href=" . base_url('Laporan/cetakdetail?id=') . $row['id'] . " class=\"btn btn-sm btn-danger\" target=\"_blank\"><i class=\"fa fa-print\"></i></a>
			<a href=" . base_url('managedocument/detaildoklaporan/') . $row['id'] . " class=\"btn btn-sm btn-info\"><i class=\"fa fa-file-word\"></i></a>";
			if ($row['statustanah'] == 1) {
				$row['statustanah'] = 'Data Tanah Bermasalah';
			} else {
				$row['statustanah'] = 'Data Tanah Tidak Bermasalah';
			}
			$data[] = $row;
		}
		$jumlahdata = $this->db->query($sql)->num_rows();
		$result['data'] = ($data === null ? [] : $data);
		$result['draw'] = $this->input->post("draw");
		$result['recordsTotal'] = (int) $totaldata;
		$result['recordsFiltered'] = (int) $totaldata;
		echo json_encode($result);
	}

	public function cetak()
	{
		$data['title'] = 'Laporan';
		$data['hariini'] = date('d F Y');
		$status = $this->input->post('filter');

		if ($status == 1) {
			$xfilter = 'Data Tanah Bermasalah';
		} elseif ($status == 2) {
			$xfilter = 'Data Tanah Tidak Bermasalah';
		} else {
			$xfilter = '';
		}

		// die($status);

		$data['sfilter'] = $xfilter;
		$data['list'] = $this->M_laporan->read($status);

		$dompdf = new Dompdf();
		$dompdf->setPaper('A4', 'Portrait');
		$html = $this->load->view('laporan/cetak', $data, true);
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream('Laporan Data ', array("Attachment" => false));
	}

	public function cetakdetail()
	{
		$data['title'] = 'Laporan';
		$data['hariini'] = date('d F Y');
		$id = $this->input->get('id');
		$tgl = $this->M_laporan->readdetail($id);

		$data['list'] = $this->M_laporan->readdetail($id);

		$data['dokumen'] = $this->M_laporan->readdokumen($id);

		// $data['tgl_lahir'] = mediumdate_indo($tgl['tgl_lahir']);

		// $data['tglpangkat'] = mediumdate_indo($tgl['tmt_pangkat_golongan']);

		// $data['tgljabatan'] = mediumdate_indo($tgl['tmt_jabatan_pekerjaan']);

		$dompdf = new Dompdf();
		$dompdf->setPaper('A4', 'Portrait');
		$html = $this->load->view('laporan/cetakdetail', $data, true);
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream('Laporan Detail Pegawai ', array("Attachment" => false));
	}


}