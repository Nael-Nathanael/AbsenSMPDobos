<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
          integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <title>SMP Don Bosco Manado - SIABSEN</title>

    <style>
        html, body {
            padding: 0;
            margin: 0;
        }

        main {
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            background-image: url("<?= base_url("/img/background_login.jpg") ?>");
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;

            position: relative;
        }

        .card {
            max-width: 600px;
            min-width: 400px;
            position: relative;
        }

        .overlay {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            background-color: black;
            opacity: .5;
        }
    </style>
</head>
<body>

<main>
    <div class="overlay"></div>

    <div class="card shadow">
        <form method="POST" action="<?= route_to("check.absen.redirector") ?>" class="card-body"
              id="pilih_kelas_form">
            <a href="<?= base_url() ?>" class="text-decoration-none text-primary">
                <i class="fa fa-angle-left"></i> Kembali
            </a>
            <h2 class="card-title text-center mb-3">Cek Absen</h2>
            <div class="form-group mb-2">
                <label for="id_kelas" class="d-none">Pilih Kelas</label>
                <select name="id_kelas" id="id_kelas" class="form-select" readonly="" disabled>
                    <option value="<?= $kelas->id ?>" selected disabled>
                        <?= $kelas->nama ?> (<?= $kelas->guru ?>)
                    </option>
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="id_siswa" class="d-none">Pilih Nama Anda</label>
                <select name="id_siswa" id="id_siswa" class="form-select"
                        onchange="submitForm()">
                    <option value="" selected disabled>Pilih Nama Anda</option>
                    <?php foreach ($siswa as $barisSiswa): ?>
                        <option value="<?= $barisSiswa->id ?>">
                            <?= $barisSiswa->nama ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (session()->getFlashdata("success") !== null): ?>
    <script>
        Swal.fire("Berhasil", "<?= session()->getFlashdata("success")?>", "success");
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata("error") !== null): ?>
    <script>
        Swal.fire("Gagal", "<?= session()->getFlashdata("error")?>", "error");
    </script>
<?php endif; ?>

<script>
    function submitForm() {
        document.getElementById('pilih_kelas_form').submit()
    }
</script>
</body>
</html>