<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
.all {
    margin-left: 285px;
}

.tomb {
    margin-left: 75%;
}

body {
    margin-top: 100px;
}

.iden {
    width: 90%;
}

.form-container {
    width: 50%;
    /* Atur lebar div form menjadi 100% */
}


/* Style untuk perangkat seluler */
@media (max-width: 767px) {
    .all {
        margin-left: 1px;
        margin-top: 30px;
    }

    .iden {
        width: 100%;
    }

    body {
        margin-top: 5px;
        overflow: auto;
        /* Izinkan discroll */
    }
}

/* Style untuk perangkat desktop */
@media (min-width: 768px) {
    body {
        overflow: hidden;
        /* Larang discroll */
    }
}
</style>

<body>
    <section>
        <?php $this->load->view('sidebar_employee'); ?>
        <div class="all container py-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="<?php echo base_url(
                                './images/karyawan/' . $user->foto
                            ); ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3"><?php echo $user->username; ?></h5>
                            <p class="text-muted mb-4"><?php echo $user->nama_depan .
                                ' ' .
                                $user->nama_belakang; ?></p>
                            <div class="d-flex justify-content-center mb-2">
                                <a href="javascript:void(0);" onclick="confirmLogout();" type="button"
                                    class="btn btn-danger ms-1"><i class="fa-solid fa-right-from-bracket"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iden col-lg-8 form-container">
                    <form method="post" action="<?= base_url(
                        'employee/aksi_ubah_akun'
                    ) ?>" enctype="multipart/form-data">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <h3>Profil <button type="submit" class="tomb btn btn-primary"><i
                                                class="fa-solid fa-floppy-disk"></i></button></h3>

                                    <hr>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" name="username" id="username" class="form-control"
                                                value="<?php echo $user->username; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Email</label>
                                            <input type="text" name="email" id="email" class="form-control"
                                                value="<?php echo $user->email; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Nama Depan</label>
                                            <input type="text" name="nama_depan" id="nama_depan" class="form-control"
                                                value="<?php echo $user->nama_depan; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Nama Belakang</label>
                                            <input type="text" name="nama_belakang" id="nama_belakang"
                                                class="form-control" value="<?php echo $user->nama_belakang; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nama_depan" class="form-label">Password Baru</label>
                                            <input type="password" name="password_baru" class="form-control"
                                                id="username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nama_belakang" class="form-label">Konfirmasi Password</label>
                                            <input type="password" name="konfirmasi_password" class="form-control"
                                                id="email">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="nama_belakang" class="form-label">Foto</label>
                                            <input type="file" name="foto" class="form-control" id="foto"
                                                value="<?php echo $user->foto; ?>">
                                        </div>
                                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>
    <script>
    // Fungsi untuk menampilkan konfirmasi SweetAlert saat tombol logout ditekan
    function confirmLogout() {
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: "Anda akan keluar dari akun Anda.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika konfirmasi "Ya", maka alihkan ke logout
                window.location.href = "<?php echo base_url('auth/logout'); ?>";
            }
        });
    }
    </script>
</body>

</html>