<?= $this->extend('_layout/general_layout') ?>

<?= $this->section('content') ?>
<div class="page-heading">
    <h3>Daftar Tanggal Absen</h3>
    <p>Di menu ini, administrator dapat mengubah tanggal apa saja yang akan dicatat absen nya.</p>
</div>
<div class="page-content">
    <section class="row">
        <?php if (count($tanggal) == 0): ?>
            <div class="col-md-6 offset-md-3">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="card-title">Belum Ada Tanggal Absen</div>
                    </div>
                    <div class="card-body">
                        <p>
                            Belum ada tanggal untuk periode ini. Pilih tanggal mulai, tanggal selesai, dan klik tombol
                            tambahkan tanggal absen untuk menambahkan tanggal absen awal.
                        </p>
                        <form class="row" action="<?= route_to("admin.panel.tanggal.generate") ?>" method="post">
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label for="mulai">Mulai</label>
                                    <input type="date" name="mulai" id="mulai" class="form-control" required
                                           value="<?= old("mulai") ?>">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label for="selesai">Selesai</label>
                                    <input type="date" name="selesai" id="selesai" class="form-control" required
                                           value="<?= old("selesai") ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="w-100 d-flex justify-content-center align-items-center">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-plus"></i> Tambahkan Tanggal Absen
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-sm-between flex-wrap align-items-center">
                        <div class="card-title">Daftar Tanggal Absensi</div>
                        <button class="btn btn-primary ms-2" type="button" data-bs-toggle="modal"
                                data-bs-target="#tambahTanggalModal">
                            <i class="fa fa-plus"></i> Tambah Tanggal Absensi
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 1px">No</th>
                                    <th class="w-100">Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($tanggal as $index => $barisTanggal): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= strftime("%A, %d %B %Y", strtotime($barisTanggal->tanggal)); ?></td>
                                        <td>
                                            <form action="<?= route_to("admin.panel.tanggal.delete") ?>"
                                                  method="post"
                                                  id="formDelete<?= $barisTanggal->id ?>">
                                                <input type="hidden" name="id" value="<?= $barisTanggal->id ?>">
                                                <button class="btn btn-icon btn-danger me-2" type="button"
                                                        onclick="confirmDeleteTanggal(<?= $barisTanggal->id ?>)">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php if (count($tanggal) > 0): ?>
    <div class="modal fade" id="tambahTanggalModal" tabindex="-1" aria-labelledby="tambahTanggalModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="<?= route_to("admin.panel.tanggal.generate") ?>" method="post" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahTanggalModalLabel"><i class="fa fa-plus mr-2"></i>Tambah Tanggal
                        Absensi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="mulai">Mulai</label>
                        <input type="date" name="mulai" id="mulai" class="form-control" required
                               value="<?= old("mulai") ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="selesai">Selesai</label>
                        <input type="date" name="selesai" id="selesai" class="form-control" required
                               value="<?= old("selesai") ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section("javascript") ?>
<script>

    function confirmDeleteTanggal(id) {
        Swal.fire({
            title: 'Konfirmasi hapus tanggal?',
            showDenyButton: true,
            confirmButtonText: 'Ya, Hapus',
            denyButtonText: `Batalkan`,
            icon: "warning"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`formDelete${id}`).submit()
            }
        })
    }

</script>
<?= $this->endSection(); ?>
