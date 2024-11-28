<?php
// Menghubungkan ke database
$conn = new mysqli("localhost", "root", "", "tugas_konsep");

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses pencarian
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Mengambil data peserta dengan pencarian (jika ada)
$sql = "SELECT id, name, email, phone FROM pendaftaran_kelas WHERE name LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peserta</title>
    <style>
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
            padding: 20px;
            flex-direction: column;
            text-align: center;
        }

        .content-container {
            width: 100%;
            max-width: 1200px;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .title-container h2 {
            font-size: 2.5em;
            font-weight: bold;
            color: #8b5a2b;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #8b5a2b;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td a {
            text-decoration: none;
            color: #5c4033;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
        }

        td a:hover {
            background-color: #a07855;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn-edit {
            padding: 8px 15px;
            background-color: #5c4033;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-edit:hover {
            background-color: #8b5a2b;
        }

        .btn-delete {
            padding: 8px 15px;
            background-color: #d9534f;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-delete:hover {
            background-color: #c9302c;
        }

        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-container input {
            padding: 10px;
            width: 60%;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .search-container button {
            padding: 10px;
            background-color: #8b5a2b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .search-container button:hover {
            background-color: #a07855;
        }
    </style>
</head>
<body>

    <!-- Container untuk judul dan tabel -->
    <div class="content-container">
        <!-- Container untuk judul -->
        <div class="title-container">
            <h2>Daftar Peserta Kelas Baking</h2>
        </div>

        <!-- Form Pencarian di bawah judul -->
        <div class="search-container">
            <form action="daftar_peserta.php" method="POST">
                <input type="text" name="search" placeholder="Cari peserta..." value="<?php echo $search; ?>" />
                <button type="submit">Cari</button>
            </form>
        </div>

        <!-- Tabel Daftar Peserta -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Menampilkan data setiap baris
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td class='action-buttons'>
                                <a href='edit_peserta.php?id=" . $row["id"] . "' class='btn-edit'>Edit</a>
                                <a href='hapus_peserta.php?id=" . $row["id"] . "' class='btn-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data peserta</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
    // Menutup koneksi
    $conn->close();
    ?>

</body>
</html>
