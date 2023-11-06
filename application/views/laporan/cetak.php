<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cetak</title>
</head>

<body>
    <div style="width:auto; margin: auto;">
        <center>
            <h3>Laporan
                <?= $sfilter; ?>
            </h3>
            <h4>DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN</h4>
            <table border="1" width="100%" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lokasi / Berkas</th>
                        <th>Distrik</th>
                        <th>Tahun Pengadaan</th>
                        <th>Status Tanah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $current_location = null;

                    foreach ($list as $row):
                        $nama_lokasi = $row['lokasi'];
                        $nama_dokumen = $row['kodeberkas'];
                        $distrik = $row['distrik'];
                        $tahun = $row['tahunpengadaan'];
                        $statustanah = $row['statustanah'];
                        $statustanahText = ($statustanah == 1) ? "Tanah Bermasalah" : "Tanah Tidak Bermasalah";

                        if ($nama_lokasi != $current_location) {
                            echo "<tr>
                            <td>$i</td>
                            <td><strong>$nama_lokasi</strong></td>
                            <td>$distrik</td>
                            <td>$tahun</td>
                            <td>$statustanahText</td>
                        </tr>";
                            $current_location = $nama_lokasi;
                            $i++;
                        }

                        echo "<tr>
                                <td></td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&bull;";
                                    if (!empty($nama_dokumen)) {
                                        echo $nama_dokumen;
                                    } else {
                                        echo 'Belum Unggah Dokumen';
                                    }
                        echo "   </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>";
                    endforeach;
                    ?>

                </tbody>
            </table>
        </center>
    </div>
</body>

</html>