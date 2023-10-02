<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lokasi extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->helper('tgl_indo');

    $this->load->model('M_laporan');
  }

  public function index()
  {
    if (@sizeof($this->session->userdata('user')) < 1)
      redirect('/auth/login', 'refresh');
    if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER']))
      redirect('/mainku/dashboard', 'refresh');
    // if ($this->session->userdata('user')['role']!='MAINTAINER') redirect('/mainku/dashboard', 'refresh');

    $data = [
      'judul' => 'Data Lokasi',
      'diskripsi' => '<hr>'
    ];

    $this->template->render_page('lokasi/index', $data, TRUE);

  }

  //fungsi-fungsi AJAX
  public function list()
  {
    if (sizeof($this->session->userdata('user')) < 1)
      die();
    if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER']))
      die();

    $search = "";

    $start = (int) $this->input->post("start");
    $length = (int) $this->input->post("length");
    if ($length > 0)
      $filter = " LIMIT " . $length . " OFFSET " . $start;
    else
      $filter = "";

    $sts = $this->input->post('filter');
    $sts1 = $this->input->post('filter1');
    if (!empty($sts)) {
      if ($sts == 0) {
        $search = "";
      } elseif ($sts == 1) {
        $search = "WHERE statustanah = 1 ";
      } elseif ($sts == 2) {
        $search = "WHERE statustanah = 2 ";
      }
    } elseif (!empty($sts1)) {
      $search = "WHERE tahunpengadaan = " . $sts1 . "";
    }

    if(!empty($sts) && !empty($sts1)){
      $search = "WHERE statustanah = " . $sts . " AND tahunpengadaan = ".$sts1."";
    }

    if ($this->input->post("search")['value'] != '') {
      $search = "WHERE LOWER(lokasi) like '%" . $this->db->escape_str($this->input->post("search")['value']) . "%' ";
    }

    $sql = "SELECT * FROM lokasi " . $search . " ORDER BY id " . $filter;


    // $search = '';
    // if ($this->input->post("search")['value'] != '')
    //   $search = "WHERE lokasi like '%" . $this->db->escape_str($this->input->post("search")['value']) . "%' ";
    // $sql = "SELECT * FROM lokasi " . $search . " ";
    $totaldata = $this->db->query($sql)->num_rows();

    $sql = "SELECT * FROM lokasi " . $search . " ORDER BY id " . $filter;
    $res = $this->db->query($sql);
    $data = [];
    while ($row = $res->unbuffered_row('array')) {
			$row['aksi'] = "
			<a href=\"" . base_url('lokasi/ubah?id=') . $row["id"] . "\" class=\"btn btn-sm btn-warning\"><i class=\"fa fa-edit\"></i> </a>
			<button class=\"btn btn-sm btn-danger\" onClick=\"del('" . $row["id"] . "')\"><i class=\"fa fa-trash-alt\"></i></button>";
      if ($row['statustanah'] == 1) {
        $row['statustanah'] = 'Data Tanah Bermasalah';
      }else{
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

  public function tambah()
  {
    if (@sizeof($this->session->userdata('user')) < 1)
      redirect('/auth/login', 'refresh');
    if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER']))
      redirect('/mainku/dashboard', 'refresh');

    $data = [
      'judul' => 'Tambah Data Lokasi',
      'diskripsi' => '<hr>'
    ];

    $this->template->render_page('lokasi/tambah', $data, TRUE);
  }

  public function tambahData()
  {
    if (@sizeof($this->session->userdata('user')) < 1)
      redirect('/auth/login', 'refresh');
    if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER']))
      redirect('/mainku/dashboard', 'refresh');

    $nama = $this->input->post('nama');
    $distrik = $this->input->post('distrik');
    $tahun = $this->input->post('tahun');
    $statustanah = $this->input->post('statustanah');
    $koordinat = $this->input->post('koordinat');

    try {

      $sql = "INSERT INTO lokasi(lokasi,distrik,tahunpengadaan,statustanah,koordinat) VALUES(
					" . $this->db->escape($nama) . ",
          " . $this->db->escape($distrik) . ",
					" . $this->db->escape($tahun) . ",
          " . $this->db->escape($statustanah) . ",
          " . $this->db->escape($koordinat) . "
					)";
      // $result = $this->db->query($sql)->row_array();
      // die($sql);
      $this->db->query($sql);
      $result = ["status" => "ok", "msg" => "Sukses Tambah"];
    } catch (Exception $e) {
      $result = ["status" => "error", "msg" => "Gagal Tambah"];
    }

    echo json_encode($result);
  }

  public function ubah()
  {
    if (@sizeof($this->session->userdata('user')) < 1)
      redirect('/auth/login', 'refresh');
    if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER']))
      redirect('/mainku/dashboard', 'refresh');
    if (sizeof($this->session->userdata('user')) < 1)
      die();
    // $id = urldecode($nip);
    $id = $this->input->get('id');

    $data = [
      'judul' => 'Ubah Data Pegawai',
      'diskripsi' => '<hr>',
      'list' => $this->M_laporan->readdetaillokasi($id)
    ];

    // die($id);

    $this->template->render_page('lokasi/ubah', $data, TRUE);
  }

  public function ubahData()
  {
    if (@sizeof($this->session->userdata('user')) < 1)
      redirect('/auth/login', 'refresh');
    if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER']))
      redirect('/mainku/dashboard', 'refresh');

    $id = $this->input->post('id');
    $nama = $this->input->post('nama');
    $distrik = $this->input->post('distrik');
    $tahun = $this->input->post('tahun');
    $statustanah = $this->input->post('statustanah');
    $koordinat = $this->input->post('koordinat');

    try {

      $sql = "UPDATE lokasi
							SET id = " . $this->db->escape($id) . ",
									lokasi = " . $this->db->escape($nama) . ",
                  distrik = " . $this->db->escape($distrik) . ",
                  tahunpengadaan = " . $this->db->escape($tahun) . ",
                  statustanah = " . $this->db->escape($statustanah) . ",
                  koordinat = " . $this->db->escape($koordinat) . "
							WHERE id = " . $this->db->escape($id) . "
					";
      // $result = $this->db->query($sql)->row_array();
      // die($sql);
      $this->db->query($sql);
      $result = ["status" => "ok", "msg" => "Sukses Ubah Data"];
    } catch (Exception $e) {
      $result = ["status" => "error", "msg" => "Gagal Ubah Data"];
    }

    echo json_encode($result);
  }


  // public function get($id)
  // {
  //   if (sizeof($this->session->userdata('user')) < 1)
  //     die();
  //   $id = urldecode($id);

  //   $sql = "SELECT *,convert_from(decrypt(data, nip::bytea, 'aes'),'UTF8')::jsonb as data FROM pns WHERE nip=" . $this->db->escape($id) . " ";
  //   $result = $this->db->query($sql)->row_array();
  //   echo json_encode($result);
  // }

  public function hapus($id)
  {
    if (sizeof($this->session->userdata('user')) < 1)
      die();
    // if ($this->session->userdata('user')['role']!='MAINTAINER') die();
    if (!in_array($this->session->userdata('user')['role'], ['OPERATOR', 'MAINTAINER']))
      die();
    $id = urldecode($id);

    try {
      $sql = "DELETE FROM lokasi WHERE id=" . $this->db->escape($id) . " ";
      $res = $this->db->query($sql);

      $result = ["status" => "ok", "msg" => "Sukses Hapus"];
    } catch (Exception $e) {
      $result = ["status" => "error", "msg" => "Gagal Hapus"];
    }

    echo json_encode($result);
  }
}
?>