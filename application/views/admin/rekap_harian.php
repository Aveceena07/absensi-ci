<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

.exp {
    margin-top: 8px;
}

.table {
    width: 50%;
    margin-top: 20px;
    margin-left: 285px;
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
    <h2>Rekap Harian</h2>
    <?php $this->load->view('sidebar'); ?>

    <form action="<?= base_url('admin/rekap_harian') ?>" method="get">
        <div class="form-group">
            <label for="tanggal">Pilih Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal">
        </div>
        <button type="submit" class="btn btn-success my-2"><i class="fa-solid fa-filter"></i></button>
        <a class="exp btn btn-primary mb-2" href="<?= base_url(
            'admin/export_harian'
        ) ?>"><i class="fa-solid fa-file-export"></i></a>
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