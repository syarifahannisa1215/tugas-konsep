<?php
// Menghubungkan ke database
$conn = new mysqli("localhost", "root", "", "tugas_konsep");

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil ID peserta dari URL
$id = $_GET['id'];

// Mengambil data peserta dari database berdasarkan ID
$sql = "SELECT * FROM pendaftaran_kelas WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Proses update data peserta
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $update_sql = "UPDATE pendaftaran_kelas SET name='$name', email='$email', phone='$phone' WHERE id=$id";
    if ($conn->query($update_sql) === TRUE) {
        header("Location: daftar_peserta.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peserta</title>
    <style>
        /* Reset margin, padding, box-sizing */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', Arial, sans-serif;
        }

        /* Styling Body */
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

        /* Container styling */
        .content-container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }

        h2 {
            font-size: 2em;
            font-weight: bold;
            color: #8b5a2b;
            margin-bottom: 20px;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"], input[type="email"] {
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
            width: 100%;
        }

        input[type="text"]:focus, input[type="email"]:focus {
            border-color: #8b5a2b;
            outline: none;
        }

        button[type="submit"] {
            padding: 12px;
            background-color: #8b5a2b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #a07855;
        }

    </style>
</head>
<body>

    <div class="content-container">
        <h2>Edit Peserta</h2>
        <form method="POST">
            <input type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="Nama" required /><br>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" placeholder="Email" required /><br>
            <input type="text" name="phone" value="<?php echo $row['phone']; ?>" placeholder="Telepon" required /><br>
            <button type="submit" name="update">Update</button>
        </form>
    </div>

</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
