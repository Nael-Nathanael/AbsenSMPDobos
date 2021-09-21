<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
        <form method="POST" action="<?= route_to("auth.guru.login") ?>" class="card-body">
            <h2 class="card-title text-center mb-3">Masuk Sebagai Guru</h2>
            <div class="form-group mb-2">
                <label for="id_kelas" class="d-none">Pilih Kelas</label>
                <select required name="id_kelas" id="id_kelas" class="form-select">
                    <option value="" selected disabled>Pilih Kelas</option>
                    <?php foreach ($kelas as $datumKelas): ?>
                        <option value="<?= $datumKelas->id ?>" <?= old("id_kelas") !== null && old("id_kelas") == $datumKelas->id ? 'selected' : '' ?>>
                            <?= $datumKelas->nama ?> (<?= $datumKelas->guru ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="password" class="d-none">Kata Sandi Absensi</label>
                <input type="password" class="form-control" placeholder="Kata Sandi" name="password"
                       id="password" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mt-3">Masuk</button>
            </div>

            <hr>
            <a href="<?= base_url() ?>" class="text-decoration-none d-block">
                Siswa Klik Disini
            </a>

            <a href="<?= route_to("auth.admin.login_page") ?>" class="text-decoration-none d-block">
                Administrator Klik Disini
            </a>
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
</body>
</html>