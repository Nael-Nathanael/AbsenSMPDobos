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

    <title>Ringkasan Absensi Siswa</title>
</head>
<body class="bg-light">

<div class="container-fluid mt-2">
    <a class="card card-body shadow-sm flex-row align-items-center text-decoration-none text-primary lead"
       href="<?= isGuru() ? $_SERVER['HTTP_REFERER'] : base_url() ?>">
        <i class="fa fa-angle-left me-2"></i> Kembali
    </a>
</div>

<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <div class="card-title mb-0 h4">
                Ringkasan Absensi Siswa
            </div>
            <div class="h5 mb-0">
                <span class="fw-bold">
                        <?= strftime("%A, %d %B %Y", strtotime($tanggal_mulai)) ?>
                </span>
                sampai
                <span class="fw-bold">
                        <?= strftime("%A, %d %B %Y", strtotime($tanggal_selesai)) ?>
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <table class="lead">
                    <tr>
                        <td>Siswa</td>
                        <td class="ps-4 pe-2">:</td>
                        <td class="fw-bold"><?= $siswa->nama ?></td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td class="ps-4 pe-2">:</td>
                        <td class="fw-bold"><?= $kelas->nama ?></td>
                    </tr>
                    <tr>
                        <td>Guru Wali Kelas</td>
                        <td class="ps-4 pe-2">:</td>
                        <td class="fw-bold"><?= $kelas->guru ?></td>
                    </tr>
                </table>
                <div>
                    <p class="lead fw-bold text-center mb-2">
                        Ringkasan
                    </p>
                    <div class="d-flex">
                        <div class="border p-1 d-flex flex-column justify-content-end align-items-center"
                             style="width: 75px; height: 75px">
                            <p class="fw-bold text-primary mb-0 h3" id="hadir">

                            </p>
                            <small>Hadir</small>
                        </div>

                        <div class="border p-1 d-flex flex-column justify-content-end align-items-center"
                             style="width: 75px; height: 75px">
                            <p class="fw-bold text-danger mb-0 h3" id="tidak_hadir">

                            </p>
                            <small>Alpa</small>
                        </div>

                        <div class="border p-1 d-flex flex-column justify-content-end align-items-center"
                             style="width: 75px; height: 75px">
                            <p class="fw-bold text-success mb-0 h3" id="sakit">

                            </p>
                            <small>Sakit</small>
                        </div>

                        <div class="border p-1 d-flex flex-column justify-content-end align-items-center"
                             style="width: 75px; height: 75px">
                            <p class="fw-bold text-info mb-0 h3" id="izin">

                            </p>
                            <small>Izin</small>
                        </div>

                        <div class="border p-1 d-flex flex-column justify-content-end align-items-center"
                             style="width: 75px; height: 75px">
                            <p class="fw-bold text-dark mb-0 h3" id="terlambat">

                            </p>
                            <small>Terlambat</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="table-responsive">

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Status Kehadiran</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $hadir = 0;
                    $sakit = 0;
                    $izin = 0;
                    $alpa = 0;
                    $terlambat = 0;
                    ?>
                    <?php foreach ($detailKehadiranSiswa as $detailRow): ?>
                        <tr>
                            <td><?= strftime("%A, %d %B %Y", strtotime($detailRow->tanggal)) ?></td>
                            <td>
                                <p class="mb-0 lead">
                                    <?php switch ($detailRow->status_kehadiran): ?>
<?php case "h": ?>
                                            <?php $hadir++; ?>
                                            <span class="lead badge bg-primary">
                                                <i class="fa fa-check"></i> Hadir
                                            </span>
                                            <?php break; ?>

                                        <?php case "s": ?>
                                            <?php $sakit++; ?>
                                            <span class="lead badge bg-success">
                                                <i class="fa fa-hospital"></i> Sakit
                                            </span>
                                            <?php break; ?>

                                        <?php case "i": ?>
                                            <?php $ijin++; ?>
                                            <span class="lead badge bg-info">
                                                <i class="fa fa-envelope"></i> Izin
                                            </span>
                                            <?php break; ?>

                                        <?php case "t": ?>

                                            <?php $terlambat++; ?>
                                            <span class="lead badge bg-dark">
                                                <i class="fa fa-clock"></i> Terlambat
                                            </span>
                                            <?php break; ?>

                                        <?php default: ?>
                                            <?php $alpa++; ?>
                                            <span class="lead badge bg-danger">
                                                <i class="fa fa-times"></i> Tidak Hadir
                                            </span>
                                            <?php break; ?>
                                        <?php endswitch; ?>
                                </p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("hadir").innerHTML = '<?= $hadir?>';
    document.getElementById("tidak_hadir").innerHTML = '<?= $alpa ?>';
    document.getElementById("sakit").innerHTML = '<?= $sakit?>';
    document.getElementById("izin").innerHTML = '<?= $izin?>';
    document.getElementById("terlambat").innerHTML = '<?= $terlambat?>';
</script>
</body>
</html>