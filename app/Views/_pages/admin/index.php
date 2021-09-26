<?= $this->extend('_layout/general_layout') ?>

<?= $this->section('content') ?>
<div class="page-heading">
    <h3>Panel Admin</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-sm-between flex-wrap align-items-center">
                    <div class="card-title">Daftar Kelas</div>
                    <button class="btn btn-primary ms-2" type="button" data-bs-toggle="modal"
                            data-bs-target="#tambahKelasModal">
                        <i class="fa fa-plus"></i> Buat Kelas Baru
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 1px">No</th>
                                <th>Kelas</th>
                                <th>Guru</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($kelas as $index => $barisKelas): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $barisKelas->nama ?></td>
                                    <td><?= $barisKelas->guru ?></td>
                                    <td>
                                        <div class="d-flex">

                                            <a class="btn btn-icon btn-sm btn-primary me-2"
                                               href="<?= route_to("admin.kelas.manage.siswa", $barisKelas->id) ?>">
                                                <i class="fa fa-user-graduate"></i> Siswa
                                            </a>

                                            <button class="btn btn-icon btn-sm btn-warning me-2" type="button"
                                                    onclick="ubahKelas(<?= $barisKelas->id ?>, '<?= $barisKelas->nama ?>', '<?= $barisKelas->guru ?>')">
                                                <i class="fa fa-pen"></i> Ubah
                                            </button>

                                            <form action="<?= route_to("admin.kelas.delete") ?>" method="post"
                                                  id="formDelete<?= $barisKelas->id ?>">
                                                <input type="hidden" name="id" value="<?= $barisKelas->id ?>">
                                                <button class="btn btn-icon btn-sm btn-danger me-2" type="button"
                                                        onclick="confirmDeleteKelas(<?= $barisKelas->id ?>)">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>

                                            <button class="btn btn-icon btn-sm btn-info me-2" type="button"
                                                    onclick="ubahPassword(<?= $barisKelas->id ?>)">
                                                <i class="fa fa-cogs"></i> Ubah Kata Sandi
                                            </button>
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

<div class="modal fade" id="tambahKelasModal" tabindex="-1" aria-labelledby="tambahKelasModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= route_to("admin.kelas.create") ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKelasModalLabel"><i class="fa fa-plus mr-2"></i>Buat Kelas Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="name">Nama Kelas</label>
                    <input class="form-control" id="name" name="name" placeholder="Contoh: 7C" required type="text"
                           value="<?= old("name") ?>">
                </div>

                <div class="form-group mb-2">
                    <label for="guru">Nama Wali Kelas</label>
                    <input class="form-control" id="guru" name="guru" placeholder="Contoh: Ibu Netta Pandoy"
                           required type="text" value="<?= old("guru") ?>">
                </div>

                <div class="form-group mb-2">
                    <label for="password">Kata Sandi Absensi</label>
                    <input class="form-control" id="password" name="password" placeholder="********" required
                           type="password" autocomplete="new-password">
                    <p class="form-helper mb-0">Kata sandi absensi digunakan guru atau sekretaris untuk mencatat
                        absensi
                        harian kelas, <span
                                class="text-danger">jangan berikan kata sandi ini ke seluruh siswa di kelas</span>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <small>
                    Daftar siswa kelas dapat diatur setelah menekan tombol 'simpan'
                </small>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="ubahKelasModal" tabindex="-1" aria-labelledby="ubahKelasModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= route_to("admin.kelas.update") ?>" method="post" class="modal-content">
            <input type="hidden" name="edit_id" id="edit_id">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahKelasModalLabel"><i class="fa fa-pen me-2"></i>Ubah Data Kelas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="edit_name">Nama Kelas</label>
                    <input class="form-control" id="edit_name" name="edit_name" placeholder="Contoh: 7C" required
                           type="text"
                           value="<?= old("edit_name") ?>">
                </div>

                <div class="form-group mb-2">
                    <label for="edit_guru">Nama Wali Kelas</label>
                    <input class="form-control" id="edit_guru" name="edit_guru" placeholder="Contoh: Ibu Netta Pandoy"
                           required type="text" value="<?= old("edit_guru") ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="ubahPasswordKelasModal" tabindex="-1" aria-labelledby="ubahPasswordKelasModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= route_to("admin.kelas.update.password") ?>" method="post" class="modal-content">
            <input type="hidden" name="edit_password_id" id="edit_password_id">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahPasswordKelasModalLabel"><i class="fa fa-pen me-2"></i>
                    Ubah Kata Sandi Absensi Kelas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="edit_password">Kata Sandi Absensi</label>
                    <input class="form-control" id="edit_password" name="edit_password" placeholder="********" required
                           type="password" autocomplete="new-password">
                    <p class="form-helper mb-0">Kata sandi absensi digunakan guru atau sekretaris untuk mencatat
                        absensi harian kelas, <span
                                class="text-danger">jangan berikan kata sandi ini ke seluruh siswa di kelas</span>
                    </p>
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
    const editModal = new bootstrap.Modal(document.getElementById("ubahKelasModal"))
    const editPasswordModal = new bootstrap.Modal(document.getElementById("ubahPasswordKelasModal"))

    function ubahKelas(id, namaKelas, guru) {
        document.getElementById("edit_id").value = id
        document.getElementById("edit_name").value = namaKelas
        document.getElementById("edit_guru").value = guru

        editModal.show()
    }

    function confirmDeleteKelas(id) {
        Swal.fire({
            title: 'Konfirmasi hapus kelas?',
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

    function ubahPassword(id) {
        document.getElementById("edit_password_id").value = id
        editPasswordModal.show()
    }
</script>
<?= $this->endSection(); ?>
