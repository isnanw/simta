<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<section id="content" class="content">
  <div class="content__header content__boxed overlapping">
    <div class="content__wrap">
      <h1 class="page-title mb-0 mt-2">
        <?= $judul; ?>
      </h1>
      <p class="lead">
        <?= $diskripsi; ?>
      </p>
    </div>
  </div>
  <div class="content__boxed">
    <div class="content__wrap">
      <div class="card">
        <div class="card-header -4 mb-3">
          <div class="row">
            <div class="col-12">
              <div class="card-body ">
                <h3 class="card-title">Form Ubah Lokasi</h3>
                <hr>
                <!-- Block styled form -->
                <!-- <form class="row g-3" action="<?= base_url('lokasi/ubahData') ?>"> -->
                <form class="row g-3" id="frm">
                  <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Lokasi</label>
                    <input required id="nama" name="nama" type="text" class="form-control" value="<?= $list['lokasi'] ?>">
                    <input required id="id" name="id" type="text" class="form-control" value="<?= $list['id'] ?>" hidden>
                  </div>
                  <div class="col-md-6">
                    <label for="distrik" class="form-label">Distrik</label>
                    <select class="form-select" id="basic-usage" name="distrik" data-placeholder="Pilih Distrik">
                      <option></option>
                      <option value="Mimika Baru" <?= ($list['distrik'] == 'Mimika Baru') ? 'selected' : ''; ?>>Mimika Baru</option>
                      <option value="Agimuga" <?= ($list['distrik'] == 'Agimuga') ? 'selected' : ''; ?>>Agimuga</option>
                      <option value="Mimika Baru" <?= ($list['distrik'] == 'Mimika Baru') ? 'selected' : ''; ?>>Mimika Timur</option>
                      <option value="Mimika Barat" <?= ($list['distrik'] == 'Mimika Barat') ? 'selected' : ''; ?>>Mimika Barat</option>
                      <option value="Jita" <?= ($list['distrik'] == 'Jita') ? 'selected' : ''; ?>>Jita</option>
                      <option value="Jila" <?= ($list['distrik'] == 'Jila') ? 'selected' : ''; ?>>Jila</option>
                      <option value="Mimika Timur Jauh" <?= ($list['distrik'] == 'Mimika Timur Jauh') ? 'selected' : ''; ?>>Mimika Timur Jauh</option>
                      <option value="Mimika Tengah" <?= ($list['distrik'] == 'Mimika Tengah') ? 'selected' : ''; ?>>Mimika Tengah</option>
                      <option value="Kuala Kencana" <?= ($list['distrik'] == 'Kuala Kencana') ? 'selected' : ''; ?>>Kuala Kencana</option>
                      <option value="Tembagapura" <?= ($list['distrik'] == 'Tembagapura') ? 'selected' : ''; ?>>Tembagapura</option>
                      <option value="Mimika Barat Jauh" <?= ($list['distrik'] == 'Mimika Barat Jauh') ? 'selected' : ''; ?>>Mimika Barat Jauh</option>
                      <option value="Mimika Barat Tengah" <?= ($list['distrik'] == 'Mimika Barat Tengah') ? 'selected' : ''; ?>>Mimika Barat Tengah</option>
                      <option value="Kwamki Narama" <?= ($list['distrik'] == 'Kwamki Narama') ? 'selected' : ''; ?>>Kwamki Narama</option>
                      <option value="Hoya" <?= ($list['distrik'] == 'Hoya') ? 'selected' : ''; ?>>Hoya</option>
                      <option value="Iwaka" <?= ($list['distrik'] == 'Iwaka') ? 'selected' : ''; ?>>Iwaka</option>
                      <option value="Wania" <?= ($list['distrik'] == 'Wania') ? 'selected' : ''; ?>>Wania</option>
                      <option value="Amar" <?= ($list['distrik'] == 'Amar') ? 'selected' : ''; ?>>Amar</option>
                      <option value="Alama" <?= ($list['distrik'] == 'Alama') ? 'selected' : ''; ?>>Alama</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="tahun" class="form-label">Tahun Pengadaan</label>
                    <input required id="tahun" name="tahun" type="number" class="form-control" value="<?= $list['tahunpengadaan']?>">
                  </div>
                  <div class="col-md-6">
                    <label for="statustanah" class="form-label">Status Tanah</label>
                    <select id="statustanah" name="statustanah" class="form-select">
                      <!-- <option selected>Choose...</option> -->
                      <option value="2" <?= ($list['statustanah'] == '2') ? 'selected' : ''; ?>>Data Tanah Tidak Bermasalah</option>
                      <option value="1" <?= ($list['statustanah'] == '1') ? 'selected' : ''; ?>>Data Tanah Bermasalah</option>
                    </select>
                  </div>
                  <div class="col-md-12">Koordinat Peta</label>
                    <input required id="koordinat" name="koordinat" type="text" class="form-control" value="<?= str_replace(['(', ')'], '', $list['koordinat']) ?>">
                  </div>
                  <hr>
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary"> Simpan </button>
                    <input style="float: right;" class="btn btn-danger" type="button" value="<< Kembali"
                      onclick="history.back(-1)" />
                  </div>

                </form>
                <!-- END : Block styled form -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="mt-auto">
    <div class="content__boxed">
      <div class="content__wrap py-3 py-md-1 d-flex flex-column flex-md-row align-items-md-center">
        <div class="text-nowrap mb-4 mb-md-0">Copyright &copy; 2023 <a href="#" class="ms-1 btn-link fw-bold">SIMTA Kab
            Mimika</a></div>
        <nav class="nav flex-column gap-1 flex-md-row gap-md-3 ms-md-auto" style="row-gap: 0 !important;">
          <!-- <a class="nav-link px-0" href="#">Policy Privacy</a>
                  <a class="nav-link px-0" href="#">Terms and conditions</a>
                  <a class="nav-link px-0" href="#">Contact Us</a> -->
        </nav>
      </div>
    </div>
  </footer>

</section>

<script language="javascript">
  $(function () {
    $('#frm')
      .submit(function (e) {
        $.ajax({
          url: '<?= base_url($this->router->class . '/ubahData'); ?>',
          type: 'POST',
          data: new FormData(this),
          processData: false,
          contentType: false,
          success: function (data) {
            var json = $.parseJSON(data);
            if (json.status == "ok") {
              toastr.success(json.msg);
              location.href = '<?= base_url($this->router->class); ?>';
            } else toastr.error(json.msg);
          }
        });
        e.preventDefault();
      });
  });
</script>