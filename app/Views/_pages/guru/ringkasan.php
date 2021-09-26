<?= $this->extend('_layout/general_layout') ?>

<?= $this->section('content') ?>
<div class="page-heading">
    <h3>Ringkasan Absensi</h3>
    <h5>Kelas: <?= session()->get("userdata")->nama ?></h5>
    <h5>Guru: <?= session()->get("userdata")->guru ?></h5>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card card-body shadow-sm">
                <form id="tanggalSelectForm" class="d-flex align-items-center w-100 justify-content-around">
                    <div class="form-group text-center">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                               value="<?= date("Y-m-d", strtotime($tanggal_mulai)) ?>"
                               min="<?= date("Y-m-d", strtotime($tanggal_pertama)) ?>"
                               max="<?= date("Y-m-d", strtotime($tanggal_terakhir)) ?>"
                               onchange="document.getElementById('tanggalSelectForm').submit()">
                    </div>

                    <span class="mx-2 mt-2">-</span>

                    <div class="form-group text-center">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
                               value="<?= date("Y-m-d", strtotime($tanggal_selesai)) ?>"
                               min="<?= date("Y-m-d", strtotime($tanggal_pertama)) ?>"
                               max="<?= date("Y-m-d", strtotime($tanggal_terakhir)) ?>"
                               onchange="document.getElementById('tanggalSelectForm').submit()">
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex flex-column flex-wrap align-items-start">
                    <div class="card-title">Ringkasan Absensi Siswa -
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
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 1px">No</th>
                                <th>Siswa</th>
                                <th style="width: 150px">Hadir</th>
                                <th style="width: 150px">Tidak Hadir</th>
                                <th style="width: 150px">Sakit</th>
                                <th style="width: 150px">Ijin</th>
                                <th style="width: 150px">Terlambat</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($kehadiranSiswa as $index => $barisKehadiranSiswa): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>

                                    <td>
                                        <a href="<?= route_to("check.absen.siswa", $barisKehadiranSiswa->id, $tanggal_mulai, $tanggal_selesai) ?>">
                                            <?= $barisKehadiranSiswa->nama ?>
                                        </a>
                                    </td>
                                    <td><?= $barisKehadiranSiswa->hadir ?> hari</td>
                                    <td><?= $barisKehadiranSiswa->tidak_hadir ?> hari</td>
                                    <td><?= $barisKehadiranSiswa->sakit ?> hari</td>
                                    <td><?= $barisKehadiranSiswa->izin ?> hari</td>
                                    <td><?= $barisKehadiranSiswa->terlambat ?> hari</td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>