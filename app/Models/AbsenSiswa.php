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
        $tanggalAbsenTarget = $TanggalAbsenModel->where(["tanggal" => $tanggal])->get();

        // return false jika tanggal tidak ada di tanggal absen
        if ($tanggalAbsenTarget->getNumRows() == 0) {
            return false;
        }

        $tanggalAbsenTarget = $tanggalAbsenTarget->getFirstRow();

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
}