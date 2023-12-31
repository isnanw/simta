<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<style>
    .leaflet-container {
        height: 400px;
        width: 600px;
        max-width: 100%;
        max-height: 100%;
    }
</style>
<!-- CONTENTS -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<section id="content" class="content">
    <div class="content__header content__boxed overlapping">
        <div class="content__wrap">

            <!-- Page title and information -->
            <h1 class="page-title mb-2">
                <?php echo $judul; ?>
            </h1>
            <h2 class="h5"><b>SIMTA</b> (Sistem Informasi Data Kepegawaian) Dalam Percepatan Layanan Kepegawaian Pada
                DINAS PERUMAHAN KAWASAN PEMUKIMAN DAN PERTANAHAN</h2>
            <p>Penggunaan SIMTA ini dalam rangka peningkatan kualitas pelayanan publik pada <b><u>DINAS PERUMAHAN
                        KAWASAN PEMUKIMAN DAN PERTANAHAN KABUPATEN MIMIKA</u></b> dengan memanfaatkan teknologi
                informasi berupa Aplikasi
                berbasis Website.</p>
            <hr>
            <!-- END : Page title and information -->

        </div>

    </div>

    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div id="map" style="width: 100%; height: 580px;"></div>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="mt-auto">
        <div class="content__boxed">
            <div class="content__wrap py-3 py-md-1 d-flex flex-column flex-md-row align-items-md-center">
                <div class="text-nowrap mb-4 mb-md-0">Copyright &copy; 2022 <a href="#"
                        class="ms-1 btn-link fw-bold">SIMTA Kab Mimika</a></div>
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

<script>
    const map = L.map('map').setView([-4.47854, 136.891582], 11);

    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var rekaplokasi = <?php echo json_encode($rekaplokasi); ?>;

    rekaplokasi.forEach(function (coordinate) {
        var match = coordinate.koordinat.match(/\((-?\d+\.\d+),(-?\d+\.\d+)\)/);
        if (match) {
            var latitude = parseFloat(match[1]);
            var longitude = parseFloat(match[2]);
            var lokasi = coordinate.lokasi;
            var status = coordinate.statustanah;
            var jumlah = coordinate.jumlah;

            var blueIcon = L.icon({
                iconUrl: '<?= base_url('assets/blue.png'); ?>',
                iconSize: [25, 32], // Sesuaikan dengan ukuran ikon Anda
            });

            var redIcon = L.icon({
                iconUrl: '<?= base_url('assets/red.png'); ?>',
                iconSize: [25, 32], // Sesuaikan dengan ukuran ikon Anda
            });

            var bermasalah = 'Tanah Bermasalah';
            var takbermasalah = 'Tanah Tidak Bermasalah';

            // Pilih ikon berdasarkan nilai statustanah
            var icon = status === '1' ? redIcon : blueIcon;
            var statustanah = status === '1' ? bermasalah : takbermasalah;

            L.marker([latitude, longitude], { icon: icon })
                .addTo(map)
                .bindPopup('<b>' + statustanah + '</b><br />' + '<b>' + lokasi + '</b><br />Jumlah Dokumen : ' + jumlah + '')
                .openPopup();
        }
    });

    const popup = L.popup()
        // .setLatLng([-4.6640, 136.6315])
        .setContent('I am a standalone popup.')
    // .openOn(map);

    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent(`You clicked the map at ${e.latlng.toString()}`)
            .openOn(map);
    }

    map.on('click', onMapClick);

</script>