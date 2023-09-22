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
    const map = L.map('map').setView([-4.6640, 136.6315], 10);

    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // const marker = L.marker([51.5, -0.09]).addTo(map)
    //     .bindPopup('<b>Hello world!</b><br />I am a popup.').openPopup();

    // const circle = L.circle([51.508, -0.11], {
    //     color: 'red',
    //     fillColor: '#f03',
    //     fillOpacity: 0.5,
    //     radius: 500
    // }).addTo(map).bindPopup('I am a circle.');

    // const polygon = L.polygon([
    //     [51.509, -0.08],
    //     [51.503, -0.06],
    //     [51.51, -0.047]
    // ]).addTo(map).bindPopup('I am a polygon.');


    // const popup = L.popup()
    //     .setLatLng([51.513, -0.09])
    //     .setContent('I am a standalone popup.')
    //     .openOn(map);

    // function onMapClick(e) {
    //     popup
    //         .setLatLng(e.latlng)
    //         .setContent(`You clicked the map at ${e.latlng.toString()}`)
    //         .openOn(map);
    // }

    // map.on('click', onMapClick);

</script>