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
    width: 78%;
    margin-top: 10px;
    margin-left: 285px;
}

form {
    width: 50%;
    margin-left: 285px;
}

.exp {
    margin-left: 285px;
}

h2 {
    margin-top: 100px;
    margin-left: 285px;
}

@media (max-width: 768px) {
    h2 {
        margin-left: 10%;
    }

    .exp {
        margin-left: 10%;
    }

    .table {
        margin-top: 10px;
        margin-left: 10%;
    }
}
</style>

<body>
    <h2>Rekap Mingguan</h2>
    <?php $this->load->view('sidebar'); ?>
    <table class="table table-light table-hover">
        <a class="exp btn btn-success mb-2" href="<?= base_url(
            'admin/export_mingguan'
        ) ?>"><i class="fa-solid fa-file-export"></i></a>
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
            <?php foreach ($absensi as $absen): ?>
            <tr>
                <td><span class="number"><?php echo $i; ?></span></td>
                <td>
                    <?php echo $absen['kegiatan']; ?>
                </td>
                <td>
                    <?php echo $absen['date']; ?>
                </td>
                <td>
                    <?php echo $absen['jam_masuk']; ?>
                </td>
                <td>
                    <?php echo $absen['jam_pulang']; ?>
                </td>
                <td>
                    <?php echo $absen['keterangan_izin']; ?>
                </td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>