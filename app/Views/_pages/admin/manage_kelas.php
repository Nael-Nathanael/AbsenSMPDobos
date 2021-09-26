<?= $this->extend('_layout/general_layout') ?>

<?= $this->section('content') ?>
<div class="page-heading">
    <a href="<?= route_to("admin.panel")?>">
        <i class="fa fa-angle-left"></i> Kembali ke daftar kelas
    </a>
    <h3>Kelas <?= $kelas->nama ?></h3>
    <h5>Guru: <?= $kelas->guru ?></h5>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-sm-between flex-wrap align-items-center">
                    <div class="card-title">Daftar Siswa</div>
                    <button class="btn btn-primary ms-2" type="button" data-bs-toggle="modal"
                            data-bs-target="#tambahSiswaModal">
                        <i class="fa fa-plus"></i> Daftarkan Siswa Baru
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 1px">No</th>
                                <th>Nama Siswa</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($siswa as $index => $barisSiswa): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $barisSiswa->nama ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-icon btn-warning me-2" type="button"
                                                    onclick="ubahSiswa(<?= $barisSiswa->id ?>, '<?= $barisSiswa->nama ?>')">
                                                <i class="fa fa-pen"></i> Ubah Siswa
                                            </button>

                                            <form action="<?= route_to("admin.kelas.manage.siswa.delete") ?>"
                                                  method="post"
                                                  id="formDelete<?= $barisSiswa->id ?>">
                                                <input type="hidden" name="id" value="<?= $barisSiswa->id ?>">
                                                <button class="btn btn-icon btn-danger me-2" type="button"
                                                        onclick="confirmDeleteSiswa(<?= $barisSiswa->id ?>)">
                                                    <i class="fa fa-trash"></i> Hapus Siswa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
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

<div class="modal fade" id="tambahSiswaModal" tabindex="-1" aria-labelledby="tambahSiswaModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= route_to("admin.kelas.manage.siswa.create", $kelas->id) ?>" method="post"
              class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahSiswaModalLabel"><i class="fa fa-plus me-2"></i>Daftarkan Siswa Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="name">Nama Siswa</label>
                    <input class="form-control" id="name" name="name" required type="text"
                           value="<?= old("name") ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="ubahSiswaModal" tabindex="-1" aria-labelledby="ubahSiswaModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= route_to("admin.kelas.manage.siswa.update") ?>" method="post" class="modal-content">
            <input type="hidden" name="edit_id" id="edit_id">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahSiswaModalLabel"><i class="fa fa-pen me-2"></i>Ubah Data Siswa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="edit_name">Nama Siswa</label>
                    <input class="form-control" id="edit_name" name="edit_name" required
                           type="text"
                           value="<?= old("edit_name") ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("javascript") ?>
<script>
    const editModal = new bootstrap.Modal(document.getElementById("ubahSiswaModal"))

    function ubahSiswa(id, namaSiswa) {
        document.getElementById("edit_id").value = id
        document.getElementById("edit_name").value = namaSiswa

        editModal.show()
    }

    function confirmDeleteSiswa(id) {
        Swal.fire({
            title: 'Konfirmasi hapus siswa?',
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
