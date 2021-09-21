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
}
