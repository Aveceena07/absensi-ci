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
/* Style untuk perangkat seluler */
@media (max-width: 767px) {
    body {
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
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="<?php echo base_url(
                                './images/karyawan/' . $user->foto
                            ); ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3"><?php echo $user->username; ?></h5>
                            <p class="text-muted mb-4"><?php echo $user->role; ?></p>
                            <div class="d-flex justify-content-center mb-2">
                                <a href="<?php echo base_url(
                                    'employee/akun'
                                ); ?>" type="button" class="btn btn-primary"><i class="fa-solid fa-gear"></i></a>
                                <a href="javascript:void(0);" onclick="confirmLogout();" type="button"
                                    class="btn btn-danger ms-1"><i class="fa-solid fa-right-from-bracket"></i></a>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Username</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $user->username; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $user->email; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Nama Depan</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $user->nama_depan; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Nama Belakang</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $user->nama_belakang; ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Role</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?php echo $user->role; ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>


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