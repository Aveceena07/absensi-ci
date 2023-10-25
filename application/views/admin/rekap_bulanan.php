<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
.table {
    width: 70%;
    margin-top: 40px;
    margin-left: 285px;
}

h2 {
    margin-top: 100px;
    margin-left: 285px;
}

form {
    width: 50%;
    margin-left: 285px;
}

.isi {
    margin-left: 30px;
}


@media (max-width: 768px) {
    form {
        margin-left: 10%;
    }

    h2 {
        margin-left: 10%;
    }

    .table {
        margin-left: 10%;
        margin-top: 10px;
    }
}
</style>

<body>
    <h2>Rekap Bulanan</h2>
    <?php $this->load->view('sidebar'); ?>
    <form action="<?= base_url('admin/rekap_bulanan') ?>" method="post">
        <div class="form-group">
            <select class="form-control" id="bulan" name="bulan">
                <option>Pilih Bulan</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success mt-3"><i class="fa-solid fa-filter"></i></button>
        <a href="<?php echo base_url(
            'admin/export_rekap_bulanan'
        ); ?>" class="btn btn-primary mt-3"><i class="fa-solid fa-file-export"></i></a>
    </form>

    <table class="table table-responsive table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kegiatan</th>
                <th>Tanggal</th>
                <th>Jam masuk</th>
                <th>Jam Pulang</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php if (!empty($absen)): ?>
            <?php
            $no = 0;
            foreach ($absen as $row):
                $no++; ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo nama_karyawan($row->id_karyawan); ?></td>
                <td><?php echo $row->kegiatan; ?></td>
                <td><?php echo convDate($row->date); ?></td>
                <td><?php echo $row->jam_masuk; ?></td>
                <td><?php echo $row->jam_pulang; ?></td>
                <td><?php echo $row->keterangan_izin; ?></td>
                <td><?php echo $row->status; ?></td>
            </tr>
            <?php
            endforeach;
            ?>
            <?php else: ?>
            <tr>
                <td colspan="7">Tidak ada data yang ditemukan .</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </tr>
    </tbody>
    </table>
</body>

</html>