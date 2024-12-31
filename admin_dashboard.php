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

// Query untuk mendapatkan data statistik
// Total Users
$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = $conn->query($sql_users);
$total_users = $result_users->fetch_assoc()['total_users'];

// Total Pemain
$sql_pemain = "SELECT COUNT(*) AS total_pemain FROM pemain";
$result_pemain = $conn->query($sql_pemain);
$total_pemain = $result_pemain->fetch_assoc()['total_pemain'];

// Total Pertandingan
$sql_pertandingan = "SELECT COUNT(*) AS total_pertandingan FROM pertandingan";
$result_pertandingan = $conn->query($sql_pertandingan);
$total_pertandingan = $result_pertandingan->fetch_assoc()['total_pertandingan'];

// Pemain Verified
$sql_verified = "SELECT COUNT(*) AS pemain_verified FROM pemain WHERE status = 'verified'";
$result_verified = $conn->query($sql_verified);
$pemain_verified = $result_verified->fetch_assoc()['pemain_verified'];

// Pemain Rejected
$sql_rejected = "SELECT COUNT(*) AS pemain_rejected FROM pemain WHERE status = 'rejected'";
$result_rejected = $conn->query($sql_rejected);
$pemain_rejected = $result_rejected->fetch_assoc()['pemain_rejected'];

// Pemain Pending
$sql_pending = "SELECT COUNT(*) AS pemain_pending FROM pemain WHERE status = 'pending'";
$result_pending = $conn->query($sql_pending);
$pemain_pending = $result_pending->fetch_assoc()['pemain_pending'];

// Include header dan sidebar
include('templates_admin/header.php');
include('templates_admin/navbar.php');
include('templates_admin/sidebar.php');
?>

<!--begin::App Main-->
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <!-- Total Users -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3><?php echo $total_users; ?></h3>
                            <p>Total Users</p>
                        </div>
                        <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            </i>
                        </a>
                    </div>
                </div>

                <!-- Total Pemain -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3><?php echo $total_pemain; ?></h3>
                            <p>Total Pemain</p>
                        </div>
                        <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            </i>
                        </a>
                    </div>
                </div>

                <!-- Total Pertandingan -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3><?php echo $total_pertandingan; ?></h3>
                            <p>Total Pertandingan</p>
                        </div>
                        <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            </i>
                        </a>
                    </div>
                </div>

                <!-- Pemain Verified -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-info">
                        <div class="inner">
                            <h3><?php echo $pemain_verified; ?></h3>
                            <p>Pemain Verified</p>
                        </div>
                        <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            </i>
                        </a>
                    </div>
                </div>
            </div>
            <!--end::Row-->

            <!--begin::Row for rejected & pending pemain-->
            <div class="row">
                <!-- Pemain Rejected -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3><?php echo $pemain_rejected; ?></h3>
                            <p>Pemain Rejected</p>
                        </div>
                        <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            </i>
                        </a>
                    </div>
                </div>

                <!-- Pemain Pending -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-secondary">
                        <div class="inner">
                            <h3><?php echo $pemain_pending; ?></h3>
                            <p>Pemain Pending</p>
                        </div>
                        <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            </i>
                        </a>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>

<!-- Sidebar & Footer -->
<?php include('templates_admin/footer.php'); ?>
