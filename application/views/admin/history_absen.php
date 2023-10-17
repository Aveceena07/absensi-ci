<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
h2 {
    margin-top: 10%;
    margin-left: 29%;
}

.expo {
    margin-top: 1%;
    margin-left: 29%;
}

table {
    margin-top: 2%;
    margin-left: 29%;
}

@media (max-width: 768px) {
    h2 {
        margin-top: 80px;
        margin-left: 10%;
    }

    .table {
        margin-left: 10%;
    }
}
</style>

<body>
    <?php $this->load->view('sidebar'); ?>
    <div class="comtainer-fluid">
        <div class="col-md-9">
            <h2>History Absen</h2>
            <a href="<?= base_url(
                'admin/export_karyawan'
            ) ?>" type="button" class="expo btn btn-success"><i class="fa-solid fa-file-export"></i></a>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kegiatan</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Jam Pulang</th>
                        <th scope="col">Keteragan Izin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($absensi as $row): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row->kegiatan; ?></td>
                        <td><?php echo $row->date; ?></td>
                        <td><?php echo $row->jam_masuk; ?></td>
                        <td><?php echo $row->jam_pulang; ?></td>
                        <td><?php echo $row->keterangan_izin; ?></td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Tambahkan tag-script Anda di sini, seperti JavaScript yang dibutuhkan -->
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="path/to/your/custom.js"></script>
</body>

</html>