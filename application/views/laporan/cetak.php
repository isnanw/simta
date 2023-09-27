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
                        $no = $i;
                        $nama_lokasi = $row['lokasi'];
                        $nama_dokumen = $row['kodeberkas'];
                        $distrik = $row['distrik'];
                        $tahun = $row['tahunpengadaan'];
                        $statustanah = $row['statustanah'];
                        if ($nama_lokasi != $current_location) {
                            echo "<tr>
                                    <td><strong>$no</strong></td>
                                    <td><strong>$nama_lokasi</strong></td>
                                    <td>$distrik</td>
                                     <td>$tahun</td>
                                      <td>$statustanah</td>
                                </tr>";
                            $current_location = $nama_lokasi;
                        }

                        echo "<tr><td></td><td colspan='4'>&nbsp;&nbsp;&nbsp;&nbsp;&bull;$nama_dokumen</td></tr>";
                        ?>
                        <!-- <tr>
                        <td style="width: 5%; vertical-align:top"><?= $i; ?></td>
                        <td style="width: 20%; vertical-align:top"><?= $b['lokasi']; ?></td>
                        <td style="width: 20%; vertical-align:top"><?= $b['distrik']; ?></td>
                        <td style="width: 15%; vertical-align:top"> <center><?= $b['tahunpengadaan']; ?></center></td>
                        <td style="width: 25%; vertical-align:top"><?= $b['koordinat']; ?></td>
                    </tr> -->
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </center>
    </div>
</body>

</html>