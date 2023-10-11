<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
.table {
    width: 78%;
    margin-top: 100px;
    margin-left: 280px;
}
</style>

<body>
    <?php $this->load->view('sidebar_employee'); ?>
    <table class="table text-center table-hover">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Kegiatan</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Jam Masuk</th>
                <th scope="col">Jam Pulang</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Pulang</th>
                <th scope="col text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($absensi as $row): ?>
            <tr>
                <td><span class="number"><?php echo $i; ?></span></td>
                <td><?php echo $row['kegiatan']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['jam_masuk']; ?></td>
                <td><?php echo $row['jam_pulang']; ?></td>
                <td>
                    <?php if ($row->keterangan_izin == 'true'): ?>
                    <p>Izin</p>
                    <?php else: ?>
                    <p>Masuk</p>
                    <?php endif; ?>
                </td>
                <td><?php echo $row['status']; ?></td>
                <td><button type="button" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></button> |
                    <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
            </tr>
            <?php $i++;
                // Tingkatkan nomor urut
                ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>