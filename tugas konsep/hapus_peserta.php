<?php
// Menghubungkan ke database
$conn = new mysqli("localhost", "root", "", "tugas_konsep");

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil ID peserta dari URL
$id = $_GET['id'];

// Menghapus data peserta dari database
$sql = "DELETE FROM pendaftaran_kelas WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: daftar_peserta.php");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
