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
        $TanggalAbsenModel = model("TanggalAbsen");

        // ambil kelas saat ini
        $data["kelas"] = $KelasModel->find(
            session()->get("userdata")->id
        );

        // ambil kehadiran siswa untuk tanggal di $_GET (set default ke hari ini)
        $tanggal = $this->request->getGet("tanggal") && $this->request->getGet("tanggal") != "" ? $this->request->getGet("tanggal") : date("Y-m-d");

        $AbsenSiswaModel = model("AbsenSiswa");
        $data["kehadiranSiswa"] = $AbsenSiswaModel->getKehadiranForTanggalAndKelas($tanggal, session()->get("userdata"));

        $data['tanggal'] = $tanggal;

        $data['tanggal_pertama'] = $TanggalAbsenModel->orderBy("tanggal asc")->get()->getFirstRow()->tanggal;

        $data['tanggal_terakhir'] = $TanggalAbsenModel->orderBy("tanggal desc")->get()->getFirstRow()->tanggal;
        if (strtotime($data['tanggal_terakhir']) > time()) {
            $data['tanggal_terakhir'] = date("Y-m-d");
        }

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

    public function ringkasan()
    {
        $KelasModel = model("Kelas");
        $TanggalAbsenModel = model("TanggalAbsen");

        // ambil kelas saat ini
        $data["kelas"] = $KelasModel->find(
            session()->get("userdata")->id
        );

        // ambil tanggal pertama dan tanggal terakhir absen
        $tanggal_pertama = $TanggalAbsenModel->orderBy("tanggal asc")->get()->getFirstRow()->tanggal;

        $tanggal_terakhir = $TanggalAbsenModel->orderBy("tanggal desc")->get()->getFirstRow()->tanggal;
        if (strtotime($tanggal_terakhir) > time()) {
            $tanggal_terakhir = date("Y-m-d");
        }

        $tanggal_mulai = $this->request->getGet("tanggal_mulai");
        $tanggal_selesai = $this->request->getGet("tanggal_selesai");

        if (!$tanggal_mulai || $tanggal_mulai == "" || strtotime($tanggal_mulai) < strtotime($tanggal_pertama)) {
            $tanggal_mulai = $tanggal_pertama;
        }
        if (!$tanggal_selesai || $tanggal_selesai == "") {
            $tanggal_selesai = $tanggal_terakhir;
        }

        if (strtotime($tanggal_mulai) > strtotime($tanggal_selesai)) {
            sendErrorMessage("Tanggal mulai harus lebih dulu dari tanggal selesai");
        }

        $AbsenSiswaModel = model("AbsenSiswa");
        $data["kehadiranSiswa"] = $AbsenSiswaModel->getRingkasanKehadiranForTanggalRangeAndKelas($tanggal_mulai, $tanggal_selesai, session()->get("userdata"));

        $data['tanggal_mulai'] = $tanggal_mulai;
        $data['tanggal_selesai'] = $tanggal_selesai;
        $data['tanggal_pertama'] = $tanggal_pertama;
        $data['tanggal_terakhir'] = $tanggal_terakhir;

        return pageView("guru/ringkasan", $data);
    }
}
