<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<style>
h2 {
    margin-top: 100px;
    margin-left: 285px;
}

form {
    width: 50%;
    margin-left: 285px;
}

.table {
    width: 50%;
    margin-top: 40px;
    margin-left: 285px;
}
</style>

<body>
    <h2>Rekap Harian</h2>
    <?php $this->load->view('sidebar'); ?>
    <form action="<?= base_url('admin/rekap_harian') ?>" method="get">
        <div class="form-group">
            <label for="tanggal">Pilih Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal">
        </div>
        <button type="submit" class="btn btn-primary my-2">Filter</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Kegiatan</th>
                <th>Masuk</th>
                <th>Pulang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rekap_harian as $rekap): ?>
            <tr>
                <td><?= $rekap['id'] ?></td>
                <td><?= panggil_username($rekap['id_karyawan']) ?></td>
                <td><?= $rekap['date'] ?></td>
                <td><?= $rekap['kegiatan'] ?></td>
                <td><?= $rekap['jam_masuk'] ?></td>
                <td><?= $rekap['jam_pulang'] ?></td>
                <td><?= $rekap['status'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>