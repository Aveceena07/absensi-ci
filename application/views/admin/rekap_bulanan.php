<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
.table {
    width: 50%;
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
    <h2>Rekap Mingguan</h2>
    <?php $this->load->view('sidebar'); ?>
    <form action="<?= base_url('admin/rekap_bulanan') ?>" method="get">
        <div class="form-group">
            <select class="form-control" id="bulan" name="bulan">
                <option>Pilih Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Filter</button>
    </form>
    <table class="table table-light table-hover">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total Absensi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rekap_bulanan as $data): ?>
            <tr>
                <td><?= date('F', mktime(0, 0, 0, $data['bulan'], 1)) ?></td>
                <td><?= $data['total_absensi'] ?></td>
            </tr>
            <tr class="detail-row" data-month="<?= $data['bulan'] ?>">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="isi">
                        <?php foreach ($rekap_harian as $rekap_harian): ?>
                        <?php if (
                            date('n', strtotime($rekap_harian['date'])) ==
                            $data['bulan']
                        ): ?>
                        <tr>
                            <td><?= $rekap_harian['id'] ?></td>
                            <td><?= panggil_username(
                                $rekap_harian['id_karyawan']
                            ) ?></td>
                            <td><?= $rekap_harian['date'] ?></td>
                            <td><?= $rekap_harian['kegiatan'] ?></td>
                            <td><?= $rekap_harian['jam_masuk'] ?></td>
                            <td><?= $rekap_harian['jam_pulang'] ?></td>
                            <td><?= $rekap_harian['status'] ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>