<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Guru extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $KelasModel = model("Kelas");

        // ambil kelas saat ini
        $data["kelas"] = $KelasModel->find(
            session()->get("userdata")->id
        );

        // ambil kehadiran siswa untuk tanggal di $_GET (set default ke hari ini)
        $tanggal = $this->request->getGet("tanggal") && $this->request->getGet("tanggal") != "" ? $this->request->getGet("tanggal") : date("Y-m-d");

        $AbsenSiswaModel = model("AbsenSiswa");
        $data["kehadiranSiswa"] = $AbsenSiswaModel->getKehadiranForTanggalAndKelas($tanggal, session()->get("userdata"));

        $data['tanggal'] = $tanggal;

        return pageView("guru/index", $data);
    }

    public function loginPage()
    {
        $KelasModel = model("Kelas");
        $data['kelas'] = $KelasModel->findAll();
        return view("_pages/guru/login.php", $data);
    }

    public function login()
    {
        $id_kelas = $this->request->getPost("id_kelas");
        $password = md5($this->request->getPost("password"));

        $KelasModel = model("Kelas");

        // cek jika password benar
        $kelasTarget = $KelasModel->where(
            [
                "id" => $id_kelas,
                "password" => $password
            ]
        )->get();

        if ($kelasTarget->getNumRows() == 0) {
            sendErrorMessage("Password salah");
            return redirect()->back()->withInput();
        }

        $kelasTarget = $kelasTarget->getFirstRow();

        // for easiness
        $kelasTarget->isAdmin = 0;

        // masukan ke userdata
        session()->set("userdata", $kelasTarget);
        return redirect()->route("guru.panel");
    }

    public function ubah_absen_siswa()
    {
        $id_absen_siswa = $this->request->getPost("id");
        $status_kehadiran = $this->request->getPost("status_kehadiran");

        $AbsenSiswaModel = model("AbsenSiswa");
        $AbsenSiswaModel->save(
            [
                "id" => $id_absen_siswa,
                "status_kehadiran" => $status_kehadiran
            ]
        );

        return $this->respond(
            $AbsenSiswaModel->find($id_absen_siswa),
            200
        );
    }
}
