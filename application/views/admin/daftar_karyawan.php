<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Tambahkan tag-head Anda di sini, seperti CSS dan JavaScript yang dibutuhkan -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/your/custom.css">
</head>
<style>
h2 {
    margin-top: 10%;
    margin-left: 29%;
}

table {
    margin-top: 3%;
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
            <h2>Daftar Karyawan</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($absensi as $row): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row->username; ?></td>
                        <td><?php echo $row->email; ?></td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Tambahkan tag-script Anda di sini, seperti JavaScript yang dibutuhkan -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="path/to/your/custom.js"></script>
</body>

</html>