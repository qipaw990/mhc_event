<?php
// Menghubungkan ke file koneksi
include('../db_connection.php');

// Memeriksa apakah pengguna sudah login
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in";
    exit();
}

// Ambil data pengguna dari session
$user_id = $_SESSION['user_id'];

// Ambil data yang dikirim dari form
$nama_sekolah = $_POST['nama_sekolah'];
$nama_pendek = $_POST['nama_pendek'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$kepala_sekolah = $_POST['kepala_sekolah'];
$pelatih = $_POST['pelatih'];

// Periksa apakah profile anggota sudah ada
$sql = "SELECT * FROM profile_anggota WHERE users_id = '$user_id'";
$result = $conn->query($sql);
$profile = $result->fetch_assoc();

if (!$profile) {
    // Jika profile belum ada, buat profile baru
    $sql = "INSERT INTO profile_anggota (users_id, nama_sekolah, nama_pendek, email, phone, kepala_sekolah, pelatih)
            VALUES ('$user_id', '$nama_sekolah', '$nama_pendek', '$email', '$phone', '$kepala_sekolah', '$pelatih')";
} else {
    // Jika profile sudah ada, update data
    $sql = "UPDATE profile_anggota SET
            nama_sekolah = '$nama_sekolah',
            nama_pendek = '$nama_pendek',
            email = '$email',
            phone = '$phone',
            kepala_sekolah = '$kepala_sekolah',
            pelatih = '$pelatih'
            WHERE users_id = '$user_id'";
}

// Eksekusi query
if ($conn->query($sql) === TRUE) {
    echo "success";  // Kirim respons sukses jika berhasil
} else {
    echo "Error: " . $conn->error;  // Kirim respons error jika gagal
}
?>
