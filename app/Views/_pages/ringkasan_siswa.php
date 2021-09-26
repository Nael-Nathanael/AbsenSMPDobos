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
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <a class="text-decoration-none text-primary lead"
               href="<?= isGuru() ? $_SERVER['HTTP_REFERER'] : base_url() ?>">
                <i class="fa fa-angle-left me-2"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="container-fluid mt-2">
    <div class="card shadow">
        <div class="card-header bg-transparent">
            <div class="card-title mb-0 h4">
                Ringkasan Absensi Siswa
            </div>
            <?= strftime("%A, %d %B %Y", strtotime($tanggal_mulai)) ?>
            -
            <?= strftime("%A, %d %B %Y", strtotime($tanggal_selesai)) ?>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center h-100">
                        <table class="lead d-lg-table d-none">
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
                        <div class="d-lg-none d-block">
                            <p class="mb-0" style="line-height: 1.1">Siswa :</p>
                            <p class="lead fw-bold">
                                <?= $siswa->nama ?>
                            </p>

                            <p class="mb-0" style="line-height: 1.1">Kelas :</p>
                            <p class="lead fw-bold">
                                <?= $kelas->nama ?>
                            </p>
                            <p class="mb-0" style="line-height: 1.1">Guru :</p>
                            <p class="lead fw-bold">
                                <?= $kelas->guru ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="d-flex justify-content-lg-end align-items-center h-100 flex-wrap justify-content-center">
                        <div class="m-1 shadow rounded p-1 d-flex flex-column justify-content-end align-items-center bg-primary text-white"
                             style="width: 75px; height: 75px">
                            <p class="fw-bold mb-0 h3" id="hadir">

                            </p>
                            <small>Hadir</small>
                        </div>

                        <div class="m-1 shadow text-white bg-danger rounded p-1 d-flex flex-column justify-content-end align-items-center"
                             style="width: 75px; height: 75px">
                            <p class="fw-bold mb-0 h3" id="tidak_hadir">

                            </p>
                            <small>Alpa</small>
                        </div>

                        <div class="m-1 shadow text-white bg-success rounded p-1 d-flex flex-column justify-content-end align-items-center"
                             style="width: 75px; height: 75px">
                            <p class="fw-bold mb-0 h3" id="sakit">

                            </p>
                            <small>Sakit</small>
                        </div>

                        <div class="m-1 shadow text-white bg-info rounded p-1 d-flex flex-column justify-content-end align-items-center"
                             style="width: 75px; height: 75px">
                            <p class="fw-bold mb-0 h3" id="izin">

                            </p>
                            <small>Izin</small>
                        </div>

                        <div class="m-1 shadow text-white bg-dark rounded p-1 d-flex flex-column justify-content-end align-items-center"
                             style="width: 75px; height: 75px">
                            <p class="fw-bold mb-0 h3" id="terlambat">

                            </p>
                            <small>Terlambat</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid my-2">
    <div class="card shadow">
        <div class="card-body bg-transparent">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th class="w-100">Status Kehadiran (Alpa, Sakit, Izin, dan Terlambat)</th>
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
                        <tr class="<?= $detailRow->status_kehadiran == "h" ? "d-none" : "" ?>">
                            <td nowrap><?= strftime("%d %b %Y", strtotime($detailRow->tanggal)) ?></td>
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