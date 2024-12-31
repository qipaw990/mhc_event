<?php
// Memeriksa apakah pengguna sudah login
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Menghubungkan ke file koneksi
include('db_connection.php');
// Ambil data pengguna dari session atau database
$admin_id = $_SESSION['admin_id'];
$sql = "SELECT * FROM admin_users WHERE id = '$admin_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
// Ambil data pemain berdasarkan id yang diteruskan dari URL
if (isset($_GET['id'])) {
    $player_id = $_GET['id'];

    // Query untuk mendapatkan detail pemain berdasarkan ID
    $sql = "SELECT * FROM pemain WHERE id = '$player_id'";
    $result = $conn->query($sql);
    $player = $result->fetch_assoc();

    if (!$player) {
        // Jika pemain tidak ditemukan
        header('Location: players.php');
        exit();
    }
} else {
    header('Location: players.php');
    exit();
}

// Menyertakan header dan navbar
include('templates_admin/header.php');
include('templates_admin/navbar.php');
include('templates_admin/sidebar.php');
?>

<!--begin::App Main-->
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><i class="fas fa-user-circle"></i> Detail Pemain</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="players.php"><i class="fas fa-users"></i> Data Pemain</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-info-circle"></i> Detail Pemain</li>
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
                        <div class="card-header">
                            <h5 class="card-title"><i class="fas fa-user-edit"></i> Detail Pemain</h5>
                        </div>
                        <div class="card-body">
                            <!-- Menampilkan Detail Pemain -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><i class="fas fa-user"></i> Nama: <?php echo $player['nama']; ?></h5>
                                    <p><strong><i class="fas fa-futbol"></i> No. Punggung:</strong> <?php echo $player['no_punggung']; ?></p>
                                    <p><strong><i class="fas fa-venus-mars"></i> Gender:</strong> <?php echo ucfirst($player['gender']); ?></p>
                                    <p><strong><i class="fas fa-calendar-alt"></i> Tanggal Lahir:</strong> <?php echo $player['tanggal_lahir']; ?></p>
                                    <p><strong><i class="fas fa-map-marker-alt"></i> Tempat Lahir:</strong> <?php echo $player['tempat_lahir']; ?></p>
                                    <p><strong><i class="fas fa-users"></i> Nama Orangtua:</strong> <?php echo $player['nama_orangtua']; ?></p>
                                    <p><strong><i class="fas fa-id-card"></i> NIK:</strong> <?php echo $player['nik']; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-home"></i> Alamat:</strong> <?php echo $player['alamat']; ?></p>
                                    <p><strong><i class="fas fa-city"></i> Domisili:</strong> <?php echo $player['domisili']; ?></p>
                                    <p><strong><i class="fas fa-envelope"></i> Email:</strong> <?php echo $player['email']; ?></p>
                                    <p><strong><i class="fas fa-phone-alt"></i> Phone Number:</strong> <?php echo $player['phone_number']; ?></p>
                                    <p><strong><i class="fas fa-weight-hanging"></i> Berat Badan:</strong> <?php echo $player['berat_badan']; ?> kg</p>
                                    <p><strong><i class="fas fa-ruler-vertical"></i> Tinggi Badan:</strong> <?php echo $player['tinggi_badan']; ?> cm</p>
                                    <p><strong><i class="fas fa-check-circle"></i> Status:</strong> <?php echo ucfirst($player['status']); ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <p><strong><i class="fas fa-image"></i> Foto:</strong></p>
                                    <img src="process/<?php echo $player['foto']; ?>" alt="Foto Pemain" class="img-fluid">
                                </div>
                                <div class="col-md-3">
                                    <p><strong><i class="fas fa-id-card-alt"></i> KTP:</strong></p>
                                    <img src="process/<?php echo $player['ktp']; ?>" alt="KTP Pemain" class="img-fluid">
                                </div>
                                <div class="col-md-3">
                                    <p><strong><i class="fas fa-users-cog"></i> Kartu Keluarga:</strong></p>
                                    <img src="process/<?php echo $player['kartu_keluarga']; ?>" alt="Kartu Keluarga" class="img-fluid">
                                </div>
                                <div class="col-md-3">
                                    <p><strong><i class="fas fa-certificate"></i> Akta Kelahiran:</strong></p>
                                    <img src="process/<?php echo $player['akta_kelahiran']; ?>" alt="Akta Kelahiran" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--end::App Main-->

<?php include('templates_admin/footer.php'); ?>
