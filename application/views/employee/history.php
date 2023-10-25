<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    margin-left: 270px;
}

@media (max-width: 768px) {


    .table {
        margin-left: 10%;
    }
}
</style>

<body>
    <?php $this->load->view('sidebar_employee'); ?>

    <div class="table-responsive">
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
                    <td><?php echo $row->kegiatan; ?></td>
                    <td><?php echo convDate($row->date); ?></td>
                    <td><?php echo $row->jam_masuk; ?></td>
                    <td>
                        <?php echo $row->jam_pulang; ?>
                    </td>
                    <td>
                        <?php if (!empty($row->keterangan_izin)): ?>
                        <?php echo $row->keterangan_izin; ?>
                        <?php else: ?>
                        <?php echo $row->kegiatan; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row->status !== 'true'): ?>
                        <a href="<?php echo base_url(
                            'employee/aksi_pulang/' . $row->id
                        ); ?>" class="btn btn-success">
                            <i class="fa-solid fa-house"></i>
                        </a>
                        <?php else: ?>
                        <button type="button" class="btn btn-secondary" disabled>
                            <i class="fa-solid fa-house"></i>
                        </button>
                        <?php endif; ?>
                    </td>


                    <td>
                        <?php
                        // Mendapatkan waktu saat ini dalam format jam:menit (misalnya, "15:30")
                        $waktu_sekarang = date('H:i');

                        // Menentukan waktu batas (16:00)
                        $waktu_batas = '16:00';

                        if (
                            $row->status !== 'true' &&
                            $waktu_sekarang >= $waktu_batas
                        ): ?>
                        <a href="<?php echo base_url('employee/update_absen/') .
                            $row->id; ?>" class="btn btn-warning">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <?php else: ?>
                        <a href="<?php echo base_url('employee/update_izin/') .
                            $row->id; ?>" class="btn btn-warning">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <?php endif;
                        ?>
                        <!-- <?php if (!empty($row->keterangan_izin)): ?>
                        <a href="<?php echo base_url(
                            !empty($row->kegiatan)
                                ? 'employee/update_absen/'
                                : 'employee/update_izin/'
                        ) . $row->id; ?>" type="button" class="btn btn-warning">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a> |
                        <?php endif; ?> -->
                    </td>

                </tr>
                <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>