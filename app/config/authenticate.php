<?php
session_start();

if (!isset($_SESSION) || !isset($_SESSION["id"]) || !isset($_SESSION["nome"])) {
    header("Location: /login/");
    exit;
}



?>