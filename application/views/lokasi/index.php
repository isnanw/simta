<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
  .close {
    color: black;
    float: right;
    font-size: 30px;
    /* color: #fff; */
  }

  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }
</style>
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
      <!-- Table with toolbar -->
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-3">
                      <label for="filter"><b>Filter Status Tanah</b></label>
                      <select id="filter" name="filter" class="form-control">
                        <option value="0">--- Semua ---</option>
                        <option value="2">Data Tanah Tidak Bermasalah</option>
                        <option value="1">Data Tanah Bermasalah</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label for="filter1"><b>Filter Tahun</b></label>
                      <select id="filter1" name="filter1" class="form-control">
                        <option value="0">--- Semua Tahun ---</option>
                        <?php
                        $sql1 = "SELECT distinct tahunpengadaan from lokasi ";
                        $res = $this->db->query($sql1);
                        while ($row1 = $res->unbuffered_row('array')) {
                          ?>
                          <option value="<?= $row1['tahunpengadaan']; ?>">
                            <?= $row1['tahunpengadaan']; ?>
                          </option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <br>
                      <button type="button" id="btn-filter" class="btn btn-success"><i
                          class="nav-icon fas fa-check"></i>Filter</button>
                    </div>
                    <div class="col-md-3">
                      <br>
                      <a style="float: right;" href="<?= base_url('lokasi/tambah'); ?>" type="button"
                        class="btn btn-primary"><i class="nav-icon fas fa-plus"></i>
                        Tambah </a>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                  <table id="tblData" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>NO</th>
                        <th>Nama Lokasi</th>
                        <th>Distrik</th>
                        <th>Tahun Pengadaan</th>
                        <th>Status Tanah</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- FOOTER -->
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
  <!-- END - FOOTER -->
</section>

<div class="modal fade" id="modal-detail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="detail">
        <div class="modal-header">
          <h4 class="modal-title">Detail</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card-body">
            <div class="form-group mb-3">
              <label for="no">No</label>
              <input name="no" type="text" class="form-control" id="no" placeholder="no">
            </div>
            <div class="form-group mb-3">
              <label for="nama">Nama Lokasi</label>
              <input name="nama" type="text" class="form-control" id="nama" placeholder="Nama">
            </div>
            <hr>
            <div class="form-group mb-3">
              <table id="tblDetail" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Atribut</th>
                    <th>Data</th>
                  </tr>
                </thead>
                <tbody>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<script language="javascript">
  tblDetail = null;
  var tblData;

  function del(id) {
    if (confirm("Yakin akan menghapus data?")) {
      $.ajax({
        url: '<?= base_url($this->router->class . '/hapus/'); ?>' + id,
        type: 'GET',
        success: function (data) {
          var json = $.parseJSON(data);
          if (json.status == "ok") {
            toastr.success(json.msg);
            $('#tblData').DataTable().ajax.reload();
          } else toastr.error(json.msg);
        }
      });
    }
  }

  function detail(id) {
    $.ajax({
      url: '<?= base_url($this->router->class . '/get/'); ?>' + id,
      type: 'GET',
      success: function (data) {
        var json = $.parseJSON(data);
        $("#id").val(json.id);
        $("#nama").val(json.nama);
        tblDetail.clear().draw();
        $.each(JSON.parse(json.data), function (key, val) {
          tblDetail.rows.add([{
            "attr": key,
            "data": val
          }]);
        });
        tblDetail.rows.add(JSON.parse(json.data));
        tblDetail.columns.adjust().draw();
        $('#modal-detail').modal('show');

      }
    });
  }



  $(function () {
    tblDetail = $("#tblDetail").DataTable({
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "paging": true,
      "columns": [{
        "data": "attr"
      },
      {
        "data": "data"
      },
      ],
    });

    tblData = $("#tblData").DataTable({
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "paging": true,
      "processing": true,
      "serverSide": true,
      "ordering": false,
      "ajax": {
        "url": "<?= base_url($this->router->class . '/list'); ?>",
        "type": "POST",
        "data": function (data) {
          data.filter = $('#filter').val();
          data.filter1 = $('#filter1').val();
        }
      },
      "columns": [{
        "data": null,
        "orderable": false,
        "render": function (data, type, row, meta) {
          // Gunakan meta.row untuk mendapatkan nomor urut
          return meta.row + 1;
        }
      },
      {
        "data": "lokasi"
      },
      {
        "data": "distrik"
      },
      {
        "data": "tahunpengadaan"
      },
      {
        "data": "statustanah"
      },
      {
        "data": "aksi"
      },
      ],
      "buttons": ["copy", "csv", "excel", "pdf", "print"],
    }).buttons().container().appendTo('#tblData_wrapper .col-md-6:eq(0)');

    $('#btn-filter').click(function () {
      $('#tblData').DataTable().ajax.reload();
    });
  });
</script>