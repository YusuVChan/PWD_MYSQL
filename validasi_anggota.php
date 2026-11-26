<?php

/**
 * Mengembalikan daftar jenis anggota yang valid.
 *
 * @return array<int, string>
 */
function daftar_jenis_anggota(): array
{
    return ["Mahasiswa", "Dosen", "Tenaga Kependidikan"];
}

/**
 * Mengambil dan membersihkan input data anggota dari array POST.
 *
 * @param array<string, mixed> $post
 * @return array<string, string>
 */
function ambil_input_anggota(array $post): array
{
    $fields = ["no_anggota", "nama_lengkap", "email", "no_hp", "jenis_anggota", "alamat"];
    $data = [];

    foreach ($fields as $field) {
        $data[$field] = isset($post[$field]) ? trim((string) $post[$field]) : "";
    }

    return $data;
}

/**
 * Memvalidasi data anggota dan mengembalikan daftar pesan kesalahan.
 *
 * @param array<string, string> $data
 * @return array<int, string>
 */
function validasi_data_anggota(array $data): array
{
    $errors = [];

    if ($data["no_anggota"] === "") {
        $errors[] = "Nomor anggota tidak boleh kosong.";
    } elseif (!ctype_digit($data["no_anggota"])) {
        $errors[] = "Nomor anggota hanya boleh berisi angka.";
    } elseif (strlen($data["no_anggota"]) > 15) {
        $errors[] = "Nomor anggota maksimal 15 digit.";
    }

    if ($data["nama_lengkap"] === "") {
        $errors[] = "Nama lengkap tidak boleh kosong.";
    } elseif (strlen($data["nama_lengkap"]) > 100) {
        $errors[] = "Nama lengkap maksimal 100 karakter.";
    }

    if ($data["email"] === "") {
        $errors[] = "Email tidak boleh kosong.";
    } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    } elseif (strlen($data["email"]) > 100) {
        $errors[] = "Email maksimal 100 karakter.";
    }

    if ($data["no_hp"] === "") {
        $errors[] = "Nomor HP tidak boleh kosong.";
    } elseif (!ctype_digit($data["no_hp"])) {
        $errors[] = "Nomor HP hanya boleh berisi angka.";
    } elseif (strlen($data["no_hp"]) < 10 || strlen($data["no_hp"]) > 13) {
        $errors[] = "Nomor HP harus 10 sampai 13 digit.";
    }

    if ($data["jenis_anggota"] === "") {
        $errors[] = "Jenis anggota wajib dipilih.";
    } elseif (!in_array($data["jenis_anggota"], daftar_jenis_anggota(), true)) {
        $errors[] = "Jenis anggota tidak valid.";
    }

    if ($data["alamat"] === "") {
        $errors[] = "Alamat tidak boleh kosong.";
    }

    return $errors;
}
