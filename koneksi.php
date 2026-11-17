<?php

mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$password = "";
$database = "db_perpustakaan";

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . htmlspecialchars(mysqli_connect_error()));
} else {

echo "Koneksi berhasilll ke database $database";

mysqli_set_charset($koneksi, "utf8mb4");




}

