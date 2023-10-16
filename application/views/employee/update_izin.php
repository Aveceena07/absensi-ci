<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
.kegiatan {
    margin-left: 20%;
    margin-right: 10px;
    margin-top: 100px;
}
</style>

<body>
    <?php $this->load->view('sidebar_employee'); ?>
    <div class="kegiatan mb-3">
        <?php foreach ($absensi as $absen): ?>
        <form method="post" action="<?= base_url(
            'employee/aksi_update_izin'
        ) ?>" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $absen->id; ?>">
            <h3>Ubah Keterangan</h3>
            <br>
            <!--  -->
            <label for="Kegiatan" class="form-label">Keterangan :</label>
            <textarea class="form-control" aria-label="With textarea" name="keterangan_izin"></textarea>
            <button type="submit" class="btn btn-success mt-4">Ubah</button>
        </form>
        <?php endforeach; ?>
    </div>
</body>

</html>