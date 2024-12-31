<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login MHC Event App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Styling untuk halaman login */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
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

        /* Responsif */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 100%;
                margin-top: 20px;
                margin-left: 15px;
                margin-right: 15px;
            }
            .left-side {
                height: 250px;
            }
            .right-side {
                padding: 20px;
            }
            .form-group input {
                padding: 12px;
            }
            .btn-primary {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- Left Side - Gambar -->
    <div class="left-side">
        <img src="https://pssikotabandung.or.id/public/uploads/all/iRG9cj09sGVjmHVCZmtBSM9oD0PHsaVbcugwRsOd.jpg" alt="">
    </div>

    <!-- Right Side - Form -->
    <div class="right-side">
        <h2 class="text-center">Login MHC Event App</h2>
        <form id="loginForm" method="POST" action="login_process.php">
            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="admin@mhcevent.com" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="********" required>
            </div>

            <!-- Submit -->
            <div class="form-group">
                <button type="submit" class="btn-primary">Login</button>
            </div>
        </form>

        <!-- Forgot Password Link -->
        <div class="text-center">
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
        <!-- Register Link -->
        <div class="text-center mt-3">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Menghandle form submit dengan jQuery
    $('#loginForm').submit(function(e) {
        e.preventDefault();  // Mencegah form submit biasa

        var email = $('#email').val();
        var password = $('#password').val();

        // Kirim data login ke server dengan AJAX
        $.ajax({
            type: 'POST',
            url: 'process/login_admin.php',  // Arahkan ke file login_process.php
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                console.log(response);
                if (response === 'success') {
                    // Jika login berhasil, arahkan ke dashboard
                    window.location.href = 'admin_dashboard.php';
                } else {
                    // Jika login gagal, tampilkan SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: 'Email atau password salah!',
                    });
                }
            }
        });
    });
});
</script>

</body>
</html>
