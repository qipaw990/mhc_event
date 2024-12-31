<?php
// Memeriksa apakah pengguna sudah login
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Menghubungkan ke file koneksi
include('db_connection.php');

// Ambil data pengguna dari session
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Periksa jika profile_anggota sudah ada
$sql = "SELECT * FROM profile_anggota WHERE users_id = '$user_id'";
$result = $conn->query($sql);
$profile = $result->fetch_assoc();

include('templates/header.php');
include('templates/navbar.php');
include('templates/sidebar.php');
?>

<!--begin::App Main-->
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Profile Anggota</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile Anggota</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg rounded-3 border-0">
                        <div class="card-body">
                            <!-- Form untuk Profile Anggota -->
                            <form id="profileForm">
                                <!-- Nama Sekolah -->
                                <div class="mb-4 input-icon">
                                    <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-school"></i></span>
                                        <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" value="<?php echo isset($profile['nama_sekolah']) ? $profile['nama_sekolah'] : ''; ?>" required disabled>
                                    </div>
                                </div>

                                <!-- Nama Pendek -->
                                <div class="mb-4 input-icon">
                                    <label for="nama_pendek" class="form-label">Nama Pendek</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <input type="text" class="form-control" id="nama_pendek" name="nama_pendek" value="<?php echo isset($profile['nama_pendek']) ? $profile['nama_pendek'] : ''; ?>" required disabled>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-4 input-icon">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($profile['email']) ? $profile['email'] : ''; ?>" required disabled>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="mb-4 input-icon">
                                    <label for="phone" class="form-label">Phone</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo isset($profile['phone']) ? $profile['phone'] : ''; ?>" required disabled>
                                    </div>
                                </div>

                                <!-- Kepala Sekolah -->
                                <div class="mb-4 input-icon">
                                    <label for="kepala_sekolah" class="form-label">Kepala Sekolah</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>
                                        <input type="text" class="form-control" id="kepala_sekolah" name="kepala_sekolah" value="<?php echo isset($profile['kepala_sekolah']) ? $profile['kepala_sekolah'] : ''; ?>" required disabled>
                                    </div>
                                </div>

                                <!-- Pelatih -->
                                <div class="mb-4 input-icon">
                                    <label for="pelatih" class="form-label">Pelatih</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                        <input type="text" class="form-control" id="pelatih" name="pelatih" value="<?php echo isset($profile['pelatih']) ? $profile['pelatih'] : ''; ?>" required disabled>
                                    </div>
                                </div>

                                <!-- Tombol Simpan dan Edit ditempatkan di kanan -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary flat-button" id="saveButton" disabled>
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                    
                                    <button type="button" class="btn btn-warning flat-button ms-2" id="editButton">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                            </form>

                            <div id="responseMessage" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--end::App Main-->

<!-- Add the following CSS for the icons size adjustment -->
<style>
    .input-group-text i {
        font-size: 1.2rem; /* Adjust icon size to be proportional to the input field */
    }

    /* Styling for the card */
    .card {
        border-radius: 15px; /* Rounded corners for the card */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Soft shadow for the card */
    }

    .input-group-text {
        background-color: #f7f7f7;
        border-right: none;
    }

    .form-control {
        border-radius: 10px; /* Rounded corners for inputs */
        box-shadow: none;
    }

    .form-label {
        font-weight: bold;
        color: #444;
    }

    /* Flat button styles */
    .flat-button {
        border: none;
        box-shadow: none;
        padding-left: 15px;
        padding-right: 15px;
        display: flex;
        align-items: center;
        border-radius: 10px;
    }

    .flat-button i {
        margin-right: 8px;
    }

    .flat-button:hover {
        background-color: #f0ad4e;
        color: white;
    }

    .flat-button:focus {
        outline: none;
    }

    /* Responsive adjustments */
    @media (max-width: 767px) {
        .form-label {
            font-size: 14px;
        }

        .input-group-text i {
            font-size: 1rem;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Tombol Edit klik
    $('#editButton').on('click', function() {
        // Mengaktifkan form input
        $('input').prop('disabled', false);
        $('button[type="submit"]').prop('disabled', false); // Mengaktifkan tombol simpan
        $('#editButton').hide();  // Menyembunyikan tombol edit setelah diklik
    });

    // Submit form dengan AJAX
    $('#profileForm').on('submit', function(event) {
        event.preventDefault();  // Mencegah form untuk submit secara biasa

        var formData = $(this).serialize();  // Ambil data form

        $.ajax({
            type: "POST",
            url: "process/profile_process.php",  // Arahkan ke file process.php untuk memproses data
            data: formData,
            success: function(response) {
                // Tampilkan SweetAlert2 Toast jika berhasil
                if (response === "success") {
                    Swal.fire({
                        position: 'top-end',  // Posisi Toast
                        icon: 'success',  // Ikon success
                        title: 'Profile updated successfully!',  // Pesan
                        showConfirmButton: false,  // Menyembunyikan tombol konfirmasi
                        toast: true,  // Mengaktifkan Toast
                        timer: 3000  // Durasi tampilan Toast (3 detik)
                    });

                    // Disable input fields and show the Edit button again
                    $('input').prop('disabled', true);  // Disable all inputs
                    $('#saveButton').prop('disabled', true);  // Disable Save button
                    $('#editButton').show();  // Show the Edit button
                }
            },
            error: function() {
                // Tampilkan SweetAlert2 Toast error jika gagal
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error occurred while updating profile.',
                    showConfirmButton: false,
                    toast: true,
                    timer: 3000
                });
            }
        });
    });
</script>

<?php include('templates/footer.php'); ?>


