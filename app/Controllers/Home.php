<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $KelasModel = model("Kelas");
        $data['kelas'] = $KelasModel->findAll();
        return view("_pages/index", $data);
    }

    public function show_pilihan_siswa()
    {
        $id_kelas = $this->request->getPost("id_kelas");

        $KelasModel = model("Kelas");
        $data['kelas'] = $KelasModel->find($id_kelas);

        $SiswaModel = model("Siswa");
        $data['siswa'] = $SiswaModel->where(["id_kelas" => $id_kelas])->find();
        return view("_pages/pilih_siswa", $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }

    public function check_absen_siswa($id_siswa, $tanggal_mulai, $tanggal_selesai)
    {
        $TanggalAbsenModel = model("TanggalAbsen");
        $KelasModel = model("Kelas");
        $SiswaModel = model("Siswa");

        $data['siswa'] = $SiswaModel->find($id_siswa);
        $data['kelas'] = $KelasModel->find($data['siswa']->id_kelas);

        // ambil tanggal pertama dan tanggal terakhir absen
        $tanggal_pertama = $TanggalAbsenModel->orderBy("tanggal asc")->get()->getFirstRow()->tanggal;

        $tanggal_terakhir = $TanggalAbsenModel->orderBy("tanggal desc")->get()->getFirstRow()->tanggal;
        if (strtotime($tanggal_terakhir) > time()) {
            $tanggal_terakhir = date("Y-m-d");
        }

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
        $data["detailKehadiranSiswa"] = $AbsenSiswaModel->getDetailKehadiranForTanggalRangeAndSiswa($tanggal_mulai, $tanggal_selesai, $id_siswa);

        $data['tanggal_mulai'] = $tanggal_mulai;
        $data['tanggal_selesai'] = $tanggal_selesai;
        $data['tanggal_pertama'] = $tanggal_pertama;
        $data['tanggal_terakhir'] = $tanggal_terakhir;
        return pageView("ringkasan_siswa", $data);
    }

    function check_absen_siswa_redirect()
    {
        $id_siswa = $this->request->getPost("id_siswa");

        $TanggalAbsenModel = model("TanggalAbsen");

        // ambil tanggal pertama dan tanggal terakhir absen
        $tanggal_pertama = $TanggalAbsenModel->orderBy("tanggal asc")->get()->getFirstRow()->tanggal;

        $tanggal_terakhir = $TanggalAbsenModel->orderBy("tanggal desc")->get()->getFirstRow()->tanggal;
        if (strtotime($tanggal_terakhir) > time()) {
            $tanggal_terakhir = date("Y-m-d");
        }

        return redirect()->route("check.absen.siswa", [$id_siswa, $tanggal_pertama, $tanggal_terakhir]);
    }
}
