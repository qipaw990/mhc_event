<?php
// Menghubungkan ke file koneksi
include('db_connection.php');

// Proses registrasi jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi: Pastikan password dan konfirmasi password sama
    if ($password !== $confirm_password) {
        echo "<script>Swal.fire('Error!', 'Password dan konfirmasi password tidak cocok!', 'error');</script>";
    } else {
        // Query untuk memeriksa apakah email sudah terdaftar
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Email sudah terdaftar
            echo "<script>Swal.fire('Error!', 'Email sudah terdaftar!', 'error');</script>";
        } else {
            // Enkripsi password sebelum menyimpannya
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Upload foto jika ada
            $foto = null;
            if ($_FILES['foto']['name'] != "") {
                $foto = "uploads/" . basename($_FILES['foto']['name']);
                move_uploaded_file($_FILES['foto']['tmp_name'], $foto); // Menyimpan foto ke folder 'uploads'
            }

            // Query untuk menambahkan pengguna baru
            $insert_sql = "INSERT INTO users (name, email, phone, foto, password) VALUES ('$name', '$email', '$phone', '$foto', '$hashed_password')";
            
            if ($conn->query($insert_sql) === TRUE) {
                echo "<script>Swal.fire('Success!', 'Registrasi berhasil!', 'success');</script>";
                // Redirect ke halaman login
                header("Location: login.php");
            } else {
                echo "<script>Swal.fire('Error!', 'Terjadi kesalahan, coba lagi!', 'error');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register MHC Event App</title>
    <!-- Link CSS External atau Style Internal -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            display: flex;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 90%;
            max-width: 900px;
        }

        .left-side {
            flex: 1;
            background-image: url('https://via.placeholder.com/500x600');
            background-size: cover;
            background-position: center;
            height: 100%;
        }

        .right-side {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-width: 450px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: bold;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group input[type="file"] {
            padding: 5px;
        }

        .btn-primary {
            background-color: #3490f3;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #2e7fd6;
        }

        .text-center a {
            text-decoration: none;
            color: #3490f3;
            font-size: 14px;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        /* Media Queries untuk Responsif */
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                width: 100%;
                margin-top: 20px;
                margin-left: 15px;
                margin-right: 15px;
            }

            .left-side {
                height: 250px;
                background-size: cover;
                background-position: center;
            }

            .right-side {
                padding: 20px;
                max-width: 100%;
            }

            .form-group input {
                padding: 12px;
            }

            .btn-primary {
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            .left-side {
                height: 150px;
            }

            .form-group input {
                font-size: 16px;
            }

            .btn-primary {
                font-size: 18px;
                padding: 15px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="register-container">
        <!-- Left Side - Gambar -->
        <div class="left-side">
            <img src="https://via.placeholder.com/500x600" alt="Register Image">
        </div>

        <!-- Right Side - Form -->
        <div class="right-side">
            <h2 class="text-center">Register MHC Event App</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Nama Anda" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="admin@mhcevent.com" required>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Nomor Telepon" required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="********" required>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="********" required>
                </div>

                <!-- Foto -->
                <div class="form-group">
                    <label for="foto">Upload Foto (Optional)</label>
                    <input type="file" id="foto" name="foto">
                </div>

                <!-- Submit -->
                <div class="form-group">
                    <button type="submit" class="btn-primary">Register</button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-3">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>

</body>
</html>
