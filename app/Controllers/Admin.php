<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index(): string
    {
        $KelasModel = model("Kelas");
        $data["kelas"] = $KelasModel->findAll();
        return pageView("admin/index", $data);
    }

    public function kelas_create()
    {
        $name = $this->request->getPost("name");
        $guru = $this->request->getPost("guru");
        $password = md5($this->request->getPost("password"));

        // cek jika ada kelas yang nama nya sama
        $KelasModel = model("Kelas");

        $cariNama = $KelasModel->where(["nama" => $name]);

        if ($cariNama->countAllResults() > 0) {
            sendErrorMessage("Sudah ada kelas dengan nama sama");
            return redirect()->back()->withInput();
        }

        $KelasModel->insert(
            [
                "nama" => $name,
                "guru" => $guru,
                "password" => $password
            ]
        );

        sendSuccessMessage("Kelas telah ditambahkan");
        return redirect()->back();
    }

    public function kelas_update()
    {
        $id = $this->request->getPost("edit_id");
        $name = $this->request->getPost("edit_name");
        $guru = $this->request->getPost("edit_guru");

        // cek jika ada kelas yang nama nya sama
        $KelasModel = model("Kelas");

        $cariNama = $KelasModel->where([
            "nama" => $name,
            "id !=" => $id
        ]);

        if ($cariNama->countAllResults() > 0) {
            sendErrorMessage("Sudah ada kelas dengan nama sama");
            return redirect()->back();
        }

        $KelasModel->save(
            [
                "id" => $id,
                "nama" => $name,
                "guru" => $guru,
            ]
        );

        sendSuccessMessage("Kelas telah diperbarui");
        return redirect()->back();
    }

    public function kelas_update_password()
    {
        $id = $this->request->getPost("edit_password_id");
        $password = md5($this->request->getPost("edit_password"));

        // cek jika ada kelas yang nama nya sama
        $KelasModel = model("Kelas");

        $KelasModel->save(
            [
                "id" => $id,
                "password" => $password,
            ]
        );

        sendSuccessMessage("Kata sandi kelas telah diperbarui");
        return redirect()->back();
    }

    public function kelas_delete()
    {
        $id = $this->request->getPost("id");

        // cek jika ada kelas yang nama nya sama
        $KelasModel = model("Kelas");

        $KelasModel->delete($id);

        sendSuccessMessage("Kelas telah dihapus");
        return redirect()->back();
    }

    public function kelas_manage($id): string
    {
        $KelasModel = model("Kelas");
        $data["kelas"] = $KelasModel->find($id);

        $SiswaModel = model("Siswa");
        $data["siswa"] = $SiswaModel->where(
            [
                "id_kelas" => $data["kelas"]->id
            ]
        )->find();

        return pageView("admin/manage_kelas", $data);
    }

    public function siswa_create($id_kelas)
    {
        $name = $this->request->getPost("name");

        // cek jika ada kelas yang nama nya sama
        $SiswaModel = model("Siswa");

        $cariNama = $SiswaModel->where(
            [
                "nama" => $name,
                "id_kelas" => $id_kelas
            ]
        );

        if ($cariNama->countAllResults() > 0) {
            sendErrorMessage("Sudah ada siswa dengan nama sama");
            return redirect()->back()->withInput();
        }

        $SiswaModel->insert(
            [
                "nama" => $name,
                "id_kelas" => $id_kelas,
            ]
        );

        sendSuccessMessage("Siswa telah ditambahkan");
        return redirect()->back();
    }

    public function siswa_update()
    {
        $id = $this->request->getPost("edit_id");
        $name = $this->request->getPost("edit_name");

        // cek jika ada kelas yang nama nya sama
        $SiswaModel = model("Siswa");

        $cariNama = $SiswaModel->where([
            "nama" => $name,
            "id !=" => $id
        ]);

        if ($cariNama->countAllResults() > 0) {
            sendErrorMessage("Sudah ada siswa dengan nama sama");
            return redirect()->back();
        }

        $SiswaModel->save(
            [
                "id" => $id,
                "nama" => $name,
            ]
        );

        sendSuccessMessage("Siswa telah diperbarui");
        return redirect()->back();
    }

    public function siswa_delete()
    {
        $id = $this->request->getPost("id");

        $SiswaModel = model("Siswa");

        $SiswaModel->delete($id);

        sendSuccessMessage("Siswa telah dihapus");
        return redirect()->back();
    }
}
