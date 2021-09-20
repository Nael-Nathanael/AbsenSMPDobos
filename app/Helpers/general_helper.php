<?php


function pageView(string $name, array $data = [], array $options = []): string
{
    return view("_pages/$name", $data, $options);
}

function sendSuccessMessage(string $message)
{
    session()->setFlashdata("success", $message);
}

function sendErrorMessage(string $message)
{
    session()->setFlashdata("error", $message);
}

function hasLogin()
{
    return session("userdata") !== null;
}

function isAdmin()
{
    return intval(session("userdata")->isAdmin) == 1;
}