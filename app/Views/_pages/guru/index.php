<?= $this->extend('_layout/general_layout') ?>

<?= $this->section('content') ?>
<div class="page-heading">
    <h3>Selamat Datang di Panel Absen</h3>
    <h5>Kelas: <?= session()->get("userdata")->nama ?></h5>
    <h5>Guru: <?= session()->get("userdata")->guru ?></h5>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-sm-between flex-wrap align-items-center">
                    <div class="card-title">Absensi Siswa -
                        <span class="fw-bold">
                        <?= strftime("%A, %d %B %Y", strtotime($tanggal)) ?>
                            <?php if (date("Y-m-d") == date("Y-m-d", strtotime($tanggal))): ?>
                                (Hari ini)
                            <?php endif; ?>
                        </span>
                    </div>
                    <div>
                        <form id="tanggalSelectForm">
                            <label for="tanggal" class="d-none">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control"
                                   value="<?= date("Y-m-d", strtotime($tanggal)) ?>"
                                   min="<?= date("Y-m-d", strtotime($tanggal_pertama)) ?>"
                                   max="<?= date("Y-m-d", strtotime($tanggal_terakhir)) ?>"

                                   onchange="document.getElementById('tanggalSelectForm').submit()">
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($kehadiranSiswa): ?>
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 1px">No</th>
                                    <th>Siswa</th>
                                    <th class="w-100">Status Kehadiran</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($kehadiranSiswa as $index => $barisKehadiranSiswa): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td nowrap><?= $barisKehadiranSiswa->nama ?></td>
                                        <td>
                                            <div class="w-100 d-flex justify-content-around align-items-center">
                                                <button type="button"
                                                        class="btn btn-<?= $barisKehadiranSiswa->status_kehadiran == "h" ? "primary" : "outline-primary" ?> absenButton"
                                                        id="absenButton<?= $barisKehadiranSiswa->id_absen_siswa ?>_h"
                                                        onclick="ubahAbsen('<?= $barisKehadiranSiswa->id_absen_siswa ?>', 'h')">
                                                    <i class="fa fa-check"></i> Hadir
                                                </button>
                                                <button type="button"
                                                        class="btn btn-<?= $barisKehadiranSiswa->status_kehadiran == "a" || $barisKehadiranSiswa->status_kehadiran == null ? "danger" : "outline-danger" ?> absenButton"
                                                        id="absenButton<?= $barisKehadiranSiswa->id_absen_siswa ?>_a"
                                                        onclick="ubahAbsen('<?= $barisKehadiranSiswa->id_absen_siswa ?>', 'a')">
                                                    <i class="fa fa-times"></i> Tidak Hadir
                                                </button>
                                                <button type="button"
                                                        class="btn btn-<?= $barisKehadiranSiswa->status_kehadiran == "s" ? "success" : "outline-success" ?> absenButton"
                                                        id="absenButton<?= $barisKehadiranSiswa->id_absen_siswa ?>_s"
                                                        onclick="ubahAbsen('<?= $barisKehadiranSiswa->id_absen_siswa ?>', 's')">
                                                    <i class="fa fa-hospital"></i> Sakit
                                                </button>
                                                <button type="button"
                                                        class="btn btn-<?= $barisKehadiranSiswa->status_kehadiran == "i" ? "info" : "outline-info" ?> absenButton"
                                                        id="absenButton<?= $barisKehadiranSiswa->id_absen_siswa ?>_i"
                                                        onclick="ubahAbsen('<?= $barisKehadiranSiswa->id_absen_siswa ?>', 'i')">
                                                    <i class="fa fa-envelope"></i> Ijin
                                                </button>
                                                <button type="button"
                                                        class="btn btn-<?= $barisKehadiranSiswa->status_kehadiran == "t" ? "dark" : "outline-dark" ?> absenButton"
                                                        id="absenButton<?= $barisKehadiranSiswa->id_absen_siswa ?>_t"
                                                        onclick="ubahAbsen('<?= $barisKehadiranSiswa->id_absen_siswa ?>', 't')">
                                                    <i class="fa fa-clock"></i> Terlambat
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <h6 class="text-center">Absensi tidak dicatat untuk
                            hari <?= strftime("%A, %d %B %Y", strtotime($tanggal)) ?></h6>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>

<?= $this->section("javascript") ?>
<script>
    function ubahAbsen(id_absen_siswa, status_kehadiran) {
        const requestData = new FormData();
        requestData.append("id", id_absen_siswa)
        requestData.append("status_kehadiran", status_kehadiran)

        postData(
            '<?= route_to("guru.panel.ubah_absen_siswa")?>',
            requestData
        ).then(data => {
            console.log(data)
            let target_h = document.getElementById(`absenButton${data.id}_h`);
            let target_a = document.getElementById(`absenButton${data.id}_a`);
            let target_s = document.getElementById(`absenButton${data.id}_s`);
            let target_i = document.getElementById(`absenButton${data.id}_i`);
            let target_t = document.getElementById(`absenButton${data.id}_t`);

            // set semuanya jadi outline
            target_h.classList.remove(`btn${data.status_kehadiran === "h" ? '-outline' : ''}-primary`)
            target_h.classList.add(`btn${data.status_kehadiran === "h" ? '' : '-outline'}-primary`)

            target_a.classList.remove(`btn${data.status_kehadiran === "a" ? '-outline' : ''}-danger`)
            target_a.classList.add(`btn${data.status_kehadiran === "a" ? '' : '-outline'}-danger`)

            target_s.classList.remove(`btn${data.status_kehadiran === "s" ? '-outline' : ''}-success`)
            target_s.classList.add(`btn${data.status_kehadiran === "s" ? '' : '-outline'}-success`)

            target_i.classList.remove(`btn${data.status_kehadiran === "i" ? '-outline' : ''}-info`)
            target_i.classList.add(`btn${data.status_kehadiran === "i" ? '' : '-outline'}-info`)

            target_t.classList.remove(`btn${data.status_kehadiran === "t" ? '-outline' : ''}-dark`)
            target_t.classList.add(`btn${data.status_kehadiran === "t" ? '' : '-outline'}-dark`)

        }).catch(error => {
            console.log(error)
        });
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section("styles") ?>
<style>
    .absenButton {
        min-width: 150px;
    }
</style>
<?= $this->endSection(); ?>
