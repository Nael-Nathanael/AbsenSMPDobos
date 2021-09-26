<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenSiswa extends Model
{
    protected $table = 'absen_siswa';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_tanggal_absen', 'id_siswa', 'status_kehadiran'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    function getKehadiranForTanggalAndKelas($tanggal, $kelas)
    {
        $TanggalAbsenModel = model("TanggalAbsen");
        $SiswaModel = model("Siswa");


        // get id_tanggal_absen hari ini
        $tanggalAbsenTarget = $TanggalAbsenModel->where(["tanggal" => $tanggal])->first();

        // return false jika tanggal tidak ada di tanggal absen
        if (!$tanggalAbsenTarget) {
            return false;
        }

        $id_tanggal_absen = $tanggalAbsenTarget->id;

        // buat absen siswa untuk seluruh siswa yang belum memiliki absen siswa tanggal ini
        $siswa_belum_absen = $SiswaModel
            ->select("
                $SiswaModel->table.id as id_siswa,
                $id_tanggal_absen as id_tanggal_absen,
                'a' as status_kehadiran
            ")
            ->join($this->table, "$this->table.id_siswa = $SiswaModel->table.$SiswaModel->primaryKey AND $this->table.id_tanggal_absen = $id_tanggal_absen", "left")
            ->where("$SiswaModel->table.id_kelas", $kelas->id)
            ->where("$this->table.id IS NULL")
            ->where("$SiswaModel->table.deleted_at IS NULL")
            ->where("$this->table.deleted_at IS NULL")
            ->get();

        if ($siswa_belum_absen->getNumRows() != 0) {
            $this->insertBatch($siswa_belum_absen->getResult());
        }

        $kehadiran = $SiswaModel
            ->select("
                $SiswaModel->table.nama, 
                $this->table.id as id_absen_siswa,
                $this->table.status_kehadiran,
                $this->table.id_siswa,
                $this->table.id_tanggal_absen
            ")
            ->join($this->table, "$this->table.id_siswa = $SiswaModel->table.$SiswaModel->primaryKey", "left")
            ->join($TanggalAbsenModel->table, "$this->table.id_tanggal_absen = $TanggalAbsenModel->table.$TanggalAbsenModel->primaryKey", "left")
            ->where("$TanggalAbsenModel->table.tanggal", $tanggal)
            ->where("$SiswaModel->table.id_kelas", $kelas->id)
            ->where("$SiswaModel->table.deleted_at IS NULL")
            ->where("$this->table.deleted_at IS NULL")
            ->where("$TanggalAbsenModel->table.deleted_at IS NULL")
            ->get();

        return $kehadiran->getResult();
    }

    function getRingkasanKehadiranForTanggalRangeAndKelas($tanggal_mulai, $tanggal_selesai, $kelas)
    {
        $TanggalAbsenModel = model("TanggalAbsen");

        // cari jumlah tanggal
        $jumlahTanggal = $TanggalAbsenModel->where(
            [
                "tanggal >=" => $tanggal_mulai,
                "tanggal <=" => $tanggal_selesai,
                "deleted_at" => null
            ]
        )->get()->getNumRows();

        // tanggal tidak hadir = total tanggal - hadir - sakit - izin - terlambat
        $result = $this->db->query("SELECT siswa.id,
       siswa.nama,
       IFNULL(hadir.total, 0)     as hadir,
       IFNULL(tidak_hadir.total, 0) + ($jumlahTanggal - IFNULL(hadir.total, 0) - IFNULL(sakit.total, 0) - IFNULL(izin.total, 0) - IFNULL(terlambat.total, 0) - IFNULL(tidak_hadir.total, 0)) as tidak_hadir,
       IFNULL(sakit.total, 0)     as sakit,
       IFNULL(izin.total, 0)      as izin,
       IFNULL(terlambat.total, 0) as terlambat
FROM siswa
         LEFT JOIN (SELECT id_siswa, count(id_siswa) as total
                    FROM absen_siswa
                    LEFT JOIN tanggal_absen ta on absen_siswa.id_tanggal_absen = ta.id
                    WHERE status_kehadiran = 'h' AND ta.tanggal >= '$tanggal_mulai' AND ta.tanggal <= '$tanggal_selesai' AND absen_siswa.deleted_at IS NULL AND ta.deleted_at is null
                    GROUP BY id_siswa) as hadir on hadir.id_siswa = siswa.id

         LEFT JOIN (SELECT id_siswa, count(id_siswa) as total
                    FROM absen_siswa
                    LEFT JOIN tanggal_absen ta on absen_siswa.id_tanggal_absen = ta.id
                    WHERE status_kehadiran = 's' AND ta.tanggal >= '$tanggal_mulai' AND ta.tanggal <= '$tanggal_selesai' AND absen_siswa.deleted_at IS NULL AND ta.deleted_at is null
                    GROUP BY id_siswa) as sakit on sakit.id_siswa = siswa.id

         LEFT JOIN (SELECT id_siswa, count(id_siswa) as total
                    FROM absen_siswa
                    LEFT JOIN tanggal_absen ta on absen_siswa.id_tanggal_absen = ta.id
                    WHERE status_kehadiran = 'a' AND ta.tanggal >= '$tanggal_mulai' AND ta.tanggal <= '$tanggal_selesai' AND absen_siswa.deleted_at IS NULL AND ta.deleted_at is null
                    GROUP BY id_siswa) as tidak_hadir on tidak_hadir.id_siswa = siswa.id

         LEFT JOIN (SELECT id_siswa, count(id_siswa) as total
                    FROM absen_siswa
                    LEFT JOIN tanggal_absen ta on absen_siswa.id_tanggal_absen = ta.id
                    WHERE status_kehadiran = 'i' AND ta.tanggal >= '$tanggal_mulai' AND ta.tanggal <= '$tanggal_selesai' AND absen_siswa.deleted_at IS NULL AND ta.deleted_at is null
                    GROUP BY id_siswa) as izin on izin.id_siswa = siswa.id

         LEFT JOIN (SELECT id_siswa, count(id_siswa) as total
                    FROM absen_siswa
                    LEFT JOIN tanggal_absen ta on absen_siswa.id_tanggal_absen = ta.id
                    WHERE status_kehadiran = 't' AND ta.tanggal >= '$tanggal_mulai' AND ta.tanggal <= '$tanggal_selesai' AND absen_siswa.deleted_at IS NULL AND ta.deleted_at is null
                    GROUP BY id_siswa) as terlambat on terlambat.id_siswa = siswa.id
        WHERE siswa.id_kelas = $kelas->id
AND siswa.deleted_at IS NULL
");

        return $result->getResult();
    }

    function getDetailKehadiranForTanggalRangeAndSiswa($tanggal_mulai, $tanggal_selesai, $id_siswa)
    {
        $result = $this->db->query(
            "
SELECT `absen_siswa`.`status_kehadiran`, `tanggal_absen`.`tanggal`
FROM `tanggal_absen`
LEFT JOIN (SELECT * FROM absen_siswa WHERE id_siswa = $id_siswa) absen_siswa ON `absen_siswa`.`id_tanggal_absen` = `tanggal_absen`.`id`
WHERE `tanggal_absen`.`tanggal` >= '$tanggal_mulai'
AND `tanggal_absen`.`tanggal` <= '$tanggal_selesai'
AND `absen_siswa`.`deleted_at` IS NULL
AND `tanggal_absen`.`deleted_at` IS NULL
ORDER BY `tanggal_absen`.`tanggal` DESC"
        );

        return $result->getResult();
    }
}