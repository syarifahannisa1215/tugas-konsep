<?php
// Mengecek apakah form telah dikirim dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form dan sanitasi input
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = substr(preg_replace("/[^0-9]/", '', $_POST["phone"]), 0, 13);

    // Menghubungkan ke database
    $conn = new mysqli("localhost", "root", "", "tugas_konsep");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error); // Mengcek apakah koneksi gagal
    }

    // Menyiapkan prepared statement untuk mencegah SQL injection
    $stmt = $conn->prepare("INSERT INTO pendaftaran_kelas (name, email, phone) VALUES (?, ?, ?)");
    
    // Menangani error jika query gagal disiapkan
    if ($stmt === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $phone); // Mengikat parameter

    // Menjalankan query dan mengecek apakah berhasil
    if ($stmt->execute()) {
        header("Location: index.html"); // Redirect ke halaman utama jika berhasil
        exit();
    } else {
        echo "Error: " . $stmt->error; // Menampilkan pesan kesalahan jika gagal
    }

    // Menutup koneksi dan statement
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengguna</title>
    <style>
        /* Mengatur gaya umum untuk body */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', Arial, sans-serif;
        }

        body {
            background-color: #f3ece4; /* Soft cream background */
            color: #5c4033; /* Dark brown text */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Mengatur gaya container form */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        /* Mengatur label input dan spasi antar elemen */
        form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Mengatur gaya tombol submit */
        form button {
            width: 100%;
            padding: 10px;
            background-color: #8b5a2b; /* Medium brown */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Mengatur gaya tombol submit saat di-hover */
        form button:hover {
            background-color: #a07855; /* Light brown */
        }

        /* Mengatur gaya teks label */
        form label {
            font-weight: bold;
            color: #8b5a2b; /* Medium brown for labels */
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <label>Nama:</label> <input type="text" name="name" required><br>
        <label>Email:</label> <input type="email" name="email" required><br>
        <label>Telepon:</label> <input type="text" name="phone" required><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
