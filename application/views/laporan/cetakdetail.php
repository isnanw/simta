<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cetak</title>
</head>

<body>
    <div style="width:auto; margin: auto;">
        <center>
            <h3>Detail Lokasi Pertanahan</h3>
            <h4>DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN</h4>
            <table width="100%" style="border-collapse:collapse;">
                <tr>
                    <td width="45%">Nama Lokasi</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['lokasi']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Distrik</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['distrik']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Tahun Pengadaan</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['tahunpengadaan']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Status Tanah</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['statustanah']; ?></td>
                </tr>
                <tr>
                    <td width="45%">Koordinat</td>
                    <td width="5%"><center>:</center></td>
                    <td width="50%"><?= $list['koordinat']; ?></td>
                </tr>

            </tr>
        </table>
    </center>

    <br>

    <center>
        <h4>Daftar Dokumen</h4>
        <table border="1" width="100%" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Dokumen</th>
                    <th>Tanggal</th>
                    <th>Uraian</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dokumen)) { ?>
                    <?php $i = 1; ?>
                    <?php foreach ($dokumen as $b) : ?>
                        <tr>
                            <td style="width: 5%; vertical-align:top"><?= $i; ?></td>
                            <td style="width: 25%; vertical-align:top"><?= $b['kodeberkas']; ?></td>
                            <td style="width: 30%; vertical-align:top"><?= $b['tanggal']; ?></td>
                            <td style="width: 40%; vertical-align:top"><?= $b['uraian']; ?></td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php } else {?>
                    <tr>
                        <td colspan="4" align="center">NIHIL</td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    </center>
</div>
</body>

</html>