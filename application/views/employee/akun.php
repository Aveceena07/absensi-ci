<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
.container {
    margin-top: 50px;
}
</style>

<body>
    <div class="container">
        <h2 class="text-center mb-3">Ubah Akun</h2>
        <form method="post" action="<?= base_url(
            'employee/aksi_ubah_akun'
        ) ?>" enctype="multipart/form-data" class="row g-3">
            <div class="col-12">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="inputAddress" placeholder=""
                    value="<?php echo $user->username; ?>">
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail4"
                    value="<?php echo $user->email; ?>">
            </div>
            <div class="col-md-6">
                <label for="foto" class="form-label">Profil</label>
                <input type="file" name="foto" class="form-control" id="foto">
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" name="password_baru" class="form-control" id="inputPassword4">
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">Konfirmasi Password</label>
                <input type="password" name="konfirmasi_password" class="form-control" id="inputPassword4">
            </div>

            <div class="col-md-6">
                <label for="nama_depan" class="form-label">Nama Depan</label>
                <input type="nama_depan" name="nama_depan" class="form-control" id="inputPassword4"
                    value="<?php echo $user->nama_depan; ?>">
            </div>

            <div class="col-md-6">
                <label for="nama_belakang" class="form-label">Nama Belakang</label>
                <input type="nama_belakang" name="nama_belakang" class="form-control" id="inputPassword4"
                    value="<?php echo $user->nama_belakang; ?>">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i></button>
                <a href="<?php echo base_url(
                    'employee/profil'
                ); ?>" type="submit" class="btn btn-danger"><i class="fa-solid fa-arrow-left"></i></a>
            </div>
        </form>
    </div>
</body>

</html>