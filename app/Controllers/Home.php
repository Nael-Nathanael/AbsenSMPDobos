<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (hasLogin()) {
            if (isAdmin()) {
                return redirect()->route("admin.panel");
            } else {
                return redirect()->route("absensi.kelas");
            }
        }
        return view("_pages/login.php");
    }

    public function login()
    {
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");

        $UsersModel = model("Users");
        $findUsername = $UsersModel->where(
            [
                "username" => $username
            ]
        )->countAllResults();

        if ($findUsername == 0) {
            sendErrorMessage("Nama pengguna tidak ditemukan");
            return redirect()->back()->withInput();
        }

        $findAccount = $UsersModel->where(
            [
                "username" => $username,
                "password" => md5($password)
            ]
        );

        if ($findAccount->countAllResults() == 0) {
            sendErrorMessage("Kata sandi salah");
            return redirect()->back()->withInput();
        }

        $account = $findAccount->get()->getFirstRow();

        session()->set("userdata", $account);

        if (intval($account->isAdmin) == 1) {
            return redirect()->route("admin.panel");
        }
        return redirect()->route("absensi.kelas");
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }
}
